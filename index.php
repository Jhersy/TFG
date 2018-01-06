<?php
require_once("src/App.php");
// require_once("scraping.php");
require_once("src/logic/Categorias.php");

$icons = array('icon fa fa-users', 'icon fa fa-language', 'icon fa fa-comments', 'icon fa-pencil-square-o', 'icon fa-pencil-square-o', 'icon fa-pencil-square-o');
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
  $_SESSION[$tokenSessionKey] = $client->getAccessToken();


  $_SESSION['sesion'] = $client->getAccessToken();
  

  
  header('Location: ' . $redirect);
  }
  
  if (isset($_SESSION[$tokenSessionKey])) {
  $client->setAccessToken($_SESSION[$tokenSessionKey]);
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
	<title>Filosofía y Linguistica</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<!--[if lte IE 8]><script src="resources/assets/js/ie/html5shiv.js"></script><![endif]-->
	

	<link rel="stylesheet" href="resources/assets/css/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="icon" href="https://secure.gravatar.com/blavatar/3455840a986cc52bce4a312622afb6b5?s=32" type="image/x-icon">
	<!-- #################### -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- ESTILO PERSONALIZADO -->
	<link rel="stylesheet" href="resources/assets/css/style.css" />
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
								$categoriaScraping = false;
								if(empty($categoriasVisibles)){
									// $categoriasVisibles = getAllCategories();
									$categoriasVisibles = $categoriasBBDD->getCategoriesBlog();
									// $categoriaScraping = true;
								}

								foreach ($categoriasVisibles as $category) { ?>
									<article >
										<span class="<?=$icons[$i];?>"></span>
										<div class="content">
											<h3 ><a href="list_videos.php?categoria=<?= $i//$categoriaScraping ?  $i : $category['id_categoria'] . "|" . formato_utf8($category['nombre_categoria'])?>"><?=$category['nombre_categoria'] //$categoriaScraping ?  $category : $category['nombre_categoria']?></a></h3>
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
	<!--[if lte IE 8]><script src="resources/assets/js/ie/respond.min.js"></script><![endif]-->
	<script src="resources/assets/js/main.js"></script>

</body>

</html>


<?php  } ?>