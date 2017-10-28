
<?php

include "videos.php";

$logic = new Videos();

$arrayIds = array('wisbrPN9fbI', 'lQmDWuJCY7U');

/*
$video1 = $logic->getDetailsVideo($arrayIds[0]);
$video2 = $logic->getDetailsVideo($arrayIds[1]);

echo $video1['snippet']['title'];
echo $video2['snippet']['title'];
*/

//titulo (snippet-title), thumbnail (snippet-thumbnails-default-url), hd (contentDetails-definition), subtitulos (contentDetails-caption), visualizaciones (statistics - viewCount), likes (statistics - likeCount), duracion (ContentDetails - duration) 
 
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
						<li>
							<a href="#" class="icon fa-youtube">
								<span class="label">Youtube</span>
							</a>
						</li>
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
									<th>Imagen</th>
									<th>Título</th>
								</tr>
							</thead>
							<tbody>
                                <?php

                                    for( $i = 0; $i < count($arrayIds); $i++) { 
                                            $video = $logic->getDetailsVideo($arrayIds[$i]);
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
													<i class="fa fa-clock-o" aria-hidden="true"> <?= $video['contentDetails']['duration']?></i>
												</li>
											</ul>
										</p>
									</td>
								</tr>
								<tr></tr>
                                    <?php
                                    }
                                
                                ?>
<!--
								<tr>
									<td rowspan="2">
										<br>
										<a href="#" class="image">
											<img src="resources/images/test.jpg" alt="" />
										</a>
									</td>
									<td colspan="3">Cuando los gestos hablan (Núria Esteve)
										<p>
											<br>
											<a class="button small">HD</a>
											<a class="button small">Subtítulos</a>
											<ul class="icons">
													<li>
														<i class="fa fa-eye" aria-hidden="true">123</i>
													</li>
													<li>
														<i class="fa fa-thumbs-o-up" aria-hidden="true">12344</i>
													</li>
													<li>
														<i class="fa fa-clock-o" aria-hidden="true">1H 23m 3s</i>
													</li>
												</ul>
										</p>
									</td>
								</tr>
								<tr>
								</tr>
								<tr>
									<td rowspan="2">
										<br>
										<a href="#" class="image">
											<img src="resources/images/test.jpg" alt="" />
										</a>
									</td>
									<td colspan="3"> <a href="player.html">Música, lenguaje y cognición</a>  
										<p>
											<br>
											<a class="button small">HD</a>
											<a class="button disabled small">Subtítulos</a>
											<ul class="icons">
													<li>
														<i class="fa fa-eye" aria-hidden="true">123</i>
													</li>
													<li>
														<i class="fa fa-thumbs-o-up" aria-hidden="true">12344</i>
													</li>
													<li>
														<i class="fa fa-clock-o" aria-hidden="true">1H 23m 3s</i>
													</li>
												</ul>
										</p>
									</td>
								</tr>
                                <tr></tr>
                            !-->
							</tbody>
						</table>
					</div>




					<div class="posts">
						<article>
							<a href="#" class="image">
								<img src="resources/images/pic01.jpg" alt="" />
							</a>
							<h3>Interdum aenean</h3>
							<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla
								amet lorem feugiat tempus aliquam.</p>
							<ul class="actions">
								<li>
									<a href="#" class="button">More</a>
								</li>
							</ul>
						</article>
						<article>
							<a href="#" class="image">
								<img src="resources/images/pic02.jpg" alt="" />
							</a>
							<h3>Nulla amet dolore</h3>
							<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla
								amet lorem feugiat tempus aliquam.</p>
							<ul class="actions">
								<li>
									<a href="#" class="button">More</a>
								</li>
							</ul>
						</article>
						<article>
							<a href="#" class="image">
								<img src="resources/images/pic03.jpg" alt="" />
							</a>
							<h3>Tempus ullamcorper</h3>
							<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla
								amet lorem feugiat tempus aliquam.</p>
							<ul class="actions">
								<li>
									<a href="#" class="button">More</a>
								</li>
							</ul>
						</article>
						<article>
							<a href="#" class="image">
								<img src="resources/images/pic04.jpg" alt="" />
							</a>
							<h3>Sed etiam facilis</h3>
							<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla
								amet lorem feugiat tempus aliquam.</p>
							<ul class="actions">
								<li>
									<a href="#" class="button">More</a>
								</li>
							</ul>
						</article>
						<article>
							<a href="#" class="image">
								<img src="resources/images/pic05.jpg" alt="" />
							</a>
							<h3>Feugiat lorem aenean</h3>
							<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla
								amet lorem feugiat tempus aliquam.</p>
							<ul class="actions">
								<li>
									<a href="#" class="button">More</a>
								</li>
							</ul>
						</article>
						<article>
							<a href="#" class="image">
								<img src="resources/images/pic06.jpg" alt="" />
							</a>
							<h3>Amet varius aliquam</h3>
							<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla
								amet lorem feugiat tempus aliquam.</p>
							<ul class="actions">
								<li>
									<a href="#" class="button">More</a>
								</li>
							</ul>
						</article>
					</div>
				</section>

				<ul class="pagination">
					<li>
						<span class="button disabled">Prev</span>
					</li>
					<li>
						<a href="#" class="page active">1</a>
					</li>
					<li>
						<a href="#" class="page">2</a>
					</li>
					<li>
						<a href="#" class="page">3</a>
					</li>
					<li>
						<span>…</span>
					</li>
					<li>
						<a href="#" class="page">8</a>
					</li>
					<li>
						<a href="#" class="page">9</a>
					</li>
					<li>
						<a href="#" class="page">10</a>
					</li>
					<li>
						<a href="#" class="button">Next</a>
					</li>
				</ul>

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