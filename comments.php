<?php

Class Comments{
    
        private $youtube;
        private $client;
        
        private $pr;

        function __construct($service, $cliente){
            $this->$youtube = $service;
            $this->$client = $cliente;
            $this->pr = "hola";
        }

        function prueba(){
            echo $this->$youtube . "  - " . $this->$client;
            echo $this->pr;
        }
    
        function getCommentsVideo(){
                     
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
              
              /*
                  $parentId = $videoCommentThreads[0]['id'];
              
                  $htmlBody .= "<h3>Video Comment Replies</h3><ul>";
                  foreach ($videoCommentThreads as $comment) {
                    $htmlBody .= sprintf('<li>%s: "%s"</li>', $comment['snippet']['topLevelComment']['snippet']['authorDisplayName'],
                        $comment['snippet']['topLevelComment']['snippet']['textDisplay']);
                  }
                  $htmlBody .= '</ul>';
              
                  
                  $htmlBody .= '</ul>';
                  */
              
                } catch (Google_Service_Exception $e) {
                  $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
                      htmlspecialchars($e->getMessage()));
                } catch (Google_Exception $e) {
                  $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
                      htmlspecialchars($e->getMessage()));
                }
              
                $_SESSION[$tokenSessionKey] = $client->getAccessToken();
              } else{
                  echo "NO HAY ACCESO";
              }
              return $videoCommentThreads;
        }
        

}
?>