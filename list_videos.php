
<?php

require_once("src/App.php");
// require_once("scraping.php");
require_once("src/logic/Categorias.php");
$rol = isAdmin(); //Return session admin or null


// $categoria = explode( "|", $_GET["categoria"]);
$categoria =  $_GET["categoria"];

// $catBBDD = false;
// if(count($categoria) > 1){
	// [0] ID categoría [1] Nombre de la categoría
	$catBBDD = true;
	$categoriasBBDD = new Categorias();
	$IdsVideos = $categoriasBBDD->getVideosOfCategory($categoria);	

	
// } 
// else if(count($categoria) == 1){
// 	$categoryName = getNameCategory($categoria[0]);
// 	$IdsVideos = getIDsVideos($categoria[0]);
// } else{
// 	// $categoryName = "NO HAY VÍDEOS";
// 	// $IdsVideos = getIDsVideos($categoria[0]);
// }


$videos = array();


if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
	throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
  }
  
  require_once __DIR__ . '/vendor/autoload.php';
//   session_start();
  
  $OAUTH2_CLIENT_ID = "88517581272-gu071qtdg26cg9oqbu8v3pmifgg6jogv.apps.googleusercontent.com";
  $OAUTH2_CLIENT_SECRET = "4xobKsbsIv2nFo7XOhcadA6V";
  
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
  
  if ($client->getAccessToken()) {
	  // $videoId = "wisbrPN9fbI";  

	  // ESTADÍSTICAS DE UN VÍDEO
	  foreach ($IdsVideos as $videoId) {
		   
		$listResponse = $youtube->videos->listVideos("snippet, contentDetails, statistics",
		array('id' => $catBBDD ? $videoId['id_video'] : $videoId));
		array_push($videos, $listResponse[0]);
	  }

	  
  }else{
	  $state = mt_rand();
	  $client->setState($state);
	  $_SESSION['state'] = $state;
  
	  $authUrl = $client->createAuthUrl();
	  echo "<h3>Authorization Required</h3><p>You need to <a href=" . $authUrl . ">authorize access</a> before proceeding.<p>";
	  redirect($authUrl);
  
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
				<div style="padding: 30px 0px 60px 0px">
					<div class="row uniform">
						<div class="8u 12u$(small)" >
							<h3><?= $categoriasBBDD->getNameCategory($categoria)[0]['nombre_categoria']?></h3>
						</div>			
						
						<!-- Buscador -->
						<?php require('includes/buscador.php'); ?>
  						<!-- 		  -->
					</div>
  				</div>
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
                                    for ($i=0; $i < count($videos); $i++) { 
                                        ?>
                                <tr class="fila_videos">
									<td rowspan="2">
										<br>
										<a href="video_player.php?id_video=<?php echo $videos[$i]['id'] . "&categoria=" . $_GET["categoria"] ?>">
											<img class="image_video" src=" <?= $videos[$i]['snippet']['thumbnails']['default']['url'] ?>" alt="" />
										</a>
									</td>
									<td colspan="3"> 
										<a class="titulo_video" href="video_player.php?id_video=<?php echo $videos[$i]['id'] . "&categoria=" . $_GET["categoria"] ?>">
											<?=$videos[$i]['snippet']['title']?>
										</a>		
                                            
											<ul class="icons">
												<br>
												<li>
													<p><i class="fa fa-eye" aria-hidden="true"> <?= $videos[$i]['statistics']['viewCount']?></i> visualizaciones</p>
												</li>
												<?php  if($videos[$i]['statistics']['commentCount'] !=  "0") { ?>
												<li>
													<p><i class="fa fa-comments-o" aria-hidden="true"> <?= $videos[$i]['statistics']['commentCount']?></i> comentarios</p>
												</li>
												<?php } else{ ?>

												<li>
													<p>Sin comentarios</p>
												</li>
													
												<?php } ?>
											</ul>
											<ul class="icons">
												<li>
													<p><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <?= $videos[$i]['statistics']['likeCount']?> </p>
												</li>
												<li>
													<p><i class="fa fa-clock-o" aria-hidden="true"> </i> <?= getDuration($videos[$i]['contentDetails']['duration'])?></p>
												</li>
												<?php  if($videos[$i]['contentDetails']['definition'] == "hd") { ?>
													<li>
														<p><i class="fa fa-television" aria-hidden="true"> </i> <?= strtoupper($videos[$i]['contentDetails']['definition']);?></p>
													</li>
												<?php } ?>
											</ul>
									</td>
								</tr>
								<tr></tr>
                                    <?php
									}
                                ?>

							</tbody>
						</table>
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