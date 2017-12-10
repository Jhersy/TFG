<?php

include "src/dao/DAOSubtitulos.php";

Class Subtitulos{

    private $daoSubtitulos;

    function Subtitulos() {
        $this->daoSubtitulos = new DAOSubtitulos();
    }

    function findInCaption($query){

        if (is_null($query) || empty($query)) {
            return null;
        }else {
            $result = $this->daoSubtitulos->findInCaption($query);
            if(count($result) == 0){
                return null;
            }
        }
        return $result;
      }

    function newCaption($idVideo, $archivo, $idioma) {
        //Insertar en tabla subtítulos
        return $this->daoSubtitulos->insert($idVideo, $archivo, $idioma);
    }

    function getCaption($id_video, $idioma){
        return $this->daoSubtitulos->getCaption($id_video, $idioma);
    }

    function getTitleCaption($id_subtitulo){
        return $this->daoSubtitulos->getTitleCaption($id_subtitulo);
    }

    function existCaption($id_subtitulo){
        return count($this->daoSubtitulos->existCaption($id_subtitulo)) == 0 ? false : true;
    }

    function getLanguageCaption($id_subtitulo){
        return $this->daoSubtitulos->getLanguageCaption($id_subtitulo);
    }
}
?>