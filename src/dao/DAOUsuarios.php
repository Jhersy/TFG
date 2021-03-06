<?php

require_once("Connection.php");

Class DAOUsuarios{


    private $conn;

    function __construct() {
        $this->conn = \Connection::getInstance()->getconnection();
      }

      /* Busca si existe o no un usuario */
    function findUserByName($username) {
        try {
            $sql = "SELECT * FROM administradores WHERE name_admin = :name";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["name" => $username]);
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOUsuario: " . $e->getMessage();
        }
        return $res;
    }

    /* Inserta un nuevo administrador */
    function insert($name, $hpassword){
        try {
            $sql = "INSERT INTO administradores (name_admin, password_admin) VALUES (:usuario, :pass)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["usuario" => $name, "pass" => $hpassword]);
            $id = $this->conn->lastInsertId();
          } catch(PDOException $e) {
                return null;
            }
        return $id;
    }

    /* Borra un administrador */
    function delete($name){
        try {
            $sql = "DELETE FROM administradores WHERE name_admin = :usuario";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["usuario" => $name]);
          } catch(PDOException $e) {
                return false;
            }
        return true;
    }

    /* Obtiene todos los administradores menos el actual */
    function getAllAdmins($currentAdmin){
        try {
            $sql = "SELECT name_admin FROM administradores  WHERE name_admin != :administrador";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["administrador" => $currentAdmin]);
            $res = $stmt->fetchAll();
          } catch(PDOException $e) {
            echo "ERROR EN DAOUsuario: " . $e->getMessage();
            }
        return $res;
    }


}
?>