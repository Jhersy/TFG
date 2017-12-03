<?php

if (preg_match("/PATRI\b/", "patrimonio de la humanidad")) 
{
echo "HAY COINCIDENCIA";
}else 
  {
    echo "NO HAY COINCIDENCIA";
  }
// $test = $_POST['id_video'];

// echo $test;
// require_once("src/logic/Subtitulos.php");
// $videoId = "wisbrPN9fbI";// $_POST["id_video"];

// $subtitulos = new Subtitulos();
// $archivo = $subtitulos->getCaption($videoId);


// var_dump($archivo);


/*
include "src/logic/Users.php";

$categoria = "len_humano";

$model = new Users();
*/
// $name = $_REQUEST["nameCategory"];
//$ids= $_REQUEST["id_video"];
// echo $name;
 //var_dump($ids);



/*
 $resultado = $_POST['nombreCategoria'] .  $_POST['IdsVideos'] . $_POST['nombreVideo']; 
 echo $resultado;
*/
// require_once("src/logic/Videos.php");
// require_once("src/logic/Categorias.php");

// $videos = new Videos();
// $cate = new Categorias();

// $eje = "err|lQmDWuerrJCY7U|";
// $eje1 = "asd|asd|";

// $arr = array();
// $arr1 = array();

// $arr = explode('|', $eje);
// $arr1 = explode('|', $eje1);


// $id_categoria = $cate->setCategory("nueva 123");

// $videos->setVideosWithCategory($id_categoria, $arr, $arr1 );


// var_dump($categorias);

// foreach ($categorias as $cat) {
//   # code...
//   echo $cat['id_categoria'] . "  -  " . utf8_decode($cat['nombre_categoria']);
// }

/*
$eje = "wisbrPN9fbI|lQmDWuJCY7U|";

$arr = array();

$arr = explode('|', $eje);


var_dump($arr);


for ($i=0; $i < count($arr) - 1; $i++) { 
  echo $arr[$i] . " ";
}

*/

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

/*
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
  throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}

require_once __DIR__ . '/vendor/autoload.php';
session_start();

$OAUTH2_CLIENT_ID = '88517581272-gu071qtdg26cg9oqbu8v3pmifgg6jogv.apps.googleusercontent.com';
$OAUTH2_CLIENT_SECRET = '4xobKsbsIv2nFo7XOhcadA6V';


$VIDEO_ID = 'wisbrPN9fbI';

$client = new Google_Client();
$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);


$client->setScopes('https://www.googleapis.com/auth/youtube.force-ssl');
$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
    FILTER_SANITIZE_URL);
$client->setRedirectUri($redirect);

// Define an object that will be used to make all API requests.
$youtube = new Google_Service_YouTube($client);

// Check if an auth token exists for the required scopes
$tokenSessionKey = 'token-' . $client->prepareScopes();
if (isset($_GET['code'])) {
  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
    die('The session state did not match.');
  }

  $client->authenticate($_GET['code']);
  $_SESSION[$tokenSessionKey] = $client->getAccessToken();
  header('Location: ' . $redirect);
}

if (isset($_SESSION[$tokenSessionKey])) {
  $client->setAccessToken($_SESSION[$tokenSessionKey]);
}

// Check to ensure that the access token was successfully acquired.
if ($client->getAccessToken()) {
  try {
    # All the available methods are used in sequence just for the sake of an example.

    // Call the YouTube Data API's commentThreads.list method to retrieve video comment threads.
    $videoCommentThreads = $youtube->commentThreads->listCommentThreads('snippet, replies', array(
    'videoId' => $VIDEO_ID,
    'textFormat' => 'plainText',
    ));


    $parentId = $videoCommentThreads[0]['id'];

    $htmlBody .= "<h3>Video Comment Replies</h3><ul>";
    foreach ($videoCommentThreads as $comment) {
      $htmlBody .= sprintf('<li>%s: "%s"</li>', $comment['snippet']['topLevelComment']['snippet']['authorDisplayName'],
          $comment['snippet']['topLevelComment']['snippet']['textDisplay']);
    }
    $htmlBody .= '</ul>';

    
    $htmlBody .= '</ul>';

  } catch (Google_Service_Exception $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  }

  $_SESSION[$tokenSessionKey] = $client->getAccessToken();
} elseif ($OAUTH2_CLIENT_ID == 'REPLACE_ME') {
  $htmlBody = <<<END
  <h3>Client Credentials Required</h3>
  <p>
    You need to set <code>\$OAUTH2_CLIENT_ID</code> and
    <code>\$OAUTH2_CLIENT_ID</code> before proceeding.
  <p>
END;
} else {
  $state = mt_rand();
  $client->setState($state);
  $_SESSION['state'] = $state;

  $authUrl = $client->createAuthUrl();
  $htmlBody = <<<END
    <h3>Authorization Required</h3>
    <p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
}
*/
/*
require_once("scraping.php");
$IdsVideos = getIDsVideos(0);

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
  throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}

require_once __DIR__ . '/vendor/autoload.php';
session_start();

$OAUTH2_CLIENT_ID = "88517581272-gu071qtdg26cg9oqbu8v3pmifgg6jogv.apps.googleusercontent.com";
$OAUTH2_CLIENT_SECRET = "4xobKsbsIv2nFo7XOhcadA6V";

$client = new Google_Client();
$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);
$client->setScopes('https://www.googleapis.com/auth/youtube');
$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
  FILTER_SANITIZE_URL);
$client->setRedirectUri($redirect);

$youtube = new Google_Service_YouTube($client);

// Check if an auth token exists for the required scopes
$tokenSessionKey = 'token-' . $client->prepareScopes();
if (isset($_GET['code'])) {
  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
    die('The session state did not match.');
  }

  $client->authenticate($_GET['code']);
  $_SESSION[$tokenSessionKey] = $client->getAccessToken();
  header('Location: ' . $redirect);
}

if (isset($_SESSION[$tokenSessionKey])) {
  $client->setAccessToken($_SESSION[$tokenSessionKey]);
}


if ($client->getAccessToken()) {
    // $videoId = "wisbrPN9fbI";  
    $videos = array();
    // ESTADÍSTICAS DE UN VÍDEO
    foreach ($IdsVideos as $videoId) {
      $listResponse = $youtube->videos->listVideos("snippet, contentDetails, statistics, player",
      array('id' => $videoId));
      echo $videoId . "\n";
      array_push($videos, $listResponse[0]);
    }

    
}else{
    $state = mt_rand();
    $client->setState($state);
    $_SESSION['state'] = $state;

    $authUrl = $client->createAuthUrl();
    echo "<h3>Authorization Required</h3><p>You need to <a href=" . $authUrl . ">authorize access</a> before proceeding.<p>";

}
*/
?>






































