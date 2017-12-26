<?php
//include "src/App.php";
require_once("src/App.php");
require_once("scraping.php");
require_once("src/logic/Categorias.php");

$icons = array('icon fa fa-users', 'icon fa fa-language', 'icon fa fa-comments', 'icon fa-pencil-square-o', 'icon fa-pencil-square-o', 'icon fa-pencil-square-o');
$rol = isAdmin(); //Return session admin or null

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

				<div style = "padding: 10px 0px 10px 0px">
					<div class="row uniform">
							<div class="8u 12u$(small)" ></div>			
							<div class="4u 12u$(small)">
							<form method="get" action="buscador.php">
								<div class="input-group">
										<input type="text" name="query" class="form-control" placeholder="Buscador">
										<span class="input-group-btn">
											<button type="input" class="botonBusqueda btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
										</span>
								</div>
								</form>
							</div>

					</div>

				</div>

				<!--Contenido Portada -->
				<?php require('includes/contenido_portada.php'); ?>
				<!-- -->
				<!-- Section -->
				<section>
					<header class="major">
						<h2>Categorías</h2>
					</header>
					<div class="features">
						
							<?php
								$i = 0;
								//SI SE MUESTRA CATEGORIAS DE LA BBDD, PASAR EN VALUE OTRO CAMPO INDICANDO QUE SE MIRE EN LA BBDD
								$categoriasBBDD = new Categorias();
								$categoriasVisibles = $categoriasBBDD->getCategoriesVisibles();
								$categoriaScraping = false;
								if(empty($categoriasVisibles)){
									$categoriasVisibles = getAllCategories();
									$categoriaScraping = true;
								}
								//$categories = getAllCategories();

								foreach ($categoriasVisibles as $category) { ?>
									<article >
										<span class="<?=$icons[$i];?>"></span>
										<div class="content">
											<h3 ><a href="list_videos.php?categoria=<?=$categoriaScraping ?  $i : $category['id_categoria'] . "|" . $category['nombre_categoria']?>"><?= $categoriaScraping ?  $category : $category['nombre_categoria']?></a></h3>
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


