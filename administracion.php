<?php
require_once("src/App.php");
$rol = isAdmin(); //Return session admin or null

if(!is_null($rol)){
?>
<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<head>
	<title>Administración</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<!--[if lte IE 8]><script src="resources/assets/js/ie/html5shiv.js"></script><![endif]-->
	<link rel="stylesheet" href="resources/assets/css/main.css" />
	<!--[if lte IE 9]><link rel="stylesheet" href="resources/assets/css/ie9.css" /><![endif]-->
	<!--[if lte IE 8]><link rel="stylesheet" href="resources/assets/css/ie8.css" /><![endif]-->
</head>

<body>

	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Main -->
		<div id="main">
			<div class="inner">

				<header id="header" style="padding-top:2em;">
					<a href="administracion.html" class="logo"><strong>Zaragoza Lingüística - Administración</strong></a>
					<ul class="icons">
					<?php
                        if (!is_null($rol) ) {
							echo '<li>Bienvenido, '. getName() . '&nbsp;</li>';
                            echo '<li><a href="administracion.html">Administrar &nbsp;</a></li>';
                            echo '<li><a id="enlace-logout" href="login.php">Salir</a></li>';                        }
					?>
					</ul>
				</header>
				<!-- Content -->
				<section>
					<div class="row">
						<div class="6u 12u$(small)">
							<h3>Subir vídeo</h3>
							<p>Para subir un vídeo necesitas: ..................................................................</p>
							<button>Subir</button>
						</div>

						<div class="6u$ 12u$(small)">
							<h3>Editar vídeo</h3>
							<p>In arcu accumsan arcu adipiscing accumsan orci ac. Felis id enim aliquet. Accumsan ac integer lobortis commodo ornare
								aliquet accumsan erat tempus amet porttitor. Ante commodo blandit adipiscing integer semper orci eget. Faucibus commodo
								adipiscing mi eu nullam accumsan morbi arcu ornare odio mi adipiscing nascetur lacus ac interdum morbi accumsan vis
								mi accumsan.</p>
						</div>
						<div class="6u 12u$(small)">
							<h3>Subir vídeo</h3>
							<p>Para subir un vídeo necesitas: ..................................................................</p>
							<button>Subir</button>
						</div>

						<div class="6u$ 12u$(small)">
							<h3>Editar vídeo</h3>
							<p>In arcu accumsan arcu adipiscing accumsan orci ac. Felis id enim aliquet. Accumsan ac integer lobortis commodo ornare
								aliquet accumsan erat tempus amet porttitor. Ante commodo blandit adipiscing integer semper orci eget. Faucibus commodo
								adipiscing mi eu nullam accumsan morbi arcu ornare odio mi adipiscing nascetur lacus ac interdum morbi accumsan vis
								mi accumsan.</p>
						</div>
					</div>


					<hr class="major" />

					<h2>Interdum sed dapibus</h2>
					<p>Donec eget ex magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet
						dolor mattis sagittis. Praesent rutrum sem diam, vitae egestas enim auctor sit amet. Pellentesque leo mauris, consectetur
						id ipsum sit amet, fergiat. Pellentesque in mi eu massa lacinia malesuada et a elit. Donec urna ex, lacinia in purus
						ac, pretium pulvinar mauris. Curabitur sapien risus, commodo eget turpis at, elementum convallis elit. Pellentesque
						enim turpis, hendrerit.</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis dapibus rutrum facilisis. Class aptent taciti sociosqu
						ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam tristique libero eu nibh porttitor fermentum.
						Nullam venenatis erat id vehicula viverra. Nunc ultrices eros ut ultricies condimentum. Mauris risus lacus, blandit
						sit amet venenatis non, bibendum vitae dolor. Nunc lorem mauris, fringilla in aliquam at, euismod in lectus. Pellentesque
						habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In non lorem sit amet elit placerat
						maximus. Pellentesque aliquam maximus risus, vel sed vehicula. Interdum et malesuada fames ac ante ipsum primis in
						faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis. Praesent rutrum sem diam, vitae egestas enim
						auctor sit amet. Pellentesque leo mauris, consectetur id ipsum sit amet, fersapien risus, commodo eget turpis at, elementum
						convallis elit. Pellentesque enim turpis, hendrerit tristique lorem ipsum dolor.</p>

					<hr class="major" />

					<h2>Magna etiam veroeros</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis dapibus rutrum facilisis. Class aptent taciti sociosqu
						ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam tristique libero eu nibh porttitor fermentum.
						Nullam venenatis erat id vehicula viverra. Nunc ultrices eros ut ultricies condimentum. Mauris risus lacus, blandit
						sit amet venenatis non, bibendum vitae dolor. Nunc lorem mauris, fringilla in aliquam at, euismod in lectus. Pellentesque
						habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In non lorem sit amet elit placerat
						maximus. Pellentesque aliquam maximus risus, vel sed vehicula.</p>
					<p>Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis.
						Praesent rutrum sem diam, vitae egestas enim auctor sit amet. Pellentesque leo mauris, consectetur id ipsum sit amet,
						fersapien risus, commodo eget turpis at, elementum convallis elit. Pellentesque enim turpis, hendrerit tristique lorem
						ipsum dolor.</p>

					<hr class="major" />

					<h2>Lorem aliquam bibendum</h2>
					<p>Donec eget ex magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet
						dolor mattis sagittis. Praesent rutrum sem diam, vitae egestas enim auctor sit amet. Pellentesque leo mauris, consectetur
						id ipsum sit amet, fergiat. Pellentesque in mi eu massa lacinia malesuada et a elit. Donec urna ex, lacinia in purus
						ac, pretium pulvinar mauris. Curabitur sapien risus, commodo eget turpis at, elementum convallis elit. Pellentesque
						enim turpis, hendrerit.</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis dapibus rutrum facilisis. Class aptent taciti sociosqu
						ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam tristique libero eu nibh porttitor fermentum.
						Nullam venenatis erat id vehicula viverra. Nunc ultrices eros ut ultricies condimentum. Mauris risus lacus, blandit
						sit amet venenatis non, bibendum vitae dolor. Nunc lorem mauris, fringilla in aliquam at, euismod in lectus. Pellentesque
						habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In non lorem sit amet elit placerat
						maximus. Pellentesque aliquam maximus risus, vel sed vehicula.</p>

				</section>

			</div>
		</div>

		<!-- Sidebar -->
		<div id="sidebar">
			<div class="inner">

				<!-- Search -->
				<section id="search" class="alt">
					<form method="post" action="#">
						<input type="text" name="query" id="query" placeholder="Search" />
					</form>
				</section>

				<!-- Menu -->
				<nav id="menu">
					<header class="major">
						<h2>Menu</h2>
					</header>
					<ul>
						<li><a href="index.html">Homepage</a></li>
						<li><a href="generic.html">Generic</a></li>
						<li><a href="elements.html">Elements</a></li>
						<li>
							<span class="opener">Submenu</span>
							<ul>
								<li><a href="#">Lorem Dolor</a></li>
								<li><a href="#">Ipsum Adipiscing</a></li>
								<li><a href="#">Tempus Magna</a></li>
								<li><a href="#">Feugiat Veroeros</a></li>
							</ul>
						</li>
						<li><a href="#">Etiam Dolore</a></li>
						<li><a href="#">Adipiscing</a></li>
						<li>
							<span class="opener">Another Submenu</span>
							<ul>
								<li><a href="#">Lorem Dolor</a></li>
								<li><a href="#">Ipsum Adipiscing</a></li>
								<li><a href="#">Tempus Magna</a></li>
								<li><a href="#">Feugiat Veroeros</a></li>
							</ul>
						</li>
						<li><a href="#">Maximus Erat</a></li>
						<li><a href="#">Sapien Mauris</a></li>
						<li><a href="#">Amet Lacinia</a></li>
					</ul>
				</nav>

				<!-- Section -->
				<section>
					<header class="major">
						<h2>Ante interdum</h2>
					</header>
					<div class="mini-posts">
						<article>
							<a href="#" class="image"><img src="resources/images/pic07.jpg" alt="" /></a>
							<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore aliquam.</p>
						</article>
						<article>
							<a href="#" class="image"><img src="resources/images/pic08.jpg" alt="" /></a>
							<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore aliquam.</p>
						</article>
						<article>
							<a href="#" class="image"><img src="resources/images/pic09.jpg" alt="" /></a>
							<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore aliquam.</p>
						</article>
					</div>
					<ul class="actions">
						<li><a href="#" class="button">More</a></li>
					</ul>
				</section>

				<!-- Section -->
				<section>
					<header class="major">
						<h2>Get in touch</h2>
					</header>
					<p>Sed varius enim lorem ullamcorper dolore aliquam aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore.
						Proin sed aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
					<ul class="contact">
						<li class="fa-envelope-o"><a href="#">information@untitled.tld</a></li>
						<li class="fa-phone">(000) 000-0000</li>
						<li class="fa-home">1234 Somewhere Road #8254<br /> Nashville, TN 00000-0000</li>
					</ul>
				</section>

				<!-- Footer -->
				<footer id="footer">
					<p class="copyright">&copy; Untitled. All rights reserved. Demo Images: <a href="https://unsplash.com">Unsplash</a>. Design: <a href="https://html5up.net">HTML5 UP</a>.</p>
				</footer>

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