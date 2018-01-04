<?php

include "src/dao/DAOInformacion.php";

Class Informacion{

    private $daoInformacion;

    function Informacion() {
        $this->daoInformacion = new DAOInformacion();
    }

    function newInformation($id_informacion, $archivo, $tipo, $size) {
        //Insertar en tabla informacion_adicional
        return $this->daoInformacion->insert($id_informacion, $archivo, $tipo, $size);
    }

    function getInformation($id_informacion, $tipo){
        return $this->daoInformacion->getInformation($id_informacion, $tipo);
    }

    function getTitleInformation($id_informacion){
        return $this->daoInformacion->getTitleInformation($id_informacion);
    }

    function existInformation($id_informacion){
        return count($this->daoInformacion->existInformation($id_informacion)) == 0 ? false : true;
    }

    function getTypesInformation($id_informacion){
        return $this->daoInformacion->getTypesInformation($id_informacion);
    }
}
?>