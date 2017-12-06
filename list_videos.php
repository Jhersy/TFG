
<?php

require_once("src/App.php");
require_once("scraping.php");
require_once("src/logic/Categorias.php");
$rol = isAdmin(); //Return session admin or null


// $categoria = explode( "|", $_GET["category"]);
$categoria = explode( "|", $_GET["categoria"]);

$catBBDD = false;
if(count($categoria) > 1){
	// [0] ID categoría [1] Nombre de la categoría
	$catBBDD = true;
	$categoriasBBDD = new Categorias();
	$IdsVideos = $categoriasBBDD->getVideosOfCategory($categoria[0]);	
	
} else if(count($categoria) == 1){
	$categoryName = getNameCategory($categoria[0]);
	$IdsVideos = getIDsVideos($categoria[0]);
} else{
	// $categoryName = "NO HAY VÍDEOS";
	// $IdsVideos = getIDsVideos($categoria[0]);
}


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
		   
		$listResponse = $youtube->videos->listVideos("snippet, contentDetails, statistics, player",
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
							<h2><?php echo $catBBDD ?  $categoria[1] : $categoryName;?></h2>
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
                                <tr>
									<td rowspan="2">
										<br>
										<a href="video_player.php?id_video=<?php echo $videos[$i]['id'] . "&categoria=" . $_GET["categoria"] ?>">
											<img src=" <?= $videos[$i]['snippet']['thumbnails']['default']['url'] ?>" alt="" />
										</a>
									</td>
									<td colspan="3"> 
										<a class="titulo_video" href="video_player.php?id_video=<?php echo $videos[$i]['id'] . "&categoria=" . $_GET["categoria"] ?>">
											<?=$videos[$i]['snippet']['title']?>
										</a>						
									
										<p>
											<br>
											<a class="button small"> <?= $videos[$i]['contentDetails']['definition']?></a>
                                            <?php
                                                // if($videos[$i]['contentDetails']['caption'] == "false") ?>
                                                    <!-- <a class="button disabled small">Subtítulos</a> -->
                                                <?php
                                            ?>
                                            
											<ul class="icons">
												<li>
													<i class="fa fa-eye" aria-hidden="true"> <?= $videos[$i]['statistics']['viewCount']?></i>
												</li>
												<li>
													<i class="fa fa-thumbs-o-up" aria-hidden="true"> <?= $videos[$i]['statistics']['likeCount']?></i>
												</li>
												<li>
													<i class="fa fa-clock-o" aria-hidden="true"> <?= getDuration($videos[$i]['contentDetails']['duration'])?></i>
												</li>
											</ul>
										</p>
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