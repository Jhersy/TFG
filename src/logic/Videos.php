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

    //Cuando se crea una nueva categoría con uno o más vídeos
    function setVideosWithCategory($category, $IdsVideos, $nameVideo){
        for ($i=0; $i < count($IdsVideos) - 1; $i++) { 
            // Actualiza el id de la categoría del vídeo
            $this->daoVideos->updateCategory($IdsVideos[$i], $category);
        }
    }
    
    function setVideosCategory($category, $id_video, $title_video){
        if(empty($this->daoVideos->checkVideoById($id_video))){
            $this->daoVideos->setVideosWithCategory($id_video, $title_video, $category);
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