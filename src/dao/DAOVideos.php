<?php

require_once("Connection.php");

Class DAOVideos{


    private $conn;

    function __construct() {
        $this->conn = \Connection::getInstance()->getconnection();
      }

      /* Obtiene los vídeos de una categoría */
      function getVideosOfCategory($categoria) {
        try {
            $sql = "SELECT id_video, titulo FROM videos WHERE id_categoria =  (:categoria) ORDER BY titulo";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["categoria" => $categoria]);
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOVideos: " . $e->getMessage();
        }
        return $res;
    }

    /* Relaciona los vídeos a una categoría */
    function setVideosWithCategory($id_video, $titulo, $categoria){
        try{
            $sql = "INSERT INTO videos (id_video, titulo, id_categoria) VALUES (:id_video, :titulo, :categoria)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_video" => $id_video, "titulo" => $titulo, "categoria" => $categoria]);
            $id = $this->conn->lastInsertId();
          } catch(PDOException $e) {
                echo "ERROR EN DAOVideos: " . $e->getMessage();
            return null;
            }
          return $id;
    }

    /* Comprueba que existe un vídeo */
    function checkVideoById($id_video){
        try {
            $sql = "SELECT id_video FROM videos WHERE id_video =  (:video) ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["video" => $id_video]);
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOVideos: " . $e->getMessage();
        }
        return $res;
    }

    /* Actualiza la categoría de un vídeo */
    function updateCategory($id_video, $categoria){
        try{
            $sql = "UPDATE videos SET id_categoria = :categoria WHERE id_video = :id_video";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_video" => $id_video, "categoria" => $categoria]);
            $id = $this->conn->lastInsertId();
          } catch(PDOException $e) {
                echo "ERROR EN DAOVideos: " . $e->getMessage();
            return null;
            }
          return $id;
    }

    /* Obtiene todos los vídeos de la BBDD */
    function getAllVideos() {
        try {
            $sql = "SELECT id_video, titulo FROM videos ORDER BY titulo";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOVideos: " . $e->getMessage();
        }
        return $res;
    }

    /* Resetea el auto incremente de la tabla */
    function resetAutoIncrement(){
        try{
            $sql = 'ALTER TABLE videos AUTO_INCREMENT = 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
          } catch(PDOException $e) {
                echo "ERROR EN DAOVideos: " . $e->getMessage();
            }
    }
}
?>