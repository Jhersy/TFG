<?php
require_once("src/App.php");
require_once("src/logic/Categorias.php");

$icons = array('icon fa fa-users small', 'icon fa fa-language small', 
            'icon fa fa-comments small', 'icon fa-pencil-square-o small', 
            'icon fa fa-users small', 'icon fa fa-language small', 
			'icon fa fa-comments small', 'icon fa-pencil-square-o small',
			'icon fa fa-users small', 'icon fa fa-language small', 
			'icon fa fa-comments small', 'icon fa-pencil-square-o small');
			
$rol = isAdmin(); //Return session admin or null

/* INICIO DE LA APLICACIÓN */

  require_once __DIR__ . '/vendor/autoload.php';
  // session_start();
  
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
  
  // Check if an auth token exists for the required scopes
  $tokenSessionKey = 'token-' . $client->prepareScopes();
  if (isset($_GET['code'])) {
	if (strval($_SESSION['state']) !== strval($_GET['state'])) {
	  die('The session state did not match.');
	}
  
  $client->authenticate($_GET['code']);
//   $_SESSION[$tokenSessionKey] = $client->getAccessToken();
  $_SESSION['sesion'] = $client->getAccessToken();
  
  header('Location: ' . $redirect);
  }
  
  if (isset($_SESSION['sesion'])) {
  	$client->setAccessToken($_SESSION['sesion']);
  }
  
  
  if (!$client->getAccessToken()) {
	  $state = mt_rand();
	  $client->setState($state);
	  $_SESSION['state'] = $state;
  
	  $authUrl = $client->createAuthUrl();
	  echo "<h3>Authorization Required</h3><p>You need to <a href=" . $authUrl . ">authorize access</a> before proceeding.<p>";
	  redirect($authUrl);
  
  }else{
?>
<!DOCTYPE HTML>
<html>

<head>
	<title>Zaragoza Linguistica a la carta</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="resources/assets/css/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="icon" href="https://secure.gravatar.com/blavatar/3455840a986cc52bce4a312622afb6b5?s=32" type="image/x-icon">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- ESTILO PERSONALIZADO -->
	<link rel="stylesheet" href="resources/assets/css/style.css" />
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

				<!--Contenido Portada -->
				<?php require('includes/contenido_portada.php'); ?>
				<!-- -->
				<!-- Section -->
				<section>
					<div style="padding: 0px 0px 60px 0px">
						<div class="row uniform">
							<div class="8u 12u$(small)"><h2>Categorías de los vídeos</h2></div>

							<?php require('includes/buscador.php'); ?>
						</div>
					</div>

					<div class="features">
						<?php
							$i = 1;
							//SI SE MUESTRA CATEGORIAS DE LA BBDD, PASAR EN VALUE OTRO CAMPO INDICANDO QUE SE MIRE EN LA BBDD
							$categoriasBBDD = new Categorias();
							$categoriasVisibles = $categoriasBBDD->getCategoriesVisibles();
							
							if(empty($categoriasVisibles)){
								$categoriasVisibles = $categoriasBBDD->getCategories('1');
							}

							foreach ($categoriasVisibles as $category) { ?>
								<article >
									<span class="<?=$icons[$i];?>"></span>
									<div class="content">
										<h3 ><a href="list_videos.php?categoria=<?= $i?>"><?=$category['nombre_categoria']?></a></h3>
									</div>
								</article>
								<?php
								$i++;
							}
						?>
					</div>
					
				</section>
			</div>
		</div>

	</div>
	<!-- Scripts -->
	<script src="resources/assets/js/jquery.min.js"></script>
	<script src="resources/assets/js/skel.min.js"></script>
	<script src="resources/assets/js/util.js"></script>
	<script src="resources/assets/js/main.js"></script>

</body>

</html>


<?php  } ?>