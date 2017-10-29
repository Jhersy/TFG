<?php

/**
 * Library Requirements
 *
 * 1. Install composer (https://getcomposer.org)
 * 2. On the command line, change to this directory (api-samples/php)
 * 3. Require the google/apiclient library
 *    $ composer require google/apiclient:~2.0
 */
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
  throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}

require_once __DIR__ . '/vendor/autoload.php';
session_start();

/*
 * You can acquire an OAuth 2.0 client ID and client secret from the
 * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
 * For more information about using OAuth 2.0 to access Google APIs, please see:
 * <https://developers.google.com/youtube/v3/guides/authentication>
 * Please ensure that you have enabled the YouTube Data API for your project.
 */
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
    $videoId = "wisbrPN9fbI";
    
    try {
    $listResponse = $youtube->videos->listVideos("snippet",
    array('id' => $videoId));
    $video = $listResponse[0];
    $videoSnippet = $video['snippet'];
  } catch (Google_Service_Exception $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  }

    /*
    $htmlBody .= "<h3>Video Updated</h3><ul>";
    $htmlBody .= sprintf('<li>Tags "%s" and "%s" added for video %s (%s) </li>',
        array_pop($responseTags), array_pop($responseTags),
        $videoId, $video['snippet']['title']);
        $htmlBody .= '</ul>';
        $_SESSION['token'] = $client->getAccessToken();
        */

        //$listCommentsResponse = $youtube->commentThreads->listCommentThreads("snippet, replies", array('videoId' => $videoId));
        //$videoComments = $listCommentsResponse[0];
        /*
        try {
    // Call the YouTube Data API's commentThreads.list method to retrieve video comment threads.
    $videoCommentThreads = $youtube->commentThreads->listCommentThreads('snippet', array(
      'videoId' => $videoId,
      'textFormat' => 'plainText',
      ));
  
      $parentId = $videoCommentThreads[0]['id'];
        } catch (Google_Service_Exception $e) {
          $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
              htmlspecialchars($e->getMessage()));
        } catch (Google_Exception $e) {
          $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
              htmlspecialchars($e->getMessage()));
        }
        */

}else{
    $state = mt_rand();
    $client->setState($state);
    $_SESSION['state'] = $state;

    $authUrl = $client->createAuthUrl();
    echo $authUrl;
    $htmlBody = <<<END
<h3>Authorization Required</h3>
<p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
}
?>

<!doctype html>
    <html>
    <head>
    <title>Video Updated</title>
    </head>
    <body>
      <p><?=$htmlBody?></p>
      <p><?=$videoSnippet?></p>
    </body>
    </html>