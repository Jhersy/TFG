<?php

require_once("src/App.php");
require_once("scraping.php");
require_once("src/logic/Categorias.php");
$rol = isAdmin(); //Return session admin or null


$categories = getAllCategories();

$icons = array('icon fa fa-users small', 'icon fa fa-language small', 'icon fa fa-comments small', 'icon fa-pencil-square-o small', 'icon fa-pencil-square-o', 'icon fa-pencil-square-o' , 'icon fa fa-comments small');


if(!is_null($rol)){
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>Administración</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="icon" href="https://secure.gravatar.com/blavatar/3455840a986cc52bce4a312622afb6b5?s=32" type="image/x-icon">
	<link rel="stylesheet" href="resources/assets/css/main.css" />
	<link rel="stylesheet" href="resources/assets/css/style.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="resources/assets/js/loading.js" ></script>

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
					<section>
						<header class="main">
							<h4>Categorías creadas y visibles:</h4>
						</header>
                        <div class="features">
                            
                                <?php
                                    $categoriasBBDD = new Categorias();
                                    $categoriasVisibles = $categoriasBBDD->getCategoriesVisibles();
                                    $j = 0;
                                    foreach ($categoriasVisibles as $category) { ?>
                                            <article>
                                                <span class="<?=$icons[$j];?>"></span>
												<div class="content">
													<a class="titulo_video" href="list_videos.php?categoria=<?=$category['id_categoria'] . "|" . formato_utf8($category['nombre_categoria'])?>"><?=$category['nombre_categoria']?></a>
												</div>
                                            </article>
                                        <?php
                                        $j++;
                                    }
                                ?>
                        </div>
					</section>
					<section>
                            <div class="features">
                                <article>
                                    <span class="icon fa fa-cog"></span>
                                    <div class="content">
                                        <h4><a href="conjunto_categorias.php">Administrar categorías</a></h4>
                                    </div>
                                </article>
                            </div>

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
	<script src="resources/assets/js/main.js"></script>

</body>

</html>

<?php
}else{
	redirect("index.php");
}
?>

