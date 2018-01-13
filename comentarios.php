<?php
/* Se insertará el comentario que ha realizado el usuario */

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
  throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}
require_once __DIR__ . '/vendor/autoload.php';
require_once("src/App.php");

$OAUTH2_CLIENT_ID = '88517581272-gu071qtdg26cg9oqbu8v3pmifgg6jogv.apps.googleusercontent.com';
$OAUTH2_CLIENT_SECRET = '4xobKsbsIv2nFo7XOhcadA6V';

$VIDEO_ID = $_POST['id_video']; //'wisbrPN9fbI';
$CHANNEL_ID = "UCG_fXqOLea9FSTLoWZieaqw";
$TEXT = $_POST['textComment']; //'COMENTARIO DE PRUEBA';


$client = new Google_Client();
$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);
$client->setScopes('https://www.googleapis.com/auth/youtube.force-ssl');
$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
  FILTER_SANITIZE_URL);
$client->setRedirectUri($redirect);
$youtube = new Google_Service_YouTube($client);
  if (isset($_SESSION['sesion'])) {
      $client->setAccessToken($_SESSION['sesion']);
  }
// Check to ensure that the access token was successfully acquired.
if ($client->getAccessToken()) {
  try {
    // AÑADE EL TEXTO A COMENTARMENTAR
    $commentSnippet = new Google_Service_YouTube_CommentSnippet();
    $commentSnippet->setTextOriginal($TEXT);
    
    # Crea un comentario raiz
    $topLevelComment = new Google_Service_YouTube_Comment();
    $topLevelComment->setSnippet($commentSnippet);

    # Crea un hilo de comentarios
    $commentThreadSnippet = new Google_Service_YouTube_CommentThreadSnippet();
    $commentThreadSnippet->setChannelId($CHANNEL_ID);
    $commentThreadSnippet->setTopLevelComment($topLevelComment);

    # Create a comment thread with snippet.
    $commentThread = new Google_Service_YouTube_CommentThread();
    $commentThread->setSnippet($commentThreadSnippet);
    $commentThreadSnippet->setVideoId($VIDEO_ID);

    // Inserta el nuevo comentario
    $videoCommentInsertResponse = $youtube->commentThreads->insert('snippet', $commentThread);
  
  } catch (Google_Service_Exception $e) {
      $htmlBody = "";
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  }
  $_SESSION['sesion'] = $client->getAccessToken();
} else {
  // If the user hasn't authorized the app, initiate the OAuth flow
  $state = mt_rand();
  $client->setState($state);
  $_SESSION['state'] = $state;
  $authUrl = $client->createAuthUrl();
    redirect($authUrl);
}
?>