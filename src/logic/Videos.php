<?php

include "src/dao/DAOVideos.php";

Class Videos{

    private $daoVideos;

    function Videos() {
        $this->daoVideos = new DAOVideos();
    }

    function listCategories($category){
        $listVideos = $this->daoVideos->getVideosOfCategory($category);
        return $listVideos;
    }


    function setVideosWithCategory($category, $IdsVideos, $nameVideo){
        for ($i=0; $i < count($IdsVideos) - 1; $i++) { 
            if(empty($this->daoVideos->checkVideoById($IdsVideos[$i]))){
                echo 'INSERTO EN Videos.php';
                $this->daoVideos->setVideosWithCategory($IdsVideos[$i], utf8_decode($nameVideo[$i]), $category);
            }else{
                // Actualiza el id de la categoría del vídeo
                echo 'No inserto en Videos.php';
                $this->daoVideos->updateCategory($IdsVideos[$i], $category);
            }
        }
    }
    
    function setVideosCategory($category, $id_video, $title_video){
        $this->daoVideos->setVideosWithCategory($id_video, $title_video, $category);
    }

    function insertNewVideo($id_video, $title_video){
        // SI EL VÍDEO YA ESTABA EN LA BBDD NO HACE FALTA VOLVER A INSERTARLO
        if(empty($this->daoVideos->checkVideoById($id_video))){
            $this->daoVideos->setVideosWithCategory($id_video, utf8_decode($title_video), "0");
        }
    }

    function getAllVideos(){
        return $this->daoVideos->getAllVideos();
    }

    function resetAutoIncrement(){
        $this->daoVideos->resetAutoIncrement();
    }
}
?>