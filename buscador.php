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
  
  $rol = isAdmin(); //Return session admin or null
  $query = strtolower($_GET['query']); 
  
//   if(!is_null($query/*$_GET['query']*/)){
  
    //  session_start();
      
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
                /*Información que no devuelve el método search de la API*/
                $videos = new stdClass();
                $listResponseSearch = $youtube->videos->listVideos("snippet, contentDetails, statistics",
                array('id' => $searchResult['id']['videoId']));

                $videos->visualizaciones = $listResponseSearch[0]['statistics']['viewCount'];
                $videos->comentarios = $listResponseSearch[0]['statistics']['commentCount'];
                $videos->likes = $listResponseSearch[0]['statistics']['likeCount'];
                $videos->duracion = getDuration($listResponseSearch[0]['contentDetails']['duration']);
                $videos->definicion = strtoupper($listResponseSearch[0]['contentDetails']['definition']);

                /* Información que devuelve el método SEARCH de la API */                
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
            $listResponse = $youtube->videos->listVideos("snippet, contentDetails, statistics",
            array('id' => $videoBBDD->idVideo));
            $datosVideo  = new stdClass();
            $datosVideo->thumbnail =  $listResponse[0]['snippet']['thumbnails']['default']['url'];
            $datosVideo->titulo = $listResponse[0]['snippet']['title'];
            $datosVideo->visualizaciones = $listResponse[0]['statistics']['viewCount'];
            $datosVideo->comentarios = $listResponse[0]['statistics']['commentCount'];
            $datosVideo->likes = $listResponse[0]['statistics']['likeCount'];
            $datosVideo->duracion = getDuration($listResponse[0]['contentDetails']['duration']);
            $datosVideo->definicion = strtoupper($listResponse[0]['contentDetails']['definition']);
            
            $datosVideo->subtitulos = searchInCaption($videoBBDD->idVideo, $arrayBBDD);
            $datosVideo->idVideo = $videoBBDD->idVideo;
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
        /* Se recorre línea a línea el archivo del subtítulo */
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
                        $palabraBusqueda = "/" . quitar_tildes($query) . "\b/";  //Expresión regular para buscar palabra exacta
                        $linea_texto = quitar_tildes($sub->text);


                        
                        if(preg_match($palabraBusqueda ,  strip_tags($linea_texto))){
                            $captions[] = explode(",", $sub->startTime)[0] . "|" .  strip_tags($sub->text);
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

    function getDuration($duration){
        // PT1H25M38S
    
        $parametros = array("PT", "H", "M","S");
        $salida   = array("", "h ", "m ", "s");
    
        $newDuration = str_replace($parametros, $salida, $duration);
    
        return $newDuration;
    
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
	<!-- ESTILO PERSONALIZADO -->
	<link rel="stylesheet" href="resources/assets/css/style.css" />
	<!-- #################### -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!--[if lte IE 9]><link rel="stylesheet" href="resources/assets/css/ie9.css" /><![endif]-->
	<!--[if lte IE 8]><link rel="stylesheet" href="resources/assets/css/ie8.css" /><![endif]-->
</head>
<script>
    function verVideo(idVideo, query, segundos){
		$("#id_video").val(idVideo);
		$("#query").val(query);
        $('#segundos').val(segundos);
		$("#viewVideo").submit();
	}

</script>

<body>

	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Main -->
		<div id="main">
			<div class="inner">

				<!-- Header -->
				<header id="header" style="padding-top:2em;">
                <a href="inicio.php" class="logo"><strong>Zaragoza Lingüística</strong></a>
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
                                <h3><span class="glyphicon glyphicon-lock"></span> Iniciar sesión</h3>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="login.php" method="post">
                                    <div class="form-group">
                                        <label for="username"><span class="glyphicon glyphicon-user"></span> Usuario</label>
                                        <input type="text" class="form-control" id="username" name="name" placeholder="Introduce identificador de usuario">
                                    </div>
                                    <div class="form-group">
                                        <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Contraseña</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Introduce contraseña">
                                    </div>
                                    <button type="submit" class="btn btn btn-block"<span class="glyphicon glyphicon-off"></span> Login</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
                <!--
                <ul class="icons">
                    <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
                    <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                    <li><a href="#" class="icon fa-youtube"><span class="label">Youtube</span></a></li>
                </ul>
                    
                -->
            </header>

				<!-- Section -->
                <section>
					<div class="row uniform">
						<div class="8u 12u$(small)" >
                            <h2>Resultados de búsqueda:  "<?=$_GET['query']?>"</h2>
						</div>			
						
						<div class="4u 12u$(small)">
							<form method="get" action="buscador.php">
								<div class="input-group">
										<input type="text" name="query" class="form-control" placeholder="Buscador">
										<span class="input-group-btn">
											<button class="botonBusqueda btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
										</span>
								</div>
							</form>
						</div>
					</div>
				</section>

                    
                    <?php
                    if(count($arrayVideosSubtitulos) + count($resultSearchYoutube) == 0){
                        echo "<p><span>No hay resultados para tu búsqueda</span></p>";
                    }else{
                    ?>
					<div class="table-wrapper">
                    <form  id="viewVideo" action="video_player.php" method="post">
                            <input id="id_video" type="hidden" name="datos[id_video]" value="">
                            <input id="query" type="hidden" name="datos[query]" value="">
                            <input id="segundos" type="hidden" name="datos[segundos]" value="">
                    </form>
						<table>
							<thead>
								<tr>
									<th>Vídeo</th>
									<th>Título</th>
								</tr>
							</thead>
							<tbody>
                                <?php 
                                $filas = 0;
                                $i = 0;
                                    for ($i=0; $i < count($arrayVideosSubtitulos); $i++) { 
                                         $id_video_subtitulo = $arrayVideosSubtitulos[$i]->idVideo;
                                        ?>
                                <tr class="fila_videos">
									<td rowspan="2">
										<br>
                                        <a href="video_player.php?id_video=<?php echo $arrayVideosSubtitulos[$i]->idVideo . "&query=" . $_GET["query"] . "&segundos=0" ?>">
                                            <img src=" <?= $arrayVideosSubtitulos[$i]->thumbnail ?>" alt="" />
                                            
                                        </a>

									</td>
									<td colspan="3"> 
                                    <a class="titulo_video" href="video_player.php?id_video=<?php echo $arrayVideosSubtitulos[$i]->idVideo . "&query=" . $_GET["query"] . "&segundos=0" ?>">
                                        <?=$arrayVideosSubtitulos[$i]->titulo?>
                                    </a>	

                                    <ul class="icons">
                                        <br>
                                        <li>
                                            <p><i class="fa fa-eye" aria-hidden="true"> <?= $arrayVideosSubtitulos[$i]->visualizaciones ?></i> visualizaciones</p>
                                        </li>
                                        <?php  if($arrayVideosSubtitulos[$i]->comentarios !=  "0") { ?>
                                        <li>
                                            <p><i class="fa fa-comments-o" aria-hidden="true"> <?= $arrayVideosSubtitulos[$i]->comentarios ?></i> comentarios</p>
                                        </li>
                                        <?php } else{ ?>

                                        <li>
                                            <p>Sin comentarios</p>
                                        </li>
                                            
                                        <?php } ?>
                                    </ul>
                                    <ul class="icons">
                                        <li>
                                            <p><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <?= $arrayVideosSubtitulos[$i]->likes?> </p>
                                        </li>
                                        <li>
                                            <p><i class="fa fa-clock-o" aria-hidden="true"> </i> <?= $arrayVideosSubtitulos[$i]->duracion?></p>
                                        </li>
                                        <?php  if( $arrayVideosSubtitulos[$i]->definicion == "HD") { ?>
                                            <li>
                                                <p><i class="fa fa-television" aria-hidden="true"> </i> <?= $arrayVideosSubtitulos[$i]->definicion?></p>
                                            </li>
                                        <?php } ?>
                                    </ul>
									


                                    <?php if($arrayVideosSubtitulos[$i]->subtitulos){ 
                                        ?>
                                        <p> <strong>Este término ha sido encontrado en las diferentes franjas de tiempo:
                                            <a data-toggle="collapse" href="#collapseExample<?=$i?>" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="fa fa-hand-o-down" aria-hidden="true" style="color: #f56a6a"></i>
                                            </a>
                                            </strong> 
                                        </p>
                                        <p class="collapse" id="collapseExample<?=$i?>">
											<br>
                                            <?php 
                                                $subtitulos = array();
                                                $subtitulos = explode(",", $arrayVideosSubtitulos[$i]->subtitulos);
                                                foreach ($subtitulos as $subtitulo) {
                                                    $infoSubtitulo = array();
                                                    $infoSubtitulo =  explode("|" , $subtitulo);
                                                   /* $lineaInfo = "<a href='#' onclick=" . "\"verVideo('" . $id_video_subtitulo . "' , '" .  $_GET["query"] . "' , '" . getSeconds($infoSubtitulo[0]) . "')\">";*/
                                                   $lineaInfo = "<a href='video_player.php?id_video=" . $id_video_subtitulo . "&query=" .  $_GET["query"] . "&segundos= " . getSeconds($infoSubtitulo[0]) . "'\>";
                                                   for($i = 0; $i< count($infoSubtitulo); $i++) {
                                                       if($i == 0){
                                                        $lineaInfo .=  "Minuto: " . $infoSubtitulo[$i] . '     ' ;
                                                       }else{
                                                            $lineaInfo .= "     Frase: \"" .  $infoSubtitulo[$i] . "\"";
                                                       }
                                                        
                                                        // for ($i=0; $i < count($info); $i++) { 
                                                        //     echo '<a class="button small">' .  $info[$i] . '</a>';
                                                        // }
                                                    }
                                                    $lineaInfo .= "</a> <br>";
                                                    echo $lineaInfo;
                                                } 
                                            ?>                                            
										</p>

                                    <?php
                                     } 
                                     ?>

                                    </td>
								</tr>
								<tr></tr>
                                    <?php
                                    }
                                    $filas = $i + 1;
                                    ?>

                                <?php 

                                    foreach ($resultSearchYoutube as $resultYoutube) {
                                        ?>
                                <tr>
									<td rowspan="2">
                                        <br>
                                        <a href="video_player.php?id_video=<?php echo $resultYoutube->idVideo . "&query=" . $_GET["query"] . "&segundos=0" ?>">
                                            <img src=" <?= $resultYoutube->thumnail?>" alt="" />
                                        </a>


									</td>
									<td colspan="3"> 
                                    <a class="titulo_video" href="video_player.php?id_video=<?php echo $resultYoutube->idVideo . "&query=" . $_GET["query"] . "&segundos=0" ?>">
                                        <?=$resultYoutube->title?>
                                    </a>	



                                    <ul class="icons">
                                        <br>
                                        <li>
                                            <p><i class="fa fa-eye" aria-hidden="true"> <?= $resultYoutube->visualizaciones ?></i> visualizaciones</p>
                                        </li>
                                        <?php  if($resultYoutube->comentarios !=  "0") { ?>
                                        <li>
                                            <p><i class="fa fa-comments-o" aria-hidden="true"> <?= $resultYoutube->comentarios ?></i> comentarios</p>
                                        </li>
                                        <?php } else{ ?>

                                        <li>
                                            <p>Sin comentarios</p>
                                        </li>
                                            
                                        <?php } ?>
                                    </ul>
                                    <ul class="icons">
                                        <li>
                                            <p><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <?= $resultYoutube->likes?> </p>
                                        </li>
                                        <li>
                                            <p><i class="fa fa-clock-o" aria-hidden="true"> </i> <?= $resultYoutube->duracion?></p>
                                        </li>
                                        <?php  if( $resultYoutube->definicion == "HD") { ?>
                                            <li>
                                                <p><i class="fa fa-television" aria-hidden="true"> </i> <?= $resultYoutube->definicion?></p>
                                            </li>
                                        <?php } ?>
                                    </ul>



                                        <?php if(!empty($resultYoutube->subtitulos)){ ?>
                                            <p> <strong>Este término ha sido encontrado en las diferentes franjas de tiempo:
                                                <a data-toggle="collapse" href="#collapseExample<?=$filas?>" aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fa fa-hand-o-down" aria-hidden="true" style="color: #f56a6a"></i>
                                                </a>
                                                </strong> 
                                            </p>
                                                <p class="collapse" id="collapseExample<?=$filas?>">
											<br>
                                            <?php 
                                                $subtitulos = array();
                                                $subtitulos = explode(",", $resultYoutube->subtitulos);
                                                foreach ($subtitulos as $subtitulo) {
                                                    $infoSubtitulo = array();
                                                    $infoSubtitulo =  explode("|" , $subtitulo);
                                                    /*$lineaInfo = "<a href='#' onclick=" . "\"verVideo('" . $resultYoutube->idVideo . "' , '" .  $_GET["query"] . "' , '" . getSeconds($infoSubtitulo[0]) . "')\">";*/
                                                   $lineaInfo = "<a href='video_player.php?id_video=" . $resultYoutube->idVideo . "&query=" .  $_GET["query"] . "&segundos= " . getSeconds($infoSubtitulo[0]) . "'\>";
                                                    for($i = 0; $i< count($infoSubtitulo); $i++) {
                                                        if($i == 0){
                                                            $lineaInfo .=  "Minuto: " . $infoSubtitulo[$i] . '     ' ;
                                                           }else{
                                                                $lineaInfo .= "     Frase: \"" .  $infoSubtitulo[$i] . "\"";
                                                           }
                                                        // for ($i=0; $i < count($info); $i++) { 
                                                        //     echo '<a class="button small">' .  $info[$i] . '</a>';
                                                        // }
                                                    }
                                                    $lineaInfo .= "</a> <br>";
                                                    echo $lineaInfo;
                                                } 
                                            ?>                                            
										</p>
                                        <?php } ?>
									</td>	
								</tr>
								<tr></tr>
                                    <?php
                                    $filas++;
									}
                                ?>
							</tbody>
						</table>
					</div>
                                <?php } ?>
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