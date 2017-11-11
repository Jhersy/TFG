<?php

require_once("src/App.php");
//$rol = isAdmin(); //Return session admin or null

require_once("scraping.php");
$categories = getAllCategories();
$icons = array('icon fa fa-users small', 'icon fa fa-language small', 'icon fa fa-comments small', 'icon fa-pencil-square-o small', 'icon fa-pencil-square-o', 'icon fa-pencil-square-o');


if(true/*!is_null($rol)*/){
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
					<a href="administracion.html" class="logo"><strong>Zaragoza Lingüística - Gestión de Categorías</strong></a>
					<ul class="icons">
					<?php
                        if (true/*!is_null($rol) */) {
							echo '<li>Bienvenido, '. getName() . '&nbsp;</li>';
                            echo '<li><a href="administracion.html">Administrar &nbsp;</a></li>';
                            echo '<li><a id="enlace-logout" href="login.php">Salir</a></li>';                        }
					?>
					</ul>
				</header>
				<!-- Content -->
				<section>
                    <header class="main">
						<h4>Categorías del Blog:</h4>
                    </header>
                        <div class="features">
                        <?php
                            $i = 0;
                            foreach ($categories as $category) { ?>
                                <article>
                                    <span class="<?=$icons[$i];?>"></span>
                                    <div class="content">
                                        <h4><a href="list_videos.php?category=<?=$i?>"><?=$category?></a></h4>
                                    </div>
                                    <div class="modal fade" id="exampleModal<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <a type="button" class="close" data-dismiss="modal">&times;</a>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Desea eliminar la categoría: <b><?=$category?></b>?
                                                </div>
                                                <form action="gestion_categorias.php">
                                                    <input type="hidden" name="cat" value="<?=$i?>">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <input type="submit" class="btn btn-primary" value="Aceptar">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <?php
                                $i++;
                            }
						?>
						</div>
						<hr class="major" />
						<div class="features">
                            <article>
                                <span class="icon fa fa-plus small"></span>
                                <div class="content">
                                    <h4><a data-toggle="modal" data-target="#myModal">Crear/Modificar conjunto de categorías</a></h4>
                                </div>
                            </article>
                        </div>
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
						<li><a href="index.php">Nueva Categoría</li>
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