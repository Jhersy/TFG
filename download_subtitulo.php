<?php

require_once("src/logic/Subtitulos.php");
$id_subtitulo =  $_POST["id_video"];
$idioma =  $_POST["idioma"];

$subtitulos = new Subtitulos();
$content = $subtitulos->getCaption($id_subtitulo, $idioma);
$titleCaption = $subtitulos->getTitleCaption($id_subtitulo);

$caracteres = array("?", "¿");
$titulo = str_replace($caracteres, "", $titleCaption[0]['titulo']);
$filename = str_replace( array(" ", ","),  "_", $titulo) . ".srt"; // "yourfile.srt";
$f = fopen($filename, 'w');
fwrite($f, $content[0]['archivo']);
fclose($f);

header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Length: ". filesize("$filename").";");
header("Content-Disposition: attachment; filename=$filename");
header("Content-Type: application/octet-stream; "); 
header("Content-Transfer-Encoding: binary");

readfile($filename);

?>