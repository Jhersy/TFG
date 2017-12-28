<?php

require_once("src/App.php");
require_once("scraping.php");
require_once("src/logic/Subtitulos.php");
require_once("src/logic/Categorias.php");
$rol = isAdmin(); //Return session admin or null

$videoId = $_GET['id_video'];

$categoria = "";

$catBBDD = false;
$busqueda = false;
$miga = "";
$segundos = 0;
if(count($_GET) == 2){
    if(!is_null($_GET['categoria'])){
        $categoria = $_GET['categoria'];
    }
    $categoria = explode( "|", $categoria);

    if(count($categoria) > 1){
        $catBBDD = true;
        $categoriasBBDD = new Categorias();
        $IdsVideos = $categoriasBBDD->getVideosOfCategory($categoria[0]);	
        $miga = "<a href='list_videos.php?categoria=" . implode("|" , $categoria ) . "' >"  . $categoria[1] . " </a>";
        
    } else{
        $miga = "<a href='list_videos.php?categoria=" .  $categoria[0] . "' >"  . getNameCategory($categoria[0]) . " </a>";
        $IdsVideos = getIDsVideos($categoria[0]);
    }

}else if(count($_GET)> 2){
    $busqueda = true;
    if(!empty( $_GET['segundos'])){
        $segundos =  $_GET['segundos'];
    }
    
    if(!empty( $_GET['query'])){
        $query = $_GET['query'];
        $miga = "<a href='buscador.php?query=" . $query . "' > Resultado de búsqueda: \"" . $query . "\"</a>";
    }
}

// list($videoId, $categoria) =  explode( ",", $_POST["datos_video"]);

$sesion = $_SESSION['sesion'];

  require_once __DIR__ . '/vendor/autoload.php';

  $OAUTH2_CLIENT_ID = '88517581272-gu071qtdg26cg9oqbu8v3pmifgg6jogv.apps.googleusercontent.com';
  $OAUTH2_CLIENT_SECRET = '4xobKsbsIv2nFo7XOhcadA6V';
  
 
  $client = new Google_Client();
  $client->setClientId($OAUTH2_CLIENT_ID);
  $client->setClientSecret($OAUTH2_CLIENT_SECRET);
  
 
  $client->setScopes('https://www.googleapis.com/auth/youtube.force-ssl');
  $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
      FILTER_SANITIZE_URL);
  $client->setRedirectUri($redirect);
  
  // Define an object that will be used to make all API requests.
  $youtube = new Google_Service_YouTube($client);
  
    if (isset($_SESSION['sesion'])) {
	    $client->setAccessToken($_SESSION['sesion']);
    }
  
  if ($client->getAccessToken()) {
      //$videoId = "wisbrPN9fbI";
  
      $listResponse = $youtube->videos->listVideos("snippet, statistics, player",array('id' => $videoId));
      
      $video = $listResponse[0];
      $videoSnippet = $video['snippet'];
      $videoStatistics = $video['statistics'];
      $videoPlayer = $video['player'];

      // COMENTARIOS DE UN VÍDEO
      $videoCommentThreads = $youtube->commentThreads->listCommentThreads('snippet, replies', array(
        'videoId' => $videoId,
        'textFormat' => 'plainText',
        ));

    /* CARRUSEL DE VIDEOS DE LA MISMA CATEGORÍA*/
    if(!$busqueda){
        $videos = array();
        foreach ($IdsVideos as $videoBusqueda) {        
            $carrusel = $youtube->videos->listVideos("snippet",
            array('id' => $catBBDD ? $videoBusqueda['id_video'] : $videoBusqueda));
            array_push($videos, $carrusel[0]);
        }
    }

  }else{
      $state = mt_rand();
      $client->setState($state);
      $_SESSION['state'] = $state;
  
      $authUrl = $client->createAuthUrl();
      redirect($authUrl);  
  }

?>



<!DOCTYPE HTML>
<html>

<head>
    <title>Elements - Editorial by HTML5 UP</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <!--[if lte IE 8]><script src="resources/assets/js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="resources/assets/css/main.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- ESTILO PERSONALIZADO -->
	<link rel="stylesheet" href="resources/assets/css/style.css" />
	<!-- #################### -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--[if lte IE 9]><link rel="stylesheet" href="resources/assets/css/ie9.css" /><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" href="resources/assets/css/ie8.css" /><![endif]-->
    <script>
        function download(id_video){
            document.myform.id_video.value = id_video;
            return true;
        }

        $(document).ready(function() {
            $('#Carousel').carousel({
                interval: 100000
            })
            $('[data-toggle="tooltip"]').tooltip();   
        });

        function insertComment(id_video, param){
            var parametros = {
                "id_video" : id_video,
                "textComment" : $('#textarea').val()
            };
            $.ajax({
                    data:  parametros,
                    url:   'comentarios.php',
                    type:  'post',
                    success:  function () {
                        window.location.href = "video_player.php?id_video=" + id_video + param;
                    }
            });
        }

        function cancelComment(){
            $('#textarea').val("");
        }
    </script>
</head>

<style type="text/css">
    .video-responsive {
        position: relative;
        padding-bottom: 56.25%;
        /* 16/9 ratio */
        padding-top: 30px;
        /* IE6 workaround*/
        height: 0;
        overflow: hidden;
    }

    .video-responsive iframe,
    .video-responsive object,
    .video-responsive embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .carousel {
        margin-bottom: 0;
        padding: 0 40px 30px 40px;
    }
    /* The controlsy */
    .carousel-control {
        left: -12px;
        height: 40px;
        width: 40px;
        background: none repeat scroll 0 0 #222222;
        border: 4px solid #FFFFFF;
        border-radius: 23px 23px 23px 23px;
        margin-top: 90px;
    }
    .carousel-control.right {
        right: -12px;
    }
    /* The indicators */
    .carousel-indicators {
        right: 50%;
        top: auto;
        bottom: -10px;
        margin-right: -19px;
    }
    /* The colour of the indicators */
    .carousel-indicators li {
        background: #cecece;
    }
    .carousel-indicators .active {
    background: #428bca;
    }
  
  </style>
<body >

    <!-- Wrapper -->
    <div id="wrapper">

        <!-- Main -->
        <div id="main">
            <div class="inner">

            <!-- Header -->
            <?php require('includes/cabecera.php'); ?>
            <!-- 		-->
            <div style="padding: 30px 0px 0px 0px">
                <div class="row uniform">
                    <div class="8u 12u$(small)" >
                        <h3><?=$miga?></h3>
                    </div>			

                    <!-- Buscador -->
                    <?php require('includes/buscador.php'); ?>
                    <!-- 		  -->                

                </div>
            </div>
                <div class="reproductor col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                        <?php 
                        $segundoExacto = '"';
                        if(!empty($segundos))
                            $segundoExacto = "?start=" . $segundos . '"';        
                        ?>
                    <div class="video-responsive">
                        <iframe <?php echo substr(explode(" ", $videoPlayer['embedHtml'])[3], 0, -1) . $segundoExacto;?> frameborder="0" allowfullscreen="allowfullscreen"></iframe>
                    </div>
                </div>

                <div class="col-md-12">

                    <h4><?=$videoSnippet['title']?>

                    </h4>
                    <ul class="icons">
                        <li>
                            <i class="fa fa-eye" aria-hidden="true"> <?=$videoStatistics['viewCount']?></i>
                        </li>
                        <li>
                            <i class="fa fa-thumbs-o-up" aria-hidden="true"> <?=$videoStatistics['likeCount'] ?></i>
                        </li>
                    </ul>
                    <?php
                        $subtitulos = new Subtitulos();
                        if($subtitulos->existCaption($videoId)){ 
                            $idiomas =  $subtitulos->getLanguageCaption($videoId);                               
                    ?>                        
                    <p><strong>Descargar subtítulo: </strong></p>
                    <form name="myform" method="post" action="download_subtitulo.php" onsubmit="download('<?=$videoId?>')">
                        <div class="row uniform">
                            <div class="3u 12u$(small)">
                                <div class="select-wrapper">
                                    <select id="select_idioma" name="idioma" style="height: 32px;">
                                        <option value="<?=$idiomas[0]['idioma']?>">- Selecciona un idioma -</option>
                                        <?php 
                                        foreach($idiomas as $idioma){?>
                                            <option value="<?=$idioma['idioma']?>"><?=$idioma['idioma']?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>                                           
                                </div>
                            </div>
                            <div class="9u 12u$(small)">
                                <input type="hidden" name="id_video" value="" />
                                <input class="button small icon fa-download" type="submit" name="submit" value="Descargar" />
                            </div>
                        </div>                        
                    </form>
                    <?php } ?>
                    <p><?=$videoSnippet['description']?></p>

                    <p><strong>Publicado el: </strong><?=date("d-m-Y", strtotime(substr($videoSnippet['publishedAt'], 0,10)));?></p>

                    <?php
                    if(!is_null($videoSnippet['tags'])){
                        foreach($videoSnippet['tags'] as $tag){ ?>
                            <span class="label label-danger"><?=$tag?></span>
                       <?php }
                    }
                    ?>
                    <hr class="major" />


                    <!-- CARRUSEL DE VIDEOS SUGERIDOS -->
                    <!-- Solo se mostrará el carrusel cuando se esté visualizando vídeos de una categoría, no para las búsquedas -->
                    <?php    if(!$busqueda){ ?>
                    <div class="col-md-12">
                        <h4>Vídeos relacionados con la categoría: </h4>
                    <div id="Carousel" class="carousel slide">                     

                    <?php 
                        $nextItem = 0;
                        $aux = 0;
                        $items = count($videos) / 4;
                        $final = count($videos);
                    ?>
                    <ol class="carousel-indicators">
                        <li data-target="#Carousel" data-slide-to="0" class="active"></li>
                        <?php
                        for ($i=1; $i < $items; $i++) { ?>
                            <li data-target="#Carousel" data-slide-to="<?=$i?>"></li>
                        <?php
                        }
                        ?>
                    </ol>

                     
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        
                    <div class="item active">
                      <div class="row">
                        <?php
                        if($final < 4){
                            $aux = $final;
                        }else{
                            $aux = 4;
                            $final -= 4; 
                        }
                        for ($i=0; $i < $aux; $i++) {  ?>
                            <div class="col-md-3" style="height: 12em;" >
                                    <a data-toggle="tooltip" title="<?=$videos[$i]['snippet']['title']?>" data-placement="bottom" href="video_player.php?id_video=<?php echo $videos[$i]['id'] . "&categoria=" . $_GET["categoria"] ?>" class="thumbnail">
                                    <img src="<?=$videos[$i]['snippet']['thumbnails']['default']['url']?>" alt="Image" style="max-width:100%;">
                                    </a>
                            </div>                          
                        <?php
                        }
                        $nextItem += $aux;
                        ?>
                      </div><!--.row-->
                    </div><!--.item-->
                    <?php
                    if($items > 1){
                        for($j=1; $j < $items; $j++){ ?>
                            <div class="item">
                            <div class="row"> 
                            <?php
                            if($final < 4){
                                $aux = $final;
                            }else{
                                $aux = 4;
                                $final -= 4; 
                            }
                            for ($i=0; $i < $aux; $i++) { ?>
                                <div class="col-md-3" style="height: 12em;">
                                    <a data-toggle="tooltip"  title="<?=$videos[$nextItem + $i]['snippet']['title']?>" data-placement="bottom" href="video_player.php?id_video=<?php echo $videos[$nextItem + $i]['id'] . "&categoria=" . $_GET["categoria"] ?>" class="thumbnail">
                                    <img src="<?=$videos[$nextItem + $i]['snippet']['thumbnails']['default']['url']?>" alt="Image" style="max-width:100%;">
                                    </a>
                                </div>

                            <?php
                            }
                            $nextItem += $aux;

                            ?>
                      </div><!--.row-->
                    </div><!--.item-->

                    <?php
                        }
                    }
                    ?>
 
                </div><!--.carousel-inner-->
                <a data-slide="prev" href="#Carousel" class="left carousel-control">‹</a>
                <a data-slide="next" href="#Carousel" class="right carousel-control">›</a>
                </div><!--.Carousel-->
                
                </div>


                <hr class="major" />

                <?php } ?>




                    <h4><strong> <?=$videoCommentThreads['pageInfo']['totalResults']?> Comentarios</strong></h4>

                    <div class="12u 12u$(small)" style="padding-bottom: 1em;">
                        <textarea id="textarea"  placeholder="Inserta un nuevo comentario" style=" margin-bottom: 10px; height: 50px; resize:vertical;"></textarea>
                        <ul class="icons">
                            <?php
                                $parametros = "";
                                if($busqueda){
                                    $parametros = "&query=" . $query  . "&segundos=" . $segundos;
                                }else{
                                    if($catBBDD){
                                        $parametros = "&categoria=" . implode("|" , $categoria);
                                    }else{
                                        $parametros = "&categoria=" . $categoria[0];
                                    }                                  
                                }
                            ?>
                            <li style="float:right; padding: 0 0 0 0.5em;"><a onclick="insertComment(<?php echo "'" . $videoId . "','" . $parametros . "'"; ?>)" class="button special small">Comentar</a></li>
                            <li style="float:right; padding: 0 0 0 0;"><a id="cancelComment" onclick="cancelComment()"  class="button small">Cancelar</a></li>                           
                        </ul>
                    </div>
                    <br>
                    <br>
                    <dl>
                    <?php 
                    
                    foreach ($videoCommentThreads as $comment) { ?>
                        <dt><img class="img-circle" src="<?=$comment['snippet']['topLevelComment']['snippet']['authorProfileImageUrl']?>" alt="foto perfil usuario comentario"> <?=$comment['snippet']['topLevelComment']['snippet']['authorDisplayName']?></dt>
                        <dd>
                            <p><?=$comment['snippet']['topLevelComment']['snippet']['textDisplay']?></p>
                        </dd>           

                    <?php
                      }
                    ?>
                    
                    </dl>
                <hr class="major" />
                    
                </div>

            </div>
        </div>

    </div>

    <!-- Scripts -->
    <!-- <script src="resources/assets/js/jquery.min.js"></script>
    <script src="resources/assets/js/skel.min.js"></script>
    <script src="resources/assets/js/util.js"></script>
    <!--[if lte IE 8]><script src="resources/assets/js/ie/respond.min.js"></script><![endif]-->
    <!-- <script src="resources/assets/js/main.js"></script> -->

</body>

</html>