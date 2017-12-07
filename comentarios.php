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
require_once("src/App.php");


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
    # All the available methods are used in sequence just for the sake of an example.

    // Call the YouTube Data API's commentThreads.list method to retrieve video comment threads.
    // $videoCommentThreads = $youtube->commentThreads->listCommentThreads('snippet', array(
    // 'videoId' => $VIDEO_ID,
    // 'textFormat' => 'plainText',
    // ));
    // var_dump($videoCommentThreads);

    // $parentId = $videoCommentThreads[0]['id'];

    // # Create a comment snippet with text.
    // $commentSnippet = new Google_Service_YouTube_CommentSnippet();
    // $commentSnippet->setTextOriginal($TEXT);
    // $commentSnippet->setParentId($parentId);

    /**#########################*/
    $commentSnippet = new Google_Service_YouTube_CommentSnippet();
    $commentSnippet->setTextOriginal($TEXT);
    
    # Create a top-level comment with snippet.
    $topLevelComment = new Google_Service_YouTube_Comment();
    $topLevelComment->setSnippet($commentSnippet);

    # Create a comment thread snippet with channelId and top-level comment.
    $commentThreadSnippet = new Google_Service_YouTube_CommentThreadSnippet();
    $commentThreadSnippet->setChannelId($CHANNEL_ID);
    $commentThreadSnippet->setTopLevelComment($topLevelComment);

    # Create a comment thread with snippet.
    $commentThread = new Google_Service_YouTube_CommentThread();
    $commentThread->setSnippet($commentThreadSnippet);

    // Call the YouTube Data API's commentThreads.insert method to create a comment.
    // $channelCommentInsertResponse = $youtube->commentThreads->insert('snippet', $commentThread);

    # Insert video comment
    $commentThreadSnippet->setVideoId($VIDEO_ID);
    // Call the YouTube Data API's commentThreads.insert method to create a comment.
    $videoCommentInsertResponse = $youtube->commentThreads->insert('snippet', $commentThread);
    /**#########################*/
    


    // # Create a comment with snippet.
    // $comment = new Google_Service_YouTube_Comment();
    // $comment->setSnippet($commentSnippet);

    // # Call the YouTube Data API's comments.insert method to reply to a comment.
    // # (If the intention is to create a new top-level comment, commentThreads.insert
    // # method should be used instead.)
    // $commentInsertResponse = $youtube->comments->insert('snippet', $comment);


    // // Call the YouTube Data API's comments.list method to retrieve existing comment replies.
    // $videoComments = $youtube->comments->listComments('snippet', array(
    //     'parentId' => $parentId,
    //     'textFormat' => 'plainText',
    // ));

    // if (empty($videoComments)) {
    //   $htmlBody .= "<h3>Can\'t get video comments.</h3>";
    // } else {
    //   $videoComments[0]['snippet']['textOriginal'] = 'updated';

    //   // Call the YouTube Data API's comments.update method to update an existing comment.
    //   $videoCommentUpdateResponse = $youtube->comments->update('snippet', $videoComments[0]);

    //   // Call the YouTube Data API's comments.setModerationStatus method to set moderation
    //   // status of an existing comment.
    //   $youtube->comments->setModerationStatus($videoComments[0]['id'], 'published');

    //   // Call the YouTube Data API's comments.markAsSpam method to mark an existing comment as spam.
    //   $youtube->comments->markAsSpam($videoComments[0]['id']);

    //   // Call the YouTube Data API's comments.delete method to delete an existing comment.
    //   $youtube->comments->delete($videoComments[0]['id']);
    // }

    // $htmlBody .= "<h3>Video Comment Replies</h3><ul>";
    // foreach ($videoComments as $comment) {
    //   $htmlBody .= sprintf('<li>%s: "%s"</li>', $comment['snippet']['authorDisplayName'],
    //       $comment['snippet']['textOriginal']);
    // }
    // $htmlBody .= '</ul>';

    // $htmlBody .= "<h2>Replied to a comment for</h2><ul>";
    // $htmlBody .= sprintf('<li>%s: "%s"</li>',
    //     $commentInsertResponse['snippet']['authorDisplayName'],
    //     $commentInsertResponse['snippet']['textDisplay']);
    // $htmlBody .= '</ul>';

    // $htmlBody .= "<h2>Updated comment for</h2><ul>";
    // $htmlBody .= sprintf('<li>%s: "%s"</li>',
    //     $videoCommentUpdateResponse['snippet']['authorDisplayName'],
    //     $videoCommentUpdateResponse['snippet']['textDisplay']);
    // $htmlBody .= '</ul>';

  } catch (Google_Service_Exception $e) {
      $htmlBody = "";
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  }

  $_SESSION['sesion'] = $client->getAccessToken();
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
    redirect($authUrl);
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