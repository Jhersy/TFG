<?php

 session_start();

 /* Do work */
 if(isset($_REQUEST["destination"])){
   echo "DENTRO";

   echo $_POST['firstname'];
    //  header("Location: {$_REQUEST["destination"]}");
 }else if(isset($_SERVER["HTTP_REFERER"])){
    //  header("Location: {$_SERVER["HTTP_REFERER"]}");
 }else{
      /* some fallback, maybe redirect to index.php */
 }

 $videoId = "r-INXMQYbSs";

$sesion = $_SESSION['sesion'];

  require_once __DIR__ . '/vendor/autoload.php';
 // session_start();
  
  $OAUTH2_CLIENT_ID = '88517581272-gu071qtdg26cg9oqbu8v3pmifgg6jogv.apps.googleusercontent.com';
  $OAUTH2_CLIENT_SECRET = '4xobKsbsIv2nFo7XOhcadA6V';
  
 
  $client = new Google_Client();
  $client->setClientId($OAUTH2_CLIENT_ID);
  $client->setClientSecret($OAUTH2_CLIENT_SECRET);
  
 
  $client->setScopes('https://www.googleapis.com/auth/youtube.force-ssl');
  $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
      FILTER_SANITIZE_URL);
  $client->setRedirectUri($redirect);
  
  // Define an object that will be used to make all API requests.
  $youtube = new Google_Service_YouTube($client);
  
    if (isset($_SESSION['sesion'])) {
	    $client->setAccessToken($_SESSION['sesion']);
    }
  
  if ($client->getAccessToken()) {
      //$videoId = "wisbrPN9fbI";
  
      $listResponse = $youtube->videos->listVideos("snippet, contentDetails, statistics, player",array('id' => $videoId));
      
      $video = $listResponse[0];
      $videoSnippet = $video['snippet'];
      $videoSnippet = $video['snippet'];
      $videoContentDetails = $video['contentDetails'];
      $videoStatistics = $video['statistics'];
      $videoPlayer = $video['player'];

      // ESTADÍSTICAS DE UN VÍDEO
      $videoCommentThreads = $youtube->commentThreads->listCommentThreads('snippet, replies', array(
        'videoId' => $videoId,
        'textFormat' => 'plainText',
        ));
      
  }else{
      $state = mt_rand();
      $client->setState($state);
      $_SESSION['state'] = $state;
  
      $authUrl = $client->createAuthUrl();
      // redirect($authUrl);  
  }
?>





































