<?php

require_once("src/logic/Videos.php");
require_once("src/logic/Categorias.php");
require_once("src/App.php");

$rol = isAdmin(); //Return session admin or null

if(!is_null($rol)){

    if( isset($_POST['id_categoria'])){
        $category = $_POST['id_categoria'];
    }
    if( isset($_POST['accion'])){
        $category = $_POST['accion'];
    }
    $visibleBlog = 0;
    if( isset($_POST['visibleBlog']) ){
        $visibleBlog = $_POST['visibleBlog'];
    }

    $categorias = new Categorias();
    
    if(!$visibleBlog){
        //Actualiza la categoría a Visible o No Visible en la web en la base de datos        
        $categorias->updateCategory($category, $accion);
    }else{
        $categorias->disableCategories();
    }


}else{
    redirect("index.php");
}

?>