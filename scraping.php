<?php
require 'simple_html_dom.php';

function multiexplode ($delimiters,$string) {
    
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}




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

//echo getAllCategories()[0];


function getIDsVideos($idCategory){
    $IDsVideosCategory = array();
    $url = 'https://zaragozalinguistica.wordpress.com/charlas-de-zl-en-video/';
    $html = file_get_html( $url );
    $categories = $html->find('div[class=entry-content] ol');

    foreach( $categories as $category ){
            $link = $category->find('li a',$idCategory);
            $href = $link->href; // ENLACES DE CADA CATEGORÍA
            //$title = $link->innertext; // NOMBRE DE LAS CATEGORÍAS
            //echo $title . "\n\n";
            //echo $href. "\n";

            $urlCategory = $href;
            $htmlCategory = file_get_html($urlCategory);
            $listVideos = $htmlCategory->find('div[class=entry-content] p a');
            foreach ($listVideos as $video) {
                $hrefVideo = $video->href;
                //$titleVideo = $video->innertext;
                //echo $titleVideo . "\n";

                $urlVideo = $hrefVideo;
                $htmlVideo = file_get_html($urlVideo);
                $videoPlayer = $htmlVideo->find('iframe[class=youtube-player]');

                foreach( $videoPlayer as $idVideo ){
                    $src = $idVideo->attr['src'];
                    $result = explode('?', $src);
                    $r = explode('/embed/', $result[0]);
                    //$r = multiexplode(array("/embed/","?"),$src);
                    //echo $r[1] . "\n";
                    array_push($IDsVideosCategory, $r[1]);
                    //$id = multiexplode(array("/embed/","?"),$src);
                    //echo $id[1] . "\n";

                }
            }

    //echo count($IDsVideosCategory);
    }
    return $IDsVideosCategory;
}

//getIDsVideos(1);

?>