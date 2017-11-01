<?php
/*
include "src/logic/Users.php";

$categoria = "len_humano";

$model = new Users();
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


/**
 * This sample creates and manages comments by:
 *
 * 1. Getting the top-level comments for a video via "commentThreads.list" method.
 * 2. Replying to a comment thread via "comments.insert" method.
 * 3. Getting comment replies via "comments.list" method.
 * 4. Updating an existing comment via "comments.update" method.
 * 5. Sets moderation status of an existing comment via "comments.setModerationStatus" method.
 * 6. Marking a comment as spam via "comments.markAsSpam" method.
 * 7. Deleting an existing comment via "comments.delete" method.
 *
 * @author Ibrahim Ulukaya
 */

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
$OAUTH2_CLIENT_ID = '88517581272-gu071qtdg26cg9oqbu8v3pmifgg6jogv.apps.googleusercontent.com';
$OAUTH2_CLIENT_SECRET = '4xobKsbsIv2nFo7XOhcadA6V';

/* You can replace $VIDEO_ID with one of your videos' id, and text with the
 *  comment you want to be added.
 */
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
  // If the user hasn't authorized the app, initiate the OAuth flow
  $state = mt_rand();
  $client->setState($state);
  $_SESSION['state'] = $state;

  $authUrl = $client->createAuthUrl();
  $htmlBody = <<<END
    <h3>Authorization Required</h3>
    <p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
}
?>

<!doctype html>
<html>
<head>
<title>Insert, list, update, moderate, mark and delete comments.</title>
</head>
<body>
  <?=$htmlBody?>
</body>
</html>





































