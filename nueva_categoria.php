<?php

require_once("src/logic/Videos.php");
require_once("src/App.php");
$category = $_POST['nombreCategoria'];
$IdsVideos = $_POST['IdsVideos']; 
$nameVideo = $_POST['nombreVideo']; 

// Separamos los Ids de vídeos
$array_ids = array();
$array_ids = explode('|', $IdsVideos);

//Separamos los nombres de los vídeos
$array_name_videos = array();
$array_name_videos = explode('|', $nameVideo);


//Insertamos en la base de datos
$videos = new Videos();

$videos->setVideosWithCategory($category, $array_ids, $array_name_videos);

redirect("conjunto_categorias.php");




/*
echo '<div class="features">
        <article>
            <span class="icon fa fa-plus small"></span>
            <div class="content">
                <h4><a data-toggle="modal" data-target="#myModal">'. $category .'</a></h4>
            </div>
        </article>
    </div>';
*/






?>