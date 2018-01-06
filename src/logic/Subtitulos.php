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

    //Insertar en tabla subtítulos
    function newCaption($idVideo, $archivo, $idioma) {
        $ok = false;
        //Comprobar antes si ya existe el subtítulo con ese idioma
        if(empty($this->daoSubtitulos->checkCaption($idVideo, $idioma))){
           $ok = $this->daoSubtitulos->insert($idVideo, $archivo, $idioma);
        }
        return $ok;
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


    function deleteCaption($id_subtitulo, $idioma) {
        return $this->daoSubtitulos->delete($id_subtitulo, $idioma);
    }


    function getAll(){
        return  $this->daoSubtitulos->getAll();
    }

}
?>