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

    function insert($idVideo, $archivo){
        try {
            $sql = "INSERT INTO subtitulos (id_subtitulo, archivo) VALUES (:id_video, :archivo)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_video" => $idVideo, "archivo" => $archivo]);
            $id = $this->conn->lastInsertId();
          } catch(PDOException $e) {
                return null;
            }
        return $id;
    }

}
?>