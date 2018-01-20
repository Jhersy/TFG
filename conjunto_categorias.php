<?php
require_once("src/logic/Categorias.php");
require_once("src/App.php");
require_once("src/logic/Videos.php");

$rol = isAdmin(); //Return session admin or null

if(!is_null($rol)){

/* Se recogen las categorías creadas en la base de datos*/
$categories = new Categorias();
$categorias = array();
$categorias =  $categories->getCategories("0");

$videosBBDD = new Videos();
$videos = array();
$videos = $videosBBDD->getAllVideos();


$icons = array('icon fa fa-users small', 'icon fa fa-language small', 
            'icon fa fa-comments small', 'icon fa-pencil-square-o small', 
            'icon fa fa-users small', 'icon fa fa-language small', 
            'icon fa fa-comments small', 'icon fa-pencil-square-o small');

?>
<!DOCTYPE HTML>

<html>

<head>
	<title>Crear Categoría</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="icon" href="https://secure.gravatar.com/blavatar/3455840a986cc52bce4a312622afb6b5?s=32" type="image/x-icon">
	<link rel="stylesheet" href="resources/assets/css/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="resources/assets/js/loading.js" ></script>
    <script src="resources/assets/js/admin.js" ></script>
</head>

<body>
	<!-- Wrapper -->
	<div id="wrapper">
		<!-- Main -->
		<div id="main">
			<div class="inner">
				<!-- Cabecera -->
				<?php require('includes/cabecera.php'); ?>
				<!-- 		-->
				<!-- Contenido -->
				<section>

                <?php 
                    if(count($categorias) > 0 ){
                    
                    ?>
                        <header class="main">
                            <h4>Categorías creadas:</h4>
                        </header>                
                        <div class="features">

                            <?php
                                for ($j=0; $j < count($categorias); $j++) { 
                            ?>
                                <article>
                                    <span class="<?= $icons[$j]?>"></span>
                                    <div class="content">
                                        <h4><a id="<?=$categorias[$j]['id_categoria']?>" href="list_videos.php?categoria=<?=$categorias[$j]['id_categoria']?>"><?=$categorias[$j]['nombre_categoria']?></a></h4>
                                        <button class="button special small" onclick="editarCategoria(<?=$categorias[$j]['id_categoria'] . ", 1"?>)">Activar categoría</button>
                                        <button class="button small"  onclick="editarCategoria(<?=$categorias[$j]['id_categoria']  . ", 0"?>)">Desactivar categoría</button>     
                                    </div>
                                </article>
                            <?php
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
                                <h4><a data-toggle="modal" data-target="#myModal2">Crear categoría</a></h4>
                            </div>
                        </article>
                    </div>
                </section>
			</div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="myModal2" aria-labelledby="gridSystemModalLabel">
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
                                <label  style="float:right;" onclick="ayudaCategoria()"><i class="fa fa-info-circle" aria-hidden="true"></i> Ayuda</label>
                                <input type="text" class="form-control" name="nameCategory" id="nombreCategoria" required>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Selecciona los vídeos que formarán la categoría:</label>
                                <div style="width:100%; height:15em;  border:solid 0.5px #FAFAFA;   overflow:auto;">
                                    <ul class="alt">
                                        <?php 
                                            foreach($videos as $video){ 
                                        ?>
                                        <li>
                                        <input type="checkbox" id="<?=$video['id_video']?>" name="<?=$video['id_video']?>">
                                        <label style="width:100%" for="<?=$video['id_video']?>"><?=$video['titulo']?></label>
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
                            <button type="button" class="button small" data-dismiss="modal">Cancelar</button>
                            <button onclick="guardarCategoria()" type="button" class="button  small special">Aceptar</button>
                        </div>
                        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
                </div>
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