<?php

require_once("src/logic/Informacion.php");
require_once("src/logic/Videos.php");


$id_video = $_GET["id"];
$title_video = $_GET["title"];
$tipo = $_GET["tipo"];

$fileName = $_FILES['file']['name'];
$fileType = $_FILES['file']['type'];
$fileError = $_FILES['file']['error'];
$filesize = $_FILES['file']['size'];


$message = $fileName;

switch( $fileError ) {
    case UPLOAD_ERR_OK:
        $message = false;
        break;
    case UPLOAD_ERR_INI_SIZE:
    case UPLOAD_ERR_FORM_SIZE:
        $message .= ' - archivo demasiado grande (limite de '. ini_get('upload_max_filesize').' bytes).';
        break;
    case UPLOAD_ERR_PARTIAL:
        $message .= ' - la subida del archivo no fue completada con éxito.';
        break;
    case UPLOAD_ERR_NO_FILE:
        $message .= ' - archivo subido con longitud cero.';
        break;
}

if( !$message ) { 


    $videos = new Videos();
    //Si no está el video lo inserto, sino no lo actualizo
    $videos->insertNewVideo($id_video, $title_video);

    $informacion_adicional = new Informacion();
    $informacion_adicional->newInformation($id_video, file_get_contents($_FILES['file']['tmp_name']), $fileType, $filesize);
    echo "Información adicional subido con éxito.";


    // $texto = base64_encode($res[0]['audio']);


    //  echo '<a download="file_downloaded_via_data_URL.txt" href="data:text/plain;base64,' . $texto . '">
    //      Download text file
    //  </a>';        

    }else{
        echo $message;
    }
?>
