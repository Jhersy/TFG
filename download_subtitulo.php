<?php
$filename = "yourfile.srt";
$content = "HOLA TEXT";
$f = fopen($filename, 'w');
fwrite($f, $content);
fclose($f);

header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Length: ". filesize("$filename").";");
header("Content-Disposition: attachment; filename=$filename");
header("Content-Type: application/octet-stream; "); 
header("Content-Transfer-Encoding: binary");

readfile($filename);
?>