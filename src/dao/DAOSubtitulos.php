<?php

require_once("Connection.php");

Class DAOSubtitulos{


    private $conn;

    function __construct() {
        $this->conn = \Connection::getInstance()->getconnection();
      }

    function findInCaption($query) {
        try {
            $sql = "SELECT id_subtitulo, archivo FROM subtitulos WHERE archivo LIKE '%". $query . "%'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOSubtitulos: " . $e->getMessage();
        }
        return $res;
    }

    function insert($idVideo, $archivo, $idioma){
        try {
            $sql = "INSERT INTO subtitulos (id_subtitulo, archivo, idioma) VALUES (:id_video, :archivo, :idioma)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_video" => $idVideo, "archivo" => $archivo, "idioma" => $idioma]);
          } catch(PDOException $e) {
                return false;
            }
        return true;
    }

    function getCaption($id_video, $idioma){
        try {
            $sql = "SELECT archivo FROM subtitulos WHERE id_subtitulo = :id_subtitulo AND idioma = :idioma";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_subtitulo" => $id_video, "idioma" => $idioma]);
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOSubtitulos: " . $e->getMessage();
        }
        return $res;
    }
    
    function getTitleCaption($id_subtitulo){
        try {
            $sql = "SELECT titulo FROM subtitulos, videos WHERE id_subtitulo = :id_subtitulo and id_video = :id_subtitulo";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_subtitulo" => $id_subtitulo]);
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOSubtitulos: " . $e->getMessage();
        }
        return $res;
    }

    function existCaption($id_subtitulo){
        try {
            $sql = "SELECT id_subtitulo, idioma FROM subtitulos WHERE id_subtitulo = :id_subtitulo";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_subtitulo" => $id_subtitulo]);
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOSubtitulos: " . $e->getMessage();
        }
        return $res;
    }

    function getLanguageCaption($id_subtitulo){
        try {
            $sql = "SELECT idioma FROM subtitulos WHERE id_subtitulo = :id_subtitulo ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_subtitulo" => $id_subtitulo]);
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOSubtitulos: " . $e->getMessage();
        }
        return $res;
    }


    function delete($id_subtitulo, $idioma){
        try {
            $sql = "DELETE FROM subtitulos WHERE id_subtitulo = :id_subtitulo AND idioma = :idioma";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_subtitulo" => $id_subtitulo, "idioma" => $idioma]);
          } catch(PDOException $e) {
                return false;
            }
        return true;
    }

    function getAll(){
        try {
            $sql = "SELECT id_subtitulo, idioma FROM subtitulos";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll();
          } catch(PDOException $e) {
            echo "ERROR EN DAOSubtitulo: " . $e->getMessage();
            }
        return $res;
    }

    function checkCaption($id_subtitulo, $idioma){
        try {
            $sql = "SELECT * FROM subtitulos WHERE id_subtitulo = :id_subtitulo  AND idioma = :idioma ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_subtitulo" => $id_subtitulo, "idioma" => $idioma]);
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOSubtitulos: " . $e->getMessage();
        }
        return $res;
    }

}
?>