<?php

include "DAOConnection.php";

//use PDOException;

Class DAOVideos{


    private $conn;

    function __construct() {
        $this->conn = \Connection::getInstance()->getconnection();
      }

    function getVideosByCategory($category) {
        try {
            $sql = "SELECT id_video FROM videos WHERE categoria = :categoria";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["categoria" => $category]);
            $res = $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "ERROR EN DAOServicio: " . $e->getMessage();
        }
        return $res;
    }

}
?>