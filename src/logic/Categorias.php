<?php

include "src/dao/DAOCategorias.php";

Class Categorias{

    private $daoCategorias;

    function Categorias() {
        $this->daoCategorias = new DAOCategorias();
    }

    function getCategories(){
        return  $this->daoCategorias->getCategories();
    }

    function setCategory($category){
       return $this->daoCategorias->setNewCategory($category);        
    }

}
?>