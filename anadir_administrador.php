<?php
require_once("src/App.php");

$rol = isAdmin(); //Return session admin or null
//Scraping

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

    function insertAdmin(){
        var password = $("#password").val();
        var repeatPass = $("#confirm_password").val();
        var usuario = $("#username").val().trim();
        if(usuario == ""){
            alert('El usuario no puede ser vacío');
        }
        if(password != repeatPass){
            alert('Las contraseñas no son iguales');
        }else{
            var parametros = {
                "user" : usuario,
                "pass" : password
            }
            $.ajax({
                data:  parametros,
                url:   'add_administrator.php',
                type:  'post',
                success:  function (data) {
                    window.alert(data);
                    window.location.href = "anadir_administrador.php";
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
					<a href="administracion.php" class="logo"><strong>Zaragoza Lingüística - Administración</strong></a>
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
                <header class="main">
                    <h4>Añadir un nuevo administrador: </h4>
                </header>
                    <div class="4u 12u$(small)">
                        <!-- <form role="form" action="add_administrator.php" method="post"> -->
                            <label for="username"><span class="glyphicon glyphicon-user"></span> Usuario</label>
                            <input type="text"  id="username" name="name" >
                            <br>
                            <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <br>
                            <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Repetir contraseña</label>
                            <input type="password" class="form-control" id="confirm_password" name="password" required>
                            <br>
                        <button type="submit" onclick="insertAdmin()"  class="button special small"<span class="glyphicon glyphicon-off"></span> Añadir usuario</button>
                        <!-- </form>         -->
                    
                    </div>                
                
                </section>


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