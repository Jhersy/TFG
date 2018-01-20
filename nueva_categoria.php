<?php
require_once("src/logic/Videos.php");
require_once("src/logic/Categorias.php");
require_once("src/App.php");

/* AÑADE UNA NUEVA CATEGORÍA CON SUS VÍDEOS */


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

    $id_categoria = $categorias->setCategory($category, '0');
    $videos->setVideosWithCategory($id_categoria, $array_ids, $array_name_videos);

}else{
    redirect("index.php");
}

?>