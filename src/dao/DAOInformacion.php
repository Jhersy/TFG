<?php

require_once("Connection.php");

Class DAOInformacion{


    private $conn;

    function __construct() {
        $this->conn = \Connection::getInstance()->getconnection();
      }


      /* Insertar una nueva información extra */
    function insert($idVideo, $archivo, $tipo, $size){
        try {
            $sql = "INSERT INTO informacion_adicional (id_informacion, archivo, tipo, tamaño) VALUES (:id_video, :archivo, :tipo, :size)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_video" => $idVideo, "archivo" => $archivo, "tipo" => $tipo, "size" => $size]);
          } catch(PDOException $e) {
                return null;
            }
        return true;
    }

    /* Obtener archivo de información extra */
    function getInformation($id_video, $tipo){
        try {
            $sql = "SELECT archivo FROM informacion_adicional WHERE id_informacion = :id_video AND tipo = :tipo";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_informacion" => $id_video, "tipo" => $tipo]);
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOInformación: " . $e->getMessage();
        }
        return $res;
    }
    
    /* Obtener título de información extra */
    function getTitleInformation($id_informacion){
        try {
            $sql = "SELECT titulo FROM informacion_adicional, videos WHERE id_informacion = :id_informacion and id_video = :id_informacion";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_informacion" => $id_informacion]);
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOInformación: " . $e->getMessage();
        }
        return $res;
    }
    
    /* Comprueba si un vídeo tiene o no información extra */
    function existInformation($id_informacion){
        try {
            $sql = "SELECT id_informacion FROM informacion_adicional WHERE id_informacion = :id_informacion";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_informacion" => $id_informacion]);
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOInformacion: " . $e->getMessage();
        }
        return $res;
    }

    /* Obtiene el tipo de archivo de la información extra*/
    function getTypesInformation($id_informacion){
        try {
            $sql = "SELECT tipo, archivo FROM informacion_adicional WHERE id_informacion = :id_informacion";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_informacion" => $id_informacion]);
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOInformacion: " . $e->getMessage();
        }
        return $res;
    }

}
?>