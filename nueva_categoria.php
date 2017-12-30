<?php

require_once("src/logic/Videos.php");
require_once("src/logic/Categorias.php");
require_once("src/App.php");

$rol = isAdmin(); //Return session admin or null

if(!is_null($rol)){

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
    $categorias = new Categorias();
    $videos = new Videos();

    $id_categoria = $categorias->setCategory($category);
    $videos->setVideosWithCategory($id_categoria, $array_ids, $array_name_videos);

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
}else{
    redirect("index.php");
}

?>