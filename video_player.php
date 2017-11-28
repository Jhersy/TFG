<?php
require_once("src/App.php");
require_once("src/logic/Subtitulos.php");
$rol = isAdmin(); //Return session admin or null
$videoId =  $_POST["id_video"]; // "wisbrPN9fbI";


if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
  }

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
      redirect($authUrl);  
  }

?>



<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<head>
    <title>Elements - Editorial by HTML5 UP</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <!--[if lte IE 8]><script src="resources/assets/js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="resources/assets/css/main.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--[if lte IE 9]><link rel="stylesheet" href="resources/assets/css/ie9.css" /><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" href="resources/assets/css/ie8.css" /><![endif]-->
    <script>
        function download(id_video){
            document.myform.id_video.value = id_video;
            return true;
        }
    </script>
</head>

<style type="text/css">
    .video-responsive {
        position: relative;
        padding-bottom: 56.25%;
        /* 16/9 ratio */
        padding-top: 30px;
        /* IE6 workaround*/
        height: 0;
        overflow: hidden;
    }

    .video-responsive iframe,
    .video-responsive object,
    .video-responsive embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>

<body>

    <!-- Wrapper -->
    <div id="wrapper">

        <!-- Main -->
        <div id="main">
            <div class="inner">

                <header id="header" style="padding-top:2em;">
                    <div class="logo">
                        <a href="index.html">
                            <strong>Zaragoza Lingüística</strong>
                        </a>

                    </div>

                    <ul class="icons">
                    <?php
                        if (is_null($rol) ) {
                            echo '<li><a class="button special small" data-toggle="modal" data-target="#myModal">Iniciar sesión</a></li>';
                        }
                        else {
                            $name = getName();
                            echo '<li>Bienvenido, '. $name . '&nbsp;</li>';
                            echo '<li><a href="administracion.php">Administrar &nbsp;</a></li>';
                            echo '<li><a id="enlace-logout" href="login.php">Salir</a></li>';
                        }
                    ?>
                    </ul>

                    <!-- Modal -->
                    <!-- Modal content-->
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <a type="button" class="close" data-dismiss="modal">&times;</a>
                                    <h3>
                                        <span class="glyphicon glyphicon-lock"></span> Iniciar sesión como Administrador</h3>
                                </div>
                                <div class="modal-body">
                                    <form role="form">
                                        <div class="form-group">
                                            <label for="usrname">
                                                <span class="glyphicon glyphicon-user"></span> Usuario</label>
                                            <input type="text" class="form-control" id="usrname" placeholder="Introduce identificador de usuario">
                                        </div>
                                        <div class="form-group">
                                            <label for="psw">
                                                <span class="glyphicon glyphicon-eye-open"></span> Contraseña</label>
                                            <input type="password" class="form-control" id="psw" placeholder="Introduce contraseña">
                                        </div>
                                        <a type="submit" class="btn btn-success btn-block">
                                            <span class="glyphicon glyphicon-off"></span> Login</a>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                </header>

                <!-- Content -->
                <a href="videos.html">
                    <strong> > Lenguaje humano, comunicación y cognición
                    </strong>
                </a>


                <hr class="major" />

                <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">

                    <div class="video-responsive">
                        <iframe <?=explode(" ", $videoPlayer['embedHtml'])[3];?> frameborder="0" allowfullscreen="allowfullscreen"></iframe>
                    </div>
                </div>

                <div class="col-md-12">

                    <h4><?=$videoSnippet['title']?>

                    </h4>
                    <ul class="icons">
                        <li>
                            <i class="fa fa-eye" aria-hidden="true"> <?=$videoStatistics['viewCount']?></i>
                        </li>
                        <li>
                            <i class="fa fa-thumbs-o-up" aria-hidden="true"> <?=$videoStatistics['likeCount'] ?></i>
                        </li>
                        <li>
                            <?php
                                $subtitulos = new Subtitulos();
                                if($subtitulos->existCaption($videoId)){                                
                            ?>
                                <form name="myform" method="post" action="download_subtitulo.php" onsubmit="download('<?=$videoId?>')">
                                    <input type="hidden" name="id_video" value="" />
                                    <input class="button small icon fa-download" type="submit" name="submit" value="Descargar Subtítulos" />
                                </form>
                            <?php } ?>
                        </li>
                    </ul>
                    <p><?=$videoSnippet['description']?></p>

                    <p><strong>Publicado el: </strong><?=substr($videoSnippet['publishedAt'], 0,10)?></p>

                    <?php
                        foreach($videoSnippet['tags'] as $tag){ ?>
                            <span class="label label-danger"><?=$tag?></span>
                       <?php }
                    ?>
                    <hr class="major" />

                    <h4><strong> <?=$videoStatistics['commentCount']?> Comentarios</strong></h4>
                    <dl>
                    <?php 
                    
                    foreach ($videoCommentThreads as $comment) { ?>
                        <dt><img class="img-circle" src="<?=$comment['snippet']['topLevelComment']['snippet']['authorProfileImageUrl']?>" alt="foto perfil usuario comentario"> <?=$comment['snippet']['topLevelComment']['snippet']['authorDisplayName']?></dt>
                        <dd>
                            <p><?=$comment['snippet']['topLevelComment']['snippet']['textDisplay']?></p>
                        </dd>           

                    <?php
                      }
                    ?>
                    
                    </dl>
                <hr class="major" />
                    
                </div>

            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="resources/assets/js/jquery.min.js"></script>
    <script src="resources/assets/js/skel.min.js"></script>
    <script src="resources/assets/js/util.js"></script>
    <!--[if lte IE 8]><script src="resources/assets/js/ie/respond.min.js"></script><![endif]-->
    <script src="resources/assets/js/main.js"></script>

</body>

</html>