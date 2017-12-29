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

            $categoria =  str_replace(array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ","´p"),
                                            array("&aacute","&eacute","&iacute","&oacute","&uacute","&ntilde",
                                                    "&Aacute","&Eacute","&Iacute","&Oacute","&Uacute","&Ntilde", "&Ntilde"), $category);    


       return $this->daoCategorias->setNewCategory($categoria);        
    }

    function getCategoriesVisibles(){
        return  $this->daoCategorias->getCategoriesVisible();
    }

    function getVideosOfCategory($id_categoria){
        return $this->daoCategorias->getVideosOfCategory($id_categoria);
    }

    function updateCategory($id_categoria, $visible){
        return $this->daoCategorias->updateCategory($id_categoria, $visible);
    }

    function disableCategories(){
        return $this->daoCategorias->disableCategories();
    }
}
?>