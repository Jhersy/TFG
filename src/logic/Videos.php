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
            $this->daoVideos->setVideosWithCategory($IdsVideos[$i], utf8_decode($nameVideo[$i]), $category);
        }
    }
}
?>