<?php

include "DAOConnection.php";

//use PDOException;

Class DAOUsuarios{


    private $conn;

    function __construct() {
        $this->conn = \Connection::getInstance()->getconnection();
      }

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

}
?>