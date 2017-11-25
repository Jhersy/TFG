<?php
require_once("src/App.php");
require_once("scraping.php");

$rol = isAdmin(); //Return session admin or null
//Scraping
$videos = array();
$videos = getAllIDsVideos();

if(!is_null($rol)){


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="resources/assets/css/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Subir subtítulo</title>
    <script>
    function resetMeIfChecked(radio){           
        if(radio.checked && radio.value == window.lastrv){
            $(radio).removeAttr('checked');
            window.lastrv = 0;
        }
        else
            window.lastrv = radio.value;
    }

    function verInformacion(){
        alert("La estructura de cada subtítulo es la siguiente:\n\nNúmero de subtítulo (En orden secuencial empezando en 1 para el primer subtítulo)\nTiempo inicial --> Tiempo final (En formato horas:minutos:segundos,milisegundos)\nTexto del subtítulo (Puede incluir una o varias líneas separadas por un salto de línea)\nLínea en blanco (Suele emplearse CRLF como salto de línea)\n\n Ejemplo archivo:\n1\n00:00:00,394 --> 00:00:03,031\n<i>Anteriormente en <font color='#FE00FE'>“Sons of Anarchy”</font></i>");
    }

    function subirSubtitulo(){
        if($("input:radio:checked").length != 1 || $("#videoUploadFile")[0].files.length == 0 ){
            alert('Selecciona un vídeo y adjunta un archivo .srt');
        }else{
            var $id = "";
            var archivo = $("#videoUploadFile").prop('files')[0];
            var form_data = new FormData(); 
            form_data.append('file', archivo);
            $("input:radio:checked").each(function(){    
                  $id = $(this).attr("id");            
            });
            $.ajax({
                data:  form_data, 
                contentType: false,
                processData: false,
                url:   'upload_caption.php?id=' + $id,
                type:  'post',
                success:  function (data) {
                     window.alert(data);
                     window.location.href = "subir_subtitulos.php";
                    // var newWindow = window.open("", "new window", "width=800, height=800");
                    // newWindow.document.write(data);
                }
            });
        }
    }
    </script>
</head>
<body>
    
<div id="wrapper">

		<!-- Main -->
		<div id="main">
			<div class="inner">

				<header id="header" style="padding-top:2em;">
					<a href="administracion.html" class="logo"><strong>Zaragoza Lingüística - Subir un subtítulo</strong></a>
					<ul class="icons">
					<?php
                        if (!is_null($rol)) {
							echo '<li>Bienvenido, '. getName() . '&nbsp;</li>';
                            echo '<li><a href="administracion.php">Administrar &nbsp;</a></li>';
                            echo '<li><a id="enlace-logout" href="login.php">Salir</a></li>';                        }
					?>
					</ul>
				</header>
				<!-- Content -->
				<section>

                    <div class="features">
                        <article>
                            <span class="icon fa fa-plus small"></span>
                            <div class="content">
                                <h4><a data-toggle="modal" data-target="#myModal">Subir subtítulo</a></h4>
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
                        <h4 class="modal-title" id="gridSystemModalLabel">Subir un subtítulo</h4>
                    </div>
                    <div class="modal-body">
                        <form enctype='multipart/form-data' method='GET' action='submitFormTo.php' id="formCategory">
                            <div class="form-group">
                                <label for="elegir">Selecciona un vídeo:</label>
                                <br>
                                <div style="width:100%; height:22em;  border:solid 0.5px #FAFAFA;   overflow:auto;">
                                    <ul class="alt">
                                        <?php 
                                            foreach($videos as $video){ 
                                        ?>
                                        <li>
                                            <input type="radio" id="<?=$video[0]?>" name="<?=$video[0]?>" onclick="resetMeIfChecked(this)">
                                            <label for="<?=$video[0]?>"><?=$video[1]?></label>                                    
                                        </li>	                                        
                                        <?php
                                        }
                                        ?>						
                                    </ul>
                                </div>
                                <br>
                                <input id="videoUploadFile" name="videoUploadFile" type="file" accept=".srt" required/>
                            </div>
                        </form>
                        <a onclick="verInformacion()">Ver formato del archivo del subtítulo (.srt)</a>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button onclick="subirSubtitulo()" type="button" class="btn btn-default">Subir</button>
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