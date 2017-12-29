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
	<link rel="icon" href="https://secure.gravatar.com/blavatar/3455840a986cc52bce4a312622afb6b5?s=32" type="image/x-icon">
	<link rel="stylesheet" href="resources/assets/css/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- ESTILO PERSONALIZADO -->
	<link rel="stylesheet" href="resources/assets/css/style.css" />
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
							<a href="anadir_administrador.php"><span class="image fit"><img src="resources/images/administrador.jpg" alt=""></span></a>
						</div>
					</div>
				</section>
					<hr class="major" />

				</section>

			</div>
		</div>

		<!-- MENÚ ADMINSITRADOR -->
		<?php require('includes/menu_administrador.php'); ?>
		<!-- 					-->
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