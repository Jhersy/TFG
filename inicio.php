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
				<section style = "padding: 10px 0px 10px 0px">
					<div class="row uniform">
							<div class="8u 12u$(small)" ></div>			
							<div class="4u 12u$(small)">
							<form method="post" action="buscador.php">
								<div class="input-group">
										<input type="text" name="query" class="form-control" placeholder="Buscador">
										<span class="input-group-btn">
											<button style="font-size:10px; border:none;" class="btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
										</span>
								</div>
								</form>
							</div>

					</div>

				</section>
				<section id="banner">

					<div class="content">

						<header>
							<h1>Zaragoza Lingüística<br /> a la carta</h1>
							<p>Seminario Permanente de Investigaciones Lingüísticas. Grupo Psylex (Universidad de Zaragoza, España)</p>
						</header>
						<p>Zaragoza Lingüística a la carta" es un repositorio de archivos multimedia sobre el lenguaje y las lenguas. Estos archivos
							provienen de las charlas divulgativas que tienen lugar todos los meses desde el año 2009 en el Seminario permanente
							de ZARAGOZA LINGÜÍSTICA. Este seminario ZL está fomentado y organizado por el grupo de investigación Psylex de la
							Universidad de Zaragoza. El repositorio incluye archivos desde el año 2013</p>

					</div>

					<span class="image object">
						<img src="resources/images/index.png" alt="" />
					</span>
				</section>

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
									<article>
										<span class="<?=$icons[$i];?>"></span>
										<div class="content">
											<form action="list_videos.php" method="POST">
												<h3 style="font-size: 12px;"><input type="submit" value="<?= $categoriaScraping ?  $category : $category['nombre_categoria']?>"></h3>
												<input type="hidden" name="category" value="<?=$categoriaScraping ?  $i : $category['id_categoria'] . "|" . $category['nombre_categoria']?>">
											</form>
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


