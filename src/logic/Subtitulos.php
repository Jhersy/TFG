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


    function newCaption($idVideo, $archivo) {
        //Insertar en tabla subtítulos
        return $this->daoSubtitulos->insert($idVideo, $archivo);
    }
}
?>