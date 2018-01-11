<?php

class Connection {

  private static $instance;
  private $connection;

  static function getInstance() {
    if (!self::$instance instanceof self) {
      self::$instance = new self;
    }
    return self::$instance;
  }

  static function createConnection() {

    $servername = "localhost";
    $username = "user_tfg";
    $password = "user_tfg";
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=tfg;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
    return $conn;
  }

  private function __construct() {
    $this->connection = $this->createConnection();
  }
  function getConnection() {
    return $this->connection;
  }
}
?>