<?php

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
  }
  require_once __DIR__ . '/vendor/autoload.php';
  

  define('SRT_STATE_SUBNUMBER', 0);
  define('SRT_STATE_TIME', 1);
  define('SRT_STATE_TEXT', 2);
  define('SRT_STATE_BLANK', 3);
  
  require_once("src/logic/Subtitulos.php");
  require_once("src/App.php");
  
  $query = "lengua";
  
//   if(!is_null($query/*$_POST['query']*/)){
  
      session_start();
      
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
      
          $searchResponse = $youtube->search->listSearch('id,snippet', array(
            'q' => $query,
            'channelId' => 'UCG_fXqOLea9FSTLoWZieaqw',
            'maxResults' => '25',
          ));
  
          
          $resultSearchYoutube = array();
          $arrayBBDD = array();
          $arrayBBDD = buscarSubtitulos($query); // SE TRAE LOS VIDEOS EN LOS QUE LA PALABRA APARECE EN SU SUBTITULO
      
          // Add each result to the appropriate list, and then display the lists of
          // matching videos, channels, and playlists.
          foreach ($searchResponse['items'] as $searchResult) {
            switch ($searchResult['id']['kind']) {
              case 'youtube#video':
                $videos = new stdClass();
                $videos->thumnail = $searchResult['snippet']['thumbnails']['default']['url'];
                $videos->title = $searchResult['snippet']['title'];
                $videos->idVideo = $searchResult['id']['videoId'];

                $videos->subtitulos = searchInCaption($videos->idVideo, $arrayBBDD);
                array_push($resultSearchYoutube , $videos);
                break;
            }
          }
      
        //   $htmlBody =   "<h3>Videos</h3><ul>$videos</ul>";


        //    var_dump($resultSearchYoutube);

        $arrayVideosSubtitulos = array();
         foreach ($arrayBBDD as $videoBBDD) {
            $listResponse = $youtube->videos->listVideos("snippet",
            array('id' => $videoBBDD->idVideo));
            $datosVideo  = new stdClass();
            $datosVideo->thumbnail =  $listResponse[0]['snippet']['thumbnails']['default']['url'];
            $datosVideo->titulo = $listResponse[0]['snippet']['title'];
            $datosVideo->subtitulos = searchInCaption($videoBBDD->idVideo, $arrayBBDD);
            var_dump($datosVideo);
            array_push($arrayVideosSubtitulos, $datosVideo);
          }
        //var_dump($arrayBBDD);

      }else{
          $state = mt_rand();
          $client->setState($state);
          $_SESSION['state'] = $state;
      
          $authUrl = $client->createAuthUrl();
          redirect($authUrl);  
      }
//   }



    function buscarSubtitulos($query){

    $resultTotal = array();
    $caption = new Subtitulos();

    $result = array();
    $result =  $caption->findInCaption($query);


    $subs = array();
    $state = SRT_STATE_SUBNUMBER;
    $subNum = 0;
    $subText = '';
    $subTime = '';


    for ($i=0; $i < count($result); $i++) { 
        $captions = array();
        $subject = $result[$i]['archivo'];
        
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $subject) as $line) {
            switch ($state) {
                case SRT_STATE_SUBNUMBER:
                    $state = SRT_STATE_TIME;
                break;
                case SRT_STATE_TIME:
                    $subTime = trim($line);
                    $state = SRT_STATE_TEXT;
                break;
                case SRT_STATE_TEXT:
                    if(trim($line) == ''){
                        $sub = new stdClass();
                        $sub->startTime = explode(' --> ', $subTime)[0];
                        $sub->text = $subText;
                        $subText = '';
                        $state = SRT_STATE_SUBNUMBER;
        

                        if(strpos(quitar_tildes($sub->text), quitar_tildes($query)) !== FALSE){
                            $captions[] =  getSeconds(explode(",", $sub->startTime)[0]);
                        }
                    } else{
                        $subText .= $line;
                    }
                break;
            }
        }
        $resultado = new stdClass();
        $resultado->idVideo = $result[$i]['id_subtitulo'];
        $resultado->subtitulos = implode(",", $captions);// $captions
        $resultTotal[$i] = $resultado;
    }

    return $resultTotal;
    }

    /*Función que con el ID del vídeo de Youtube comprueba si la palabra buscada también aparece en los subtítulos de la BBDD */
    function searchInCaption($idVideo, &$array){
        $subtitulos = "";
        for ($i=0; $i < count($array) ; $i++) { 
            if($array[$i]->idVideo === $idVideo){
                $subtitulos = $array[$i]->subtitulos;
                array_splice($array, $i, 1);
            }
        }
        
    return $subtitulos;
    }

    function getSeconds($time){
    return strtotime($time) - strtotime('TODAY');
    }

    function quitar_tildes($cadena) {
        $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
        $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
        $texto = str_replace($no_permitidas, $permitidas ,$cadena);
        return $texto;
    }

?>



<!DOCTYPE HTML>
<html>

<head>
	<title>Filosofía y Linguistica</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<!--[if lte IE 8]><script src="resources/assets/js/ie/html5shiv.js"></script><![endif]-->
	<link rel="stylesheet" href="resources/assets/css/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!--[if lte IE 9]><link rel="stylesheet" href="resources/assets/css/ie9.css" /><![endif]-->
	<!--[if lte IE 8]><link rel="stylesheet" href="resources/assets/css/ie8.css" /><![endif]-->
</head>

<body>

	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Main -->
		<div id="main">
			<div class="inner">

				<!-- Header -->
				<header id="header">
					<a href="index.php" class="logo">
						<strong>Zaragoza Lingüística</strong>
					</a>
					<ul class="icons">
					<?php
						// if (is_null($rol) ) {
						// 	echo '<li><a class="button special small" data-toggle="modal" data-target="#myModal">Iniciar sesión</a></li>';
						// }
						// else {
						// 	$name = getName();
						// 	echo '<li>Bienvenido, '. $name . '&nbsp;</li>';
						// 	echo '<li><a href="administracion.php">Administrar &nbsp;</a></li>';
						// 	echo '<li><a id="enlace-logout" href="login.php">Salir</a></li>';
						// }
					?>
					</ul>
				</header>

				<!-- Section -->
				<section>
					<header class="major">
						<h2>Búsqueda</h2>
					</header>
					<div class="table-wrapper">
						<table>
							<thead>
								<tr>
									<th>Vídeo</th>
									<th>Título</th>
								</tr>
							</thead>
							<tbody>
                                <?php 
                                    for ($i=0; $i < count($arrayVideosSubtitulos); $i++) { 
                                        ?>
                                <tr>
									<td rowspan="2">
										<br>
										<a href="#" class="image">
											<img src=" <?= $arrayVideosSubtitulos[$i]->thumbnail ?>" alt="" />
										</a>
									</td>
									<td colspan="3"> <?=$arrayVideosSubtitulos[$i]->titulo?>
									</td>
									<td colspan="3"> <?=$arrayVideosSubtitulos[$i]->subtitulos?>
									</td>
								</tr>
								<tr></tr>
                                    <?php
									}
                                ?>

                                <?php 
                                    foreach ($resultSearchYoutube as $resultYoutube) {
                                        ?>
                                <tr>
									<td rowspan="2">
										<br>
										<a href="#" class="image">
											<img src=" <?= $resultYoutube->thumnail?>" alt="" />
										</a>
									</td>
									<td colspan="3"> <?=$resultYoutube->title?>

									</td>									
                                    <td colspan="3"> <?=$resultYoutube->subtitulos?>

									</td>
								</tr>
								<tr></tr>
                                    <?php
									}
                                ?>
							</tbody>
						</table>
					</div>
				</section>
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