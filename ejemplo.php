<?php
// require 'simple_html_dom.php';
// $IDsVideosCategory = array();
// $url = 'https://zaragozalinguistica.wordpress.com/charlas-de-zl-en-video/';
// $html = file_get_html( $url );
// $categories = $html->find('div[class=entry-content] ol li');

// foreach( $categories as $category ){
//         $link = $category->find('a', 0);
//         $href = $link->href; // ENLACES DE CADA CATEGORÍA
//         $htmlCategory = file_get_html($href);
//         $listVideos = $htmlCategory->find('div[class=entry-content] p a');
//         foreach ($listVideos as $video) {
//             $hrefVideo = $video->href;
//             //echo $titleVideo . "\n";

//             $urlVideo = $hrefVideo;
//             $htmlVideo = file_get_html($urlVideo);

//             foreach ($htmlVideo->find('head meta[property=og:image]') as $element) {
//               $cadena = explode("/", $element->content);
//               echo $cadena[4] . "<br>";
//             }
//         }
// }

$category = "canción";

$categoria = str_replace(array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ","´p"),
                                             array("&aacute","&eacute","&iacute","&oacute","&uacute","&ntilde",
                                                        "&Aacute","&Eacute","&Iacute","&Oacute","&Uacute","&Ntilde", "&Ntilde"), $category);

var_dump($categoria);
?>
