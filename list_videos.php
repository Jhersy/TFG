
<?php

require_once("src/App.php");
$rol = isAdmin(); //Return session admin or null

require_once("scraping.php");
$categoria = $_GET["category"];
$categoryName = getNameCategory($categoria);
$IdsVideos = getIDsVideos($categoria);

$videos = array();


if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
	throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
  }
  
  require_once __DIR__ . '/vendor/autoload.php';
  session_start();
  
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
	  // $videoId = "wisbrPN9fbI";  

	  // ESTADÍSTICAS DE UN VÍDEO
	  foreach ($IdsVideos as $videoId) {
		$listResponse = $youtube->videos->listVideos("snippet, contentDetails, statistics, player",
		array('id' => $videoId));
		array_push($videos, $listResponse[0]);
	  }

	  
  }else{
	  $state = mt_rand();
	  $client->setState($state);
	  $_SESSION['state'] = $state;
  
	  $authUrl = $client->createAuthUrl();
	  echo "<h3>Authorization Required</h3><p>You need to <a href=" . $authUrl . ">authorize access</a> before proceeding.<p>";
  
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
				</header>

				<!-- Section -->
				<section>
					<header class="major">
						<h2><?=$categoryName?></h2>
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
                                    for ($i=0; $i < count($videos); $i++) { 
                                        ?>
                                <tr>
									<td rowspan="2">
										<br>
										<a href="#" class="image">
											<img src=" <?= $videos[$i]['snippet']['thumbnails']['default']['url'] ?>" alt="" />
										</a>
									</td>
									<td colspan="3"> <?=$videos[$i]['snippet']['title']?>
										<p>
											<br>
											<a class="button small"> <?= $videos[$i]['contentDetails']['definition']?></a>
                                            <?php
                                                if($videos[$i]['contentDetails']['caption'] == "false") ?>
                                                    <a class="button disabled small">Subtítulos</a>
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