<?php

include "src/dao/DAOVideos.php";

Class Videos{

    private $daoVideos;

    function Videos() {
        $this->daoVideos = new DAOVideos();
    }

    function listVideos($categoria){
        $listVideos = $this->daoVideos->getVideosByCategory($categoria);
        return $listVideos;
      }
}
?>