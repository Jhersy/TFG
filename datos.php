<?php
require_once('scraping.php');
require_once('src/logic/Categorias.php');
require_once('src/logic/Videos.php');

$categorias = array();
$categorias = getAllCategories();

//Clases para inserción en BBDD
$categoriaBBDD = new Categorias();

$videosBBDD = new Videos();
$videosCategoria = array();
$i = 0;
$j = 1;
foreach ($categorias as $categoria) {
    //Inserta las categorías del blog 
    $categoriaBBDD->setCategory($categoria, '1');

    //Recopilamos los IDs de los vídeos de cada categoría
    $videosCategoria = getIDsVideos($i);

    foreach ($videosCategoria as $videoCategoria) {
        //Inserta los vídeos de cada categoría del blog        
        $videosBBDD->setVideosCategory($j, $videoCategoria[0], $videoCategoria[1]);
    }
    
    $i++;
    $j++;
}

?>