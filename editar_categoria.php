<?php

require_once("src/logic/Videos.php");
require_once("src/logic/Categorias.php");
require_once("src/App.php");

$rol = isAdmin(); //Return session admin or null

if(!is_null($rol)){

    $category = $_POST['id_categoria'];
    $accion = $_POST['accion']; 

    //Insertamos en la base de datos
    $categorias = new Categorias();
    $categorias->updateCategory($category, $accion);

}else{
    redirect("index.php");
}

?>