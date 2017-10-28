<?php


Class Videos{


    function Videos(){
        
    }

    function getDetailsVideo($videoId){

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
          
              // ESTADÍSTICAS DE UN VÍDEO
              $listResponse = $youtube->videos->listVideos("snippet, contentDetails, statistics, player",
              array('id' => $videoId));
              $video = $listResponse[0];
              
          }else{
              $state = mt_rand();
              $client->setState($state);
              $_SESSION['state'] = $state;
          
              $authUrl = $client->createAuthUrl();
              echo $authUrl;
              $htmlBody = "<h3>Authorization Required</h3><p>You need to <a href=" . $authUrl . ">authorize access</a> before proceeding.<p>";
          
          }
        return $video;
    
    }

}

?>