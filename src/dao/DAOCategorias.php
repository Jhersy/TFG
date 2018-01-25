<?php

require_once("Connection.php");


Class DAOCategorias{


    private $conn;

    function __construct() {
        $this->conn = \Connection::getInstance()->getconnection();
      }

    /* Función para mostrar las categorías que son o no del blog */
    function getCategories($blog){
        try {
            $sql = "SELECT * FROM categorias WHERE blog = :blog";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["blog" => $blog]);
            $res = $stmt->fetchAll();
            
        } catch(PDOException $e) {
            echo "ERROR EN DAOCategorias: " . $e->getMessage();
        }
        return $res;
    }

    /* Añadir una nueva categoría */
    function setNewCategory($categoria, $blog){
        try{
            $sql = "INSERT INTO categorias (nombre_categoria, visible, blog) VALUES (:categoria, 1 , :blog)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["categoria" => $categoria, "blog" => $blog]);
            $id = $this->conn->lastInsertId();
          } catch(PDOException $e) {
                echo "ERROR EN DAOCategorias: " . $e->getMessage();
          }
          return $id;
    }

    /*Obtener las categorías visibles en la página web */
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

    /*Obtiene todos los vídeos que pertenecen a una categoría */
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

    /* Hacer visible o no a una categoría */
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

    /* Obtener nombre de una categoría */
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

    /* Resetear auto increment de las categorías */
    function resetAutoIncrement(){
        try{
            $sql = 'ALTER TABLE categorias AUTO_INCREMENT = 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
          } catch(PDOException $e) {
                echo "ERROR EN DAOCategorias: " . $e->getMessage();
            }
    }
}
?>