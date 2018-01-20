<?php

require_once("src/logic/Categorias.php");
require_once("src/App.php");

$rol = isAdmin(); //Return session admin or null

if (!is_null($rol)) {
    
    if (isset($_POST['id_categoria'])) {
        $category = $_POST['id_categoria'];
    }
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    }
    
    $categorias = new Categorias();
    
    if ($category != '' && $accion != '') {
        //Actualiza la categoría a Visible o No Visible en la web en la base de datos        
        $categorias->updateCategory($category, $accion);
        if ($accion == '0') {
            echo 'Categoría no visible en la página principal';
        } else {
            echo 'Categoría visible en la página principal';
        }
    }
    
    
} else {
    redirect("index.php");
}

?>