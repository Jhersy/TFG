<?php


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
  
  /*
   * This OAuth 2.0 access scope allows for full read/write access to the
   * authenticated user's account and requires requests to use an SSL connection.
   */
  $client->setScopes('https://www.googleapis.com/auth/youtube.force-ssl');
  $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
      FILTER_SANITIZE_URL);
  $client->setRedirectUri($redirect);
  
  // Define an object that will be used to make all API requests.
  $youtube = new Google_Service_YouTube($client);
  




  /*********************************************************************** */
  include "comments.php";
  
//$log = new Comments($youtube, $client);

$log = new Comments('as', 'fdsf');

$log->prueba();



/*
$comentarios = $log->getCommentsVideo();



    $htmlBody .= "<h3>Video Comment Replies</h3><ul>";
    foreach ($comentarios as $comment) {
      $htmlBody .= sprintf('<li>%s: "%s"</li>', $comment['snippet']['topLevelComment']['snippet']['authorDisplayName'],
          $comment['snippet']['topLevelComment']['snippet']['textDisplay']);
    }
    $htmlBody .= '</ul>';

    
    $htmlBody .= '</ul>';


    echo $htmlBody;*/
?>