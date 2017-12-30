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
	<!--[if lte IE 8]><script src="resources/assets/js/ie/html5shiv.js"></script><![endif]-->
	<link rel="icon" href="https://secure.gravatar.com/blavatar/3455840a986cc52bce4a312622afb6b5?s=32" type="image/x-icon">
	<link rel="stylesheet" href="resources/assets/css/main.css" />
	<link rel="stylesheet" href="resources/assets/css/style.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!--[if lte IE 9]><link rel="stylesheet" href="resources/assets/css/ie9.css" /><![endif]-->
	<!--[if lte IE 8]><link rel="stylesheet" href="resources/assets/css/ie8.css" /><![endif]-->

	<script>
		function visibleCategoriasBlog(){
			var parametros = {
			"visibleBlog" : "1"
			}
			$.ajax({
			data:  parametros,
			url:   'editar_categoria.php',
			type:  'post',
			success:  function (data) {
				alert(data);
				window.location.href = "gestion_categorias.php";
			}
			});
		}
	</script>
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
													<a class="titulo_video" href="list_videos.php?categoria=<?=$i?>"><?=$category?></a>
												</div>
                                            </article>
                                        <?php
                                        $i++;
                                    }
                                ?>                            
						</div>
						<div class="9u 12u$(small)"></div>
						<div class="3u 12u$(small)" style="float:right;">
							<button class="button special small" onclick="visibleCategoriasBlog()">Usar este conjunto de categorías</button>		
						</div>
						<br>
					</section>
					
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
                                        <form action="list_videos.php" method="POST">
                                            <article>
                                                <span class="<?=$icons[$i];?>"></span>
												<div class="content">
													<h3 ><a href="list_videos.php?categoria=<?=$category['id_categoria'] . "|" . formato_utf8($category['nombre_categoria'])?>"><?=$category['nombre_categoria']?></a></h3>
												</div>
                                            </article>
                                        </form>
                                        <?php
                                        $j++;
                                    }
                                ?>
                        </div>
                            <hr class="major" />
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
	<!--[if lte IE 8]><script src="resources/assets/js/ie/respond.min.js"></script><![endif]-->
	<script src="resources/assets/js/main.js"></script>

</body>

</html>

<?php
}else{
	redirect("index.php");
}
?>

