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
  require_once("src/logic/Informacion.php");
  $rol = isAdmin(); //Return session admin or null
  $query = quitar_tildes($_GET['query']); 
  $query = strtolower($query);
      
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
        //LLAMADA AL MÉTODO DE LA API QUE REALIZA LA BÚSQUEDA
        $searchResponse = $youtube->search->listSearch('id,snippet', array(
        'q' => $query,
        'channelId' => 'UCG_fXqOLea9FSTLoWZieaqw',
        ));
        
        //BÚSQUEDA EN LOS SUBTÍTULOS
        $resultSearchYoutube = array();
        $arrayBBDD = array();
        $arrayBBDD = buscarSubtitulos($query); // SE TRAE LOS VIDEOS EN LOS QUE EL TÉRMINO APARECE EN EL SUBTITULO
    
        foreach ($searchResponse['items'] as $searchResult) {
            switch ($searchResult['id']['kind']) {
                case 'youtube#video':
                    $videos = new stdClass();
                    //SE OBTIENEN LOS DATOS DE CADA VÍDEO RESULTANTE DE LA BÚSQUEDA DE YOUTUBE
                    $listResponseSearch = $youtube->videos->listVideos("snippet, contentDetails, statistics",
                    array('id' => $searchResult['id']['videoId']));

                    $videos->visualizaciones = $listResponseSearch[0]['statistics']['viewCount'];
                    $videos->comentarios = $listResponseSearch[0]['statistics']['commentCount'];
                    $videos->likes = $listResponseSearch[0]['statistics']['likeCount'];
                    $videos->duracion = getDuration($listResponseSearch[0]['contentDetails']['duration']);
                    $videos->definicion = strtoupper($listResponseSearch[0]['contentDetails']['definition']);                
                    $videos->thumnail = $searchResult['snippet']['thumbnails']['default']['url'];
                    $videos->title = $searchResult['snippet']['title'];
                    $videos->idVideo = $searchResult['id']['videoId'];

                    //SE AÑADEN LOS INSTANTES EN LOS QUE SE HA ENCONTRADO LA BÚSQUEDA DEL USUARIO EN UN SUBTÍTULO
                    $videos->subtitulos = searchInCaption($videos->idVideo, $arrayBBDD);
                    array_push($resultSearchYoutube , $videos);
                break;
            }
        }

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
                        $palabraBusqueda = "/" . $query . "\b/";  //Expresión regular para buscar palabra exacta
                        $linea_texto = $sub->text;

                        //Se retiran las etiquetas HTML
                        $linea_busqueda = strip_tags($linea_texto);
                        //La búsqueda se realiza comparando caracteres sin tildes                        
                        $linea_busqueda = quitar_tildes($linea_busqueda);
                        
                        if(preg_match($palabraBusqueda ,  $linea_busqueda)){
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
	<title>Resultados de búsqueda: <?=$_GET['query']?></title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<!--[if lte IE 8]><script src="resources/assets/js/ie/html5shiv.js"></script><![endif]-->
	<link rel="icon" href="https://secure.gravatar.com/blavatar/3455840a986cc52bce4a312622afb6b5?s=32" type="image/x-icon">
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

<body>

	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Main -->
		<div id="main">
			<div class="inner">

				<!-- Header -->
				<?php require('includes/cabecera.php'); ?>
				<!-- 		-->

				<!-- Section -->
                <section>
					<div class="row uniform">
						<div class="8u 12u$(small)" >
                            <h2>Resultados de búsqueda:  "<?=$_GET['query']?>"</h2>
						</div>			
						
							<!-- Buscador -->
							<?php require('includes/buscador.php'); ?>
							<!-- 		  -->
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
                                        <?php } 
                                            $subtitulos = new Subtitulos();
                                            if($subtitulos->existCaption($arrayVideosSubtitulos[$i]->idVideo)){ 
                                        ?>
                                            <li>
                                                <strong><p><i class="fa fa-file-o" aria-hidden="true"></i></i> Subtítulo</p></strong>
                                            </li>
                                        <?php
                                            } 
                                            $informacion = new Informacion();
                                            if($informacion->existInformation($arrayVideosSubtitulos[$i]->idVideo)){ 
                                        ?>
                                            <li>
                                                <strong><p><i class="fa fa-paperclip" aria-hidden="true"></i> Info extra</p></strong>
                                            </li>
                                        <?php
                                            } 
                                        ?>
                                    </ul>
									


                                    <?php if($arrayVideosSubtitulos[$i]->subtitulos){ 
                                        ?>
                                        <p> <a data-toggle="collapse" href="#collapseExample<?=$i?>" aria-expanded="false" aria-controls="collapseExample">
                                            <strong>Este término se ha pronunciado en el vídeo en los siguientes momentos:
                                            <i class="fa fa-hand-o-down" aria-hidden="true" style="color: #f56a6a; font-size:18px"></i>
                                            </strong> 
                                            </a>
                                        </p>
                                        <p class="collapse" id="collapseExample<?=$i?>">
											<br>
                                            <?php 
                                                $subtitulos = array();
                                                $subtitulos = explode(",", $arrayVideosSubtitulos[$i]->subtitulos);
                                                foreach ($subtitulos as $subtitulo) {
                                                    $infoSubtitulo = array();
                                                    $infoSubtitulo =  explode("|" , $subtitulo);
                                                   $lineaInfo = "<a style='text-decoration:none;' href='video_player.php?id_video=" . $id_video_subtitulo . "&query=" .  $_GET["query"] . "&segundos= " . getSeconds($infoSubtitulo[0]) . "'\>";
                                                   for($i = 0; $i< count($infoSubtitulo); $i++) {
                                                       if($i == 0){
                                                        $lineaInfo .=  "Minuto: " . $infoSubtitulo[$i] . ' - "' ;
                                                       }else{
                                                            $lineaInfo .=  $infoSubtitulo[$i] . " (...)\"";
                                                       }
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
                                        <?php } 
                                                $subtitulos = new Subtitulos();
                                                if($subtitulos->existCaption($resultYoutube->idVideo)){ 
                                            ?>
                                                <li>
                                                    <strong><p><i class="fa fa-file-o" aria-hidden="true"></i></i> Subtítulo</p></strong>
                                                </li>
                                            <?php
                                                } 
                                                $informacion = new Informacion();
                                                if($informacion->existInformation($resultYoutube->idVideo)){ 
                                            ?>
                                                <li>
                                                    <strong><p><i class="fa fa-paperclip" aria-hidden="true"></i> Info extra</p></strong>
                                                </li>
                                            <?php
                                                } 
                                            ?>
                                    </ul>



                                        <?php if(!empty($resultYoutube->subtitulos)){ ?>
                                            <p> 
                                                <a data-toggle="collapse" href="#collapseExample<?=$filas?>" aria-expanded="false" aria-controls="collapseExample">
                                                <strong>Este término se ha pronunciado en el vídeo en los siguientes momentos:
                                                <i class="fa fa-hand-o-down" aria-hidden="true" style="color: #f56a6a; font-size:18px"></i>
                                                </strong> 
                                                </a>
                                            </p>
                                                <p class="collapse" id="collapseExample<?=$filas?>">
											<br>
                                            <?php 
                                                $subtitulos = array();
                                                $subtitulos = explode(",", $resultYoutube->subtitulos);
                                                foreach ($subtitulos as $subtitulo) {
                                                    $infoSubtitulo = array();
                                                    $infoSubtitulo =  explode("|" , $subtitulo);
                                                   $lineaInfo = "<a c href='video_player.php?id_video=" . $resultYoutube->idVideo . "&query=" .  $_GET["query"] . "&segundos= " . getSeconds($infoSubtitulo[0]) . "'\>";
                                                    for($i = 0; $i< count($infoSubtitulo); $i++) {
                                                        if($i == 0){
                                                            $lineaInfo .=  "Minuto: " . $infoSubtitulo[$i] . '    - "' ;
                                                           }else{
                                                                $lineaInfo .=  $infoSubtitulo[$i] . " (...)\"";
                                                           }
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