<?php

require_once("Connection.php");


Class DAOCategorias{


    private $conn;

    function __construct() {
        $this->conn = \Connection::getInstance()->getconnection();
      }

    function getCategories(){
        try {
            $sql = "SELECT * FROM categorias WHERE blog = '0'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll();
            
        } catch(PDOException $e) {
            echo "ERROR EN DAOCategorias: " . $e->getMessage();
        }
        return $res;
    }

    function getCategoriesBlog(){
        try {
            $sql = "SELECT * FROM categorias WHERE blog = '1'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll();
            
        } catch(PDOException $e) {
            echo "ERROR EN DAOCategorias: " . $e->getMessage();
        }
        return $res;
    }
    function setNewCategory($categoria, $blog){
        try{
            $sql = "INSERT INTO categorias (nombre_categoria, blog) VALUES (:categoria, :blog)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["categoria" => $categoria, "blog" => $blog]);
            $id = $this->conn->lastInsertId();
          } catch(PDOException $e) {
                echo "ERROR EN DAOCategorias: " . $e->getMessage();
          }
          return $id;
    }
    function getCategoriesVisible(){
        try {
            $sql = "SELECT id_categoria, nombre_categoria FROM categorias WHERE visible = '1'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll();
            
        } catch(PDOException $e) {
            echo "ERROR EN DAOCategorias: " . $e->getMessage();
        }
        return $res;
    }

    function getVideosOfCategory($id_categoria){
        try {
            $sql = "SELECT video.id_video FROM `categorias` AS cat , videos AS video WHERE cat.visible='1' and cat.id_categoria = '$id_categoria' and video.id_categoria = '$id_categoria'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll();
            
        } catch(PDOException $e) {
            echo "ERROR EN DAOCategorias: " . $e->getMessage();
        }
        return $res;
    }

    function updateCategory($id_categoria, $visible){
        try {
            $sql = "UPDATE categorias SET visible = ". $visible ." WHERE id_categoria = " . $id_categoria .  " ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
          } catch(PDOException $e) {
            return null;
            }
          return true;
    }

    function disableCategories(){
        try {
            $sql = "UPDATE categorias SET visible = 0 ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
          } catch(PDOException $e) {
            return null;
            }
          return true;
    }

    function getNameCategory($id_categoria){
        try {
            $sql = "SELECT nombre_categoria FROM categorias WHERE id_categoria = :id_categoria";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id_categoria" => $id_categoria]);
            $res = $stmt->fetchAll();
            
        } catch(PDOException $e) {
            echo "ERROR EN DAOCategorias: " . $e->getMessage();
        }
        return $res;
    }
}
?>