<?php
require_once("src/App.php");
  
  require_once __DIR__ . '/vendor/autoload.php';
  // session_start();
  
  $OAUTH2_CLIENT_ID = "88517581272-gu071qtdg26cg9oqbu8v3pmifgg6jogv.apps.googleusercontent.com";
  $OAUTH2_CLIENT_SECRET = "4xobKsbsIv2nFo7XOhcadA6V";
  
  $client = new Google_Client();
  $client->setClientId($OAUTH2_CLIENT_ID);
  $client->setClientSecret($OAUTH2_CLIENT_SECRET);
  $client->setScopes('https://www.googleapis.com/auth/youtube.force-ssl');
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


  $_SESSION['sesion'] = $client->getAccessToken();
  

  
  header('Location: ' . $redirect);
  }
  
  if (isset($_SESSION[$tokenSessionKey])) {
  $client->setAccessToken($_SESSION[$tokenSessionKey]);
  }
  
  
  if ($client->getAccessToken()) {
    
  }else{
	  $state = mt_rand();
	  $client->setState($state);
	  $_SESSION['state'] = $state;
  
	  $authUrl = $client->createAuthUrl();
	  echo "<h3>Authorization Required</h3><p>You need to <a href=" . $authUrl . ">authorize access</a> before proceeding.<p>";
	  redirect($authUrl);
  
  }

  ?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Bienvenido</title>
  </head>
  <body>
      <h4>Bienvenido a la herramienta</h4>
      <a href="inicio.php">Pincha aquí para acceder</a>
  </body>
  </html>