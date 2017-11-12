<?php

require_once("Connection.php");


Class DAOCategorias{


    private $conn;

    function __construct() {
        $this->conn = \Connection::getInstance()->getconnection();
      }

    function getCategories(){
        try {
            $sql = "SELECT * FROM categorias";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll();
            
        } catch(PDOException $e) {
            echo "ERROR EN DAOCategorias: " . $e->getMessage();
        }
        return $res;
    }

    function setNewCategory($categoria){
        try{
            $sql = "INSERT INTO categorias (nombre_categoria) VALUES (:categoria)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["categoria" => $categoria]);
            $id = $this->conn->lastInsertId();
          } catch(PDOException $e) {
                echo "ERROR EN DAOCategorias: " . $e->getMessage();
          }
          return $id;
    }

}
?>