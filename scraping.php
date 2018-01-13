<?php
require 'simple_html_dom.php';

set_time_limit(300);

function multiexplode ($delimiters,$string) {    
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}



/* Método que devuelve todas las categorías del blog */
function getAllCategories(){
    $allCategories = array();
    $url = 'https://zaragozalinguistica.wordpress.com/charlas-de-zl-en-video/';
    $html = file_get_html( $url );
    $categories = $html->find('div[class=entry-content] ol li');

    foreach( $categories as $category ){
        $link = $category->find('a',0);
        $title = $link->innertext; // NOMBRE DE LAS CATEGORÍAS
        array_push($allCategories, $title);
    }
    return $allCategories;
}

/* Método que devuelve los IDs de vídeos  de una categoría del blog */
function getIDsVideos($idCategory){
    $IDsVideosCategory = array();
    $url = 'https://zaragozalinguistica.wordpress.com/charlas-de-zl-en-video/';
    $html = file_get_html( $url );
    $categories = $html->find('div[class=entry-content] ol');

    foreach( $categories as $category ){
            $link = $category->find('li a',$idCategory);
            $urlCategory = $link->href; 
            $htmlCategory = file_get_html($urlCategory);
            $listVideos = $htmlCategory->find('div[class=entry-content] p a');
            foreach ($listVideos as $video) {
                $urlVideo = $video->href;
                $titleVideo = $video->innertext;
                $htmlVideo = file_get_html($urlVideo);
                foreach ($htmlVideo->find('meta[property=og:image]') as $element) {
                    $cadena = explode("/", $element->content);
                    array_push($IDsVideosCategory, array($cadena[4], $titleVideo));
                  }
            }
    }
    return $IDsVideosCategory;
}
?>