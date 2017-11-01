<?php

include "src/logic/Users.php";

$categoria = "len_humano";

$model = new Users();


//$idUser = $model->newUser("prueba2", "prueba2");
//echo $idUser;
//$users = $model->checkLogin("prueba2", "prueba2");

//echo $users[0]['id_admin'];



//$idUser = $model->newUser("prueba", "prueba");
//echo $idUser;


/*
$IdVideos = $model->listVideos($categoria);


foreach ($IdVideos as $video) {

    echo $video['id_video'] . " ";
}

echo count($IdVideos);
*/

/*
$servername = "localhost";
$username = "root";
$password = "root";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
*/
/*

PDO 

$servername = "localhost";
$username = "root";
$password = "root";

try {
    $conn = new PDO("mysql:host=$servername;dbname=TFG", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }


*/


?>