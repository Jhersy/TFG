<?php

class MyException extends Exception { }
class ExcepcionArchivo extends Exception { }

require_once("src/logic/Subtitulos.php");
require_once("src/logic/Videos.php");



isset($_POST["subtitulos"]) ? $eliminar_sub = $_POST["subtitulos"] : $eliminar_sub = "";


if(!empty($eliminar_sub)){
    $subtitulos = new Subtitulos();
    $errorEliminados = false;
    $subs = explode(",", $eliminar_sub);
    foreach ($subs as $sub) {
            if(!empty($sub)){
                $caption = explode("|", $sub);
                if(!$subtitulos->deleteCaption($caption[0], $caption[1])){
                    $errorEliminados = true;
                }
            }

    }
    if($errorEliminados)
        echo 'Error al eliminar';
    else
        echo 'Subtítulo/s eliminados';
     
}else{

    isset($_GET["id"]) ? $id_video = $_GET["id"] : $user = "";
    isset($_GET["title"]) ? $title_video = $_GET["title"] : $title_video = "";
    isset($_GET["idioma"]) ? $idioma = $_GET["idioma"] : $idioma = "";


    // $id_video = $_GET["id"];
    // $title_video = $_GET["title"];
    // $idioma = $_GET["idioma"];


    $fileName = $_FILES['file']['name'];
    $fileType = $_FILES['file']['type'];
    $fileError = $_FILES['file']['error'];
    // $fileId = $_FILES['id_video'];
    // $fileContent = file_get_contents($_FILES['file']['tmp_name']);
    //$lines = file($_FILES['file']['tmp_name']);



    $message = "";

    switch( $fileError ) {
        case UPLOAD_ERR_OK:
            $message = false;
            break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $message .= ' - file too large (limit of '.get_max_upload().' bytes).';
            break;
        case UPLOAD_ERR_PARTIAL:
            $message .= ' - file upload was not completed.';
            break;
        case UPLOAD_ERR_NO_FILE:
            $message .= ' - zero-length file uploaded.';
            break;
        default:
            $message .= ' - internal error #'.$_FILES['newfile']['error'];
            break;
    }

    if( !$message ) { 

        define('SRT_STATE_SUBNUMBER', 0);
        define('SRT_STATE_TIME',      1);
        define('SRT_STATE_TEXT',      2);
        define('SRT_STATE_BLANK',     3);

        try{

            $lines = file($_FILES['file']['tmp_name']);
            $numLine  = 1;
            $subs    = array();
            $longtext = "";
            $state   = SRT_STATE_SUBNUMBER;
            $subNum  = 0;
            $subText = '';
            $subTime = '';
            try{
                foreach($lines as $line) {
                    switch($state) {
                        case SRT_STATE_SUBNUMBER:
                            $subNum = trim($line);
                            if(!is_numeric($subNum)){
                                throw new ExcepcionArchivo('Línea ' .  $numLine . ' no es un número! ');
                            }
                            $state  = SRT_STATE_TIME;
                            break;

                        case SRT_STATE_TIME:
                            $subTime = trim($line);
                            $state   = SRT_STATE_TEXT;
                            break;

                        case SRT_STATE_TEXT:
                            if (trim($line) == '') {                             

                                    // try{
                                        $sub = new stdClass;
                                        $sub->number = $subNum;    
                                        list($sub->startTime, $sub->stopTime) = explode(' --> ', $subTime);
                                        $sub->text   = $subText;
                                        $subText     = '';
                                        $state       = SRT_STATE_SUBNUMBER;    
                                        $subs[]      = $sub;
                                        
                                    // } catch(Exception $e){
                                    //     throw new ExcepcionArchivo('Línea ' .  $numLine . ' no tiene formato de segundos!');
                                    //     throw $e;
                                    // }


                            } else {
                                $subText .= $line;
                            }
                            break;
                    }
                    $numLine++;
                }

                if ($state == SRT_STATE_TEXT) {
                    $sub->text = $subText;
                    $subs[] = $sub;
                }
                // print_r($subs);
                $videos = new Videos();
                //Si no está el video lo inserto, sino no lo actualizo
                $videos->insertNewVideo($id_video, $title_video);

                $subtitulos = new Subtitulos();
                $subtitulos->newCaption($id_video, file_get_contents($_FILES['file']['tmp_name']), $idioma);
                echo "Subtítulo subido con éxito";
            }catch(MyException $e){
                throw $e;
            }

        }catch(Exception $e){
            echo "Error en el archivo adjunto\n\n" . $e->getMessage() . "\n\nFormato correcto:\n  Número de subtítulo (Empezando en 1 para el primer subtítulo) \n  Tiempo inicial --> Tiempo final (Formato: mm:ss,ms) \n  Texto del subtítulo \n  Línea en blanco \n" ;
        }
    }else{
        echo  $message;
    }


    
}
?>