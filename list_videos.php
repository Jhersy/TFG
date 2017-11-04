
<?php

require_once("src/App.php");
$rol = isAdmin(); //Return session admin or null


// Para obtener información vía API de un vídeo
include "videos.php";

$logic = new videosAPI();

/*
// Para obtener los identificadores de los vídeos
include "src/logic/Videos.php";

$categoria = $_GET["category"];

$model = new Videos();

$IdsVideos = $model->listVideos($categoria);
*/

require_once("scraping.php");
$categoria = $_GET["category"];
$IdsVideos = getIDsVideos($categoria);

?>


<!DOCTYPE HTML>
<html>

<head>
	<title>Filosofía y Linguistica</title>
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

				<!-- Header -->
				<header id="header">
					<a href="index.html" class="logo">
						<strong>Zaragoza Lingüística</strong>
					</a>
					<ul class="icons">
					<?php
						if (is_null($rol) ) {
							echo '<li><a class="button special small" data-toggle="modal" data-target="#myModal">Iniciar sesión</a></li>';
						}
						else {
							$name = getName();
							echo '<li>Bienvenido, '. $name . '&nbsp;</li>';
							echo '<li><a href="administracion.php">Administrar &nbsp;</a></li>';
							echo '<li><a id="enlace-logout" href="login.php">Salir</a></li>';
						}
					?>
					</ul>
				</header>

				<!-- Section -->
				<section>
					<header class="major">
						<h2>Lenguaje humano, comunicación y cognición</h2>
					</header>
					<div class="table-wrapper">
						<table>
							<thead>
								<tr>
									<th>Vídeo</th>
									<th>Título</th>
								</tr>
							</thead>
							<tbody>
                                <?php
                                    foreach($IdsVideos as $id_video) { 
                                            $video = $logic->getDetailsVideo($id_video['id_video']);
                                        ?>
                                <tr>
									<td rowspan="2">
										<br>
										<a href="#" class="image">
											<img src=" <?= $video['snippet']['thumbnails']['default']['url'] ?>" alt="" />
										</a>
									</td>
									<td colspan="3"> <?=$video['snippet']['title']?>
										<p>
											<br>
											<a class="button small"> <?= $video['contentDetails']['definition']?></a>
                                            <?php
                                                if($video['contentDetails']['caption'] == "false") ?>
                                                    <a class="button disabled small">Subtítulos</a>
                                                <?php
                                            ?>
                                            
											<ul class="icons">
												<li>
													<i class="fa fa-eye" aria-hidden="true"> <?= $video['statistics']['viewCount']?></i>
												</li>
												<li>
													<i class="fa fa-thumbs-o-up" aria-hidden="true"> <?= $video['statistics']['likeCount']?></i>
												</li>
												<li>
													<i class="fa fa-clock-o" aria-hidden="true"> <?= $logic->getDuration($video['contentDetails']['duration'])?></i>
												</li>
											</ul>
										</p>
									</td>
								</tr>
								<tr></tr>
                                    <?php
                                    }
                                ?>
							</tbody>
						</table>
					</div>
				</section>
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