<?php
require_once("src/App.php");
$rol = isAdmin(); //Return session admin or null

if(!is_null($rol)){
?>
<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<head>
	<title>Administración</title>
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

			<header id="header" style="padding-top:2em;">
			<div class="8u 8u$(small)">
				<a href="inicio.php" class="logo"><strong>Zaragoza Lingüística</strong></a>					
			</div>
			<div class="4u 3u$(small)">
				<ul class="icons">
				<?php
					if (is_null($rol) ) {
						echo '<li><a class="button special small" data-toggle="modal" data-target="#myModal">Iniciar sesión</a></li>';
					}
					else {
						$name = getName();
						echo '<li>Bienvenido, '. $name . ' <a id="enlace-logout" href="login.php">Salir</a></li>';
					}
				?>
				</ul>					
			</div>

			<!--
			<ul class="icons">
				<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
				<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
				<li><a href="#" class="icon fa-youtube"><span class="label">Youtube</span></a></li>
			</ul>
				
			-->
		</header>
				<!-- Content -->
				<section>
					<div class="row">
						<div class="6u 12u$(small)">
							<h3>Gestión de categorías</h3>
							<a href="gestion_categorias.php"><span class="image fit"><img src="resources/images/gestion.jpg" alt=""></span></a>
						</div>
						<div class="6u 12u$(small)">
							<h3>Subir subtítulo</h3>
							<a href="subir_subtitulos.php"><span class="image fit"><img src="resources/images/upload.jpg" alt=""></span></a>
						</div>
						<div class="6u 12u$(small)">
							<h3>Añadir administrador</h3>
							<a href="anadir_administrador.php"><span class="image fit"><img src="resources/images/upload.jpg" alt=""></span></a>
						</div>
					</div>
				</section>
					<hr class="major" />

				</section>

			</div>
		</div>

		<!-- Sidebar -->
		<div id="sidebar">
			<div class="inner">

				<!-- Search 
				<section id="search" class="alt">
					<form method="post" action="#">
						<input type="text" name="query" id="query" placeholder="Search" />
					</form>
				</section>
				-->	
				<!-- Menu -->
				<nav id="menu">
					<header class="major">
						<h2>Menú</h2>
					</header>
					<ul>
						<li><a href="index.php">Home</a></li>
						<li>
							<span class="opener">Categorías</span>
							<ul>
								<li><a href="#">Lorem Dolor</a></li>
								<li><a href="#">Ipsum Adipiscing</a></li>
								<li><a href="#">Tempus Magna</a></li>
								<li><a href="#">Feugiat Veroeros</a></li>
							</ul>
						</li>
						<li><a href="conjunto_categorias.php">Gestionar Categorías</a></li>
						<li><a href="subir_subtitulos.php">Subir subtítulos</a></li>
					</ul>
				</nav>
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

<?php
}else{
	redirect("index.php");
}
?>