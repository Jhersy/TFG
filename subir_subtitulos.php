<?php
require_once("src/App.php");
require_once("src/logic/Subtitulos.php");
require_once("src/logic/Videos.php");

$rol = isAdmin(); //Return session admin or null
try {
    $videosBBDD = new Videos();
    $videos = array();
    $videos = $videosBBDD->getAllVideos();
} catch (Exception $e) {
    redirect("subir_subtitulos.php");
}

if(!is_null($rol)){


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="https://secure.gravatar.com/blavatar/3455840a986cc52bce4a312622afb6b5?s=32" type="image/x-icon">
    <link rel="stylesheet" href="resources/assets/css/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="resources/assets/js/loading.js" ></script>
    <title>Subir subtítulo</title>
    <script>

    function verInformacion(){
        alert("La estructura de cada subtítulo es la siguiente:\n\nNúmero de subtítulo (En orden secuencial empezando en 1 para el primer subtítulo)\nTiempo inicial --> Tiempo final (En formato horas:minutos:segundos,milisegundos)\nTexto del subtítulo (Puede incluir una o varias líneas separadas por un salto de línea)\nLínea en blanco (Suele emplearse CRLF como salto de línea)\n\n Ejemplo archivo:\n1\n00:00:00,394 --> 00:00:03,031\n<i>Anteriormente en <font color='#FE00FE'>“Sons of Anarchy”</font></i>");
    }

    function subirSubtitulo(){
        if($("input:checkbox:checked").length != 1 || $("#videoUploadFile")[0].files.length == 0 || $( "#select_idioma option:selected" ).val() == "" ){
            alert('Selecciona un vídeo, un idioma y adjunta un archivo .srt');
        }else{
            var id = "";
            var title = "";
            var idioma = $( "#select_idioma option:selected" ).val();
            var archivo = $("#videoUploadFile").prop('files')[0];
            var form_data = new FormData(); 
            form_data.append('file', archivo);
            $("input:checkbox:checked").each(function(){    
                  id = $(this).attr("id");         
                  title = $(this).next().text();   
            });
            $.ajax({
                data:  form_data, 
                contentType: false,
                processData: false,
                url:   'upload_caption.php?id=' + id + '&title=' + title + "&idioma=" + idioma,
                type:  'post',
                success:  function (data) {
                    $('#myModal').hide();
                     window.alert(data);
                     window.location.href = "subir_subtitulos.php";
                }
            });
        }
    }


    function deleteSubtitulo(){

        if($("input:checkbox:checked").length < 0){
            alert('No has seleccionado ningún subtítulo');
        }else{
            var subtitulos = "";
            var idiomas = "";
            $("input:checkbox:checked").each(function(){    
                subtitulos += $(this).attr("id") + ',';     
            });

            var parametros = { 
                "subtitulos" : subtitulos
            }

            $.ajax({
                data:  parametros,
                url:   'upload_caption.php',
                type:  'post',
                success:  function (data) {
                    window.alert(data);
                    window.location.href = "subir_subtitulos.php";
                }
            });
        }
    }
    function ayuda(){
            alert('Seleccione un único vídeo, el lenguaje, y adjunte un subtítulo (archivo con extensión .srt)');
        }
    </script>
</head>
<body>
    
<div id="wrapper">

		<!-- Main -->
		<div id="main">
			<div class="inner">

				<!-- Header -->
				<?php require('includes/cabecera.php'); ?>
				<!-- 		-->
				<!-- Content -->
				<section>

                    <div class="features">
                        <article>
                            <span class="icon fa fa-plus small"></span>
                            <div class="content">
                                <h4><a data-toggle="modal" data-target="#myModal2">Subir subtítulo</a></h4>
                            </div>
                        </article>
                        <article>
                            <span class="icon fa fa-minus small"></span>
                            <div class="content">
                                <h4><a data-toggle="modal" data-target="#myModal3">Eliminar subtítulo</a></h4>
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
                        <h4 class="modal-title" id="gridSystemModalLabel">Subir un subtítulo</h4>
                    </div>
                    <div class="modal-body">
                        <form enctype='multipart/form-data' method='GET' action='submitFormTo.php' id="formCategory">
                            <div class="form-group">
                                <label for="elegir">Selecciona un vídeo:</label>
                                <label  style="float:right;" onclick="ayuda()"><i class="fa fa-info-circle" aria-hidden="true"></i> Ayuda</label>
                                <br>
                                <div style="width:100%; height:22em;  border:solid 0.5px #FAFAFA;   overflow:auto;">
                                    <ul class="alt">
                                        <?php 
                                            foreach($videos as $video){ 
                                        ?>
                                        <li>
                                            <input type="checkbox" id="<?=$video['id_video']?>" name="<?=$video['id_video']?>" >
                                            <label style="width:100%" for="<?=$video['id_video']?>"><?=$video['titulo']?></label>                                    
                                        </li>	                                        
                                        <?php
                                        }
                                        ?>						
                                    </ul>
                                </div>
                                <br>
                                <div class="12u$">
                                    <div class="select-wrapper">
                                        <select id="select_idioma" name="idioma">
                                            <option value="">- Selecciona un idioma -</option>
                                            <option value="castellano">Castellano</option>
                                            <option value="catalan">Catalán</option>
                                            <option value="vasco">Vasco</option>
                                            <option value="gallego">Gallego</option>
                                            <option value="ingles">Inglés</option>
                                            <option value="frances">Francés</option>
                                            <option value="italiano">Italiano</option>
                                            <option value="portugues">Portugués</option>
                                            <option value="aleman">Alemán</option>
                                        </select>                                           
                                    </div>
                                </div>

                                <br>
                                <input id="videoUploadFile" name="videoUploadFile" type="file" accept=".srt" required/>

                            </div>
                        </form>
                        <a onclick="verInformacion()">Ver formato del archivo del subtítulo (.srt)</a>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="button small" data-dismiss="modal">Cancelar</button>
                            <button onclick="subirSubtitulo()" type="button" class="button special small">Subir subtítulo</button>
                        </div>
                        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
                </div>
            </div>
        </div>


        <!--  MODAL ELIMINAR SUBTITULO  -->
        <div class="modal fade" tabindex="-1" role="dialog" id="myModal3" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <a type="button" class="close" data-dismiss="modal">&times;</a>
                        <h4 class="modal-title" id="gridSystemModalLabel">Eliminar subtítulo</h4>
                    </div>
                    <div class="modal-body">
                        <div style="width:100%; height:22em;  border:solid 0.5px #FAFAFA;   overflow:auto;">
                            <ul class="alt">
                                <?php 
                                    /* LISTAMOS LOS SUBTÍTULOS DE LA BASE DE DATOS */
                                    $captions = new Subtitulos();
                                    $subtitulos = $captions->getAll();
                                    if( sizeof($subtitulos) == 0){
                                        echo 'No se han encontrado subtítulos en la base de datos';
                                    }else{
                                    foreach($subtitulos as $subtitulo){ 
                                ?>
                                <li>
                                    <input type="checkbox" id="<?= $subtitulo['id_subtitulo'] . '|' . $subtitulo['idioma']; ?>" name="<?= $subtitulo['id_subtitulo'] . '|' . $subtitulo['idioma']; ?>"  />
                                    <label style="width:100%" for="<?= $subtitulo['id_subtitulo'] . '|' . $subtitulo['idioma'];?>"> <?= $captions->getTitleCaption($subtitulo['id_subtitulo'])[0]['titulo'] . ' - ' . strtoupper($subtitulo['idioma']) ;?></label>                                    
                                </li>	                                        
                                <?php
                                    }
                                }
                                ?>						
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="button small" data-dismiss="modal">Cancelar</button>
                        <button type="submit" onclick="deleteSubtitulo()"  class="button special small"<span class="glyphicon glyphicon-off"></span> Eliminar subtítulo</button>
                    </div>
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
	<!--[if lte IE 8]><script src="resources/assets/js/ie/respond.min.js"></script><![endif]-->
	<script src="resources/assets/js/main.js"></script>




</body>
</html>



<?php
}else{
    redirect("index.php");
}


?>