<?php
require_once("scraping.php");
require_once("src/logic/Categorias.php");
require_once("src/App.php");

$rol = isAdmin(); //Return session admin or null

if(!is_null($rol)){

    
$categories = new Categorias();

$categorias = array();
$categorias =  $categories->getCategories();


try {
    //Scraping
    $videos = array();
    $videos = getAllIDsVideos();
} catch (Exception $e) {
    redirect("conjunto_categorias.php");
}


$icons = array('icon fa fa-users small', 'icon fa fa-language small', 'icon fa fa-comments small', 'icon fa-pencil-square-o small', 'icon fa-pencil-square-o', 'icon fa-pencil-square-o');

?>
<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<head>
	<title>Modificar Categorías</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<!--[if lte IE 8]><script src="resources/assets/js/ie/html5shiv.js"></script><![endif]-->
	<link rel="stylesheet" href="resources/assets/css/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!--[if lte IE 9]><link rel="stylesheet" href="resources/assets/css/ie9.css" /><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" href="resources/assets/css/ie8.css" /><![endif]-->
    <script>

        function guardarCategoria(){
            /* Primero se verifica si los vídeos seleccionados tienen o no categoría asociada */



            /* Se pregunta si se desea continuar (esto podría actualizar la categoría del vídeo) */
            
                if($('#nombreCategoria').val().trim() == ""){
                    alert("El nombre de la categoría no puede ser vacía");
                }else if ($("input:checkbox:checked").length == 0){
                    alert("Seleccione un vídeo para crear la categoría")
                }else{
                    var aceptar = confirm("Recuerda que puede haber vídeos que pertenezcan a otra categoría. En este caso, los vídeos seleccionados pasarán a formar parte de la nueva");
                    if(aceptar){
                        var $ids = "";
                        var $names = "";
                        $("input:checkbox:checked").each(function(){    
                        var $this = $(this);    
                            $ids += $this.attr("id") + "|";
                            $names += $this.next().text() + "|";                    
                        });
        
                        var parametros = {
                                "nombreCategoria" : $('#nombreCategoria').val().trim(),
                                "IdsVideos" : $ids,
                                "nombreVideo" : $names
                        };
                        $.ajax({
                                data:  parametros,
                                url:   'nueva_categoria.php',
                                type:  'post',
                                success:  function () {
                                    $('#myModal').hide();
                                    alert('Categoría creada con éxito!');
                                    window.location.href = "conjunto_categorias.php";
                                }
                        });
                    }
                    
                }
        }


        function editarCategoria($id_categoria, $accion){
            var parametros = {
              "id_categoria" : $id_categoria,
              "accion" : $accion
            }
            $.ajax({
              data:  parametros,
              url:   'editar_categoria.php',
              type:  'post',
              success:  function () {
                  alert('Categoría procesada con éxito!');
                  window.location.href = "conjunto_categorias.php";
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

                <?php 
                    if(count($categorias) > 0 ){
                    
                    ?>
                        <header class="main">
                            <h4>Categorías creadas:</h4>
                        </header>                
                        <div class="features">

                            <?php
                                $i = 0;
                                // foreach ($categorias as $categoria) {
                                    for ($j=1; $j < count($categorias); $j++) { 
                            ?>
                                <article>
                                    <span class="<?= $icons[$i]?>"></span>
                                    <div class="content">
                                        <h4><a id= "<?=$categoria['id_categoria']?>"><?=$categorias[$j]['nombre_categoria']?></a></h4>
                                        <button class="small" onclick="editarCategoria(<?=$categorias[$j]['id_categoria'] . ", 1"?>)">Activar categoría</button>
                                        <button class="small"  onclick="editarCategoria(<?=$categorias[$j]['id_categoria']  . ", 0"?>)">Desactivar categoría</button>     
                                    </div>
                                </article>
                            <?php
                                $i++;
                            }
                            ?>

                        </div>
                    <hr class="major" />
                        
                    <?php                    
                    }
                    ?>

                    <div class="features">
                        <article>
                            <span class="icon fa fa-plus small"></span>
                            <div class="content">
                                <h4><a data-toggle="modal" data-target="#myModal">Crear categoría</a></h4>
                            </div>
                        </article>
                    </div>
                </section>
			</div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="myModal" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <a type="button" class="close" data-dismiss="modal">&times;</a>
                        <h4 class="modal-title" id="gridSystemModalLabel">Crear una nueva categoría</h4>
                    </div>
                    <div class="modal-body">
                        <form enctype='multipart/form-data' method='GET' action='submitFormTo.php' id="formCategory">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label" >Nombre de la categoría:</label>
                                <input type="text" class="form-control" name="nameCategory" id="nombreCategoria" required>
                            </div>
                            <div class="form-group">
                                <div style="width:100%; height:15em;  border:solid 0.5px #FAFAFA;   overflow:auto;">
                                    <ul class="alt">
                                        <?php 
                                            foreach($videos as $video){ 
                                        ?>
                                        <li>
                                        <input type="checkbox" id="<?=$video[0]?>" name="<?=$video[0]?>">
                                        <label style="width:100%" for="<?=$video[0]?>"><?=$video[1]?></label>
                                        </li>	
                                        
                                        <?php
                                        }
                                        ?>						
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button onclick="guardarCategoria()" type="button" class="btn btn-default">Aceptar</button>
                        </div>
                        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
                </div>
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
						<li><a href="inicio.php">Home</a></li>
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