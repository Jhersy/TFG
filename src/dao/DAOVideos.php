<?php

include "DAOConnection.php";

//use PDOException;

Class DAOVideos{


    private $conn;

    function __construct() {
        $this->conn = \Connection::getInstance()->getconnection();
      }

    function getCategories() {
        try {
            $sql = "SELECT categoria FROM videos  GROUP BY categoria";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOVideos: " . $e->getMessage();
        }
        return $res;
    }

    function setVideosWithCategory($id_video, $titulo, $categoria){
        try{
            $sql = "INSERT INTO videos (id_video, titulo, categoria) VALUES (:id_video, :titulo, :categoria)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_video" => $id_video, "titulo" => $titulo, "categoria" => $categoria]);
            $id = $this->conn->lastInsertId();
          } catch(PDOException $e) {
                echo "ERROR EN DAOVideos: " . $e->getMessage();
            return null;
            }
          return $id;
    }

}
?>