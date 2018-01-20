<?php
require_once("src/App.php");
require_once("src/logic/Videos.php");

$rol = isAdmin(); //Return session admin or null
$videosBBDD = new Videos();
$videos = array();
$videos = $videosBBDD->getAllVideos();

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
    <script src="resources/assets/js/admin.js" ></script>
    <title>Subir información adicional</title>
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
                                    <h4><a data-toggle="modal" data-target="#myModal2">Subir información</a></h4>
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
                            <h4 class="modal-title" id="gridSystemModalLabel">Subir información</h4>
                        </div>
                        <div class="modal-body">
                            <form enctype='multipart/form-data' method='GET' action='submitFormTo.php' id="formCategory">
                                <div class="form-group">
                                    <label for="elegir">Selecciona un vídeo:</label>
                                    <label  style="float:right;" onclick="ayudaInformacion()"><i class="fa fa-info-circle" aria-hidden="true"></i> Ayuda</label>
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
                                    <br><br>
                                    <input id="videoUploadFile" name="videoUploadFile" type="file" accept=".txt, .jpg, .pdf, .zip, .png" required/>
                                </div>
                                
                                
                            </form>
                        </div>
                            <div class="modal-footer">
                                <button type="button" class="button small" data-dismiss="modal">Cancelar</button>
                                <button onclick="subirInformacion()" type="button" class="button small special">Subir</button>
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