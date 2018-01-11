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

    $informacion_adicional = new Informacion();
    //Comprueba si ya se había subido un archivo de información extra
    if(!$informacion_adicional->existInformation($id_video)){
        $informacion_adicional->newInformation($id_video, file_get_contents($_FILES['file']['tmp_name']), $fileType, $filesize);
        echo "Información adicional subido con éxito.";       
    }else{
        echo 'Ya existe información adicional adjuntada a este vídeo';
    }

}else{
    echo $message;
}
?>
