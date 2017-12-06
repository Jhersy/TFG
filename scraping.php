<?php
require 'simple_html_dom.php';

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
        //echo $title . "\n\n";
        array_push($allCategories, $title);
    }
    return $allCategories;
}

/* Método que devuelve el nombre de una categoría específica */
function getNameCategory($idCategory){
    $allCategories = array();
    $url = 'https://zaragozalinguistica.wordpress.com/charlas-de-zl-en-video/';
    $html = file_get_html( $url );
    $categories = $html->find('div[class=entry-content] ol li');
    $title = "";
        $link = $categories[$idCategory]->find('a',0);
        $title = $link->innertext; // NOMBRE DE LAS CATEGORÍAS
    return $title;
}

//echo getAllCategories()[0];

/* Método que devuelve los IDs de vídeos  de una categoría del blog */
function getIDsVideos($idCategory){
    $IDsVideosCategory = array();
    $url = 'https://zaragozalinguistica.wordpress.com/charlas-de-zl-en-video/';
    $html = file_get_html( $url );
    $categories = $html->find('div[class=entry-content] ol');

    foreach( $categories as $category ){
            $link = $category->find('li a',$idCategory);
            $href = $link->href; 

            $urlCategory = $href;
            $htmlCategory = file_get_html($urlCategory);
            $listVideos = $htmlCategory->find('div[class=entry-content] p a');
            foreach ($listVideos as $video) {
                $hrefVideo = $video->href;

                $urlVideo = $hrefVideo;
                $htmlVideo = file_get_html($urlVideo);
                $videoPlayer = $htmlVideo->find('iframe[class=youtube-player]');

                foreach( $videoPlayer as $idVideo ){
                    $src = $idVideo->attr['src'];
                    $r = multiexplode(array("/embed/","?"),$src);
                    array_push($IDsVideosCategory, $r[1]);
                }
            }
    }
    return $IDsVideosCategory;
}

/* Devuelve TODOS los IDs de vídeo del blog */
function getAllIDsVideos(){

    $IDsVideosCategory = array();
    $url = 'https://zaragozalinguistica.wordpress.com/charlas-de-zl-en-video/';
    $html = file_get_html( $url );
    $categories = $html->find('div[class=entry-content] ol li');

    foreach( $categories as $category ){
            $link = $category->find('a', 0);
            $href = $link->href; // ENLACES DE CADA CATEGORÍA
            $htmlCategory = file_get_html($href);
            $listVideos = $htmlCategory->find('div[class=entry-content] p a');
            foreach ($listVideos as $video) {
                $hrefVideo = $video->href;
                $titleVideo = $video->innertext;
                //echo $titleVideo . "\n";

                $urlVideo = $hrefVideo;
                $htmlVideo = file_get_html($urlVideo);
                $videoPlayer = $htmlVideo->find('iframe[class=youtube-player]');

                foreach( $videoPlayer as $idVideo ){
                    $src = $idVideo->attr['src'];
                    $r = multiexplode(array("/embed/","?"),$src);

                    array_push($IDsVideosCategory,  array($r[1], $titleVideo));
                }
            }
    }

    return $IDsVideosCategory;
}



?>