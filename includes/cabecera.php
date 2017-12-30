<?php 
require_once("src/App.php");
?>

<header id="header" style="padding-top:2em;">
    <div class="8u 8u$(small)">
        <a href="index.php" class="logo"><strong>Zaragoza Lingüística</strong></a>					
    </div>
    <div class="4u 4u$(small)">
        <ul class="icons">
        <?php
            if (is_null($rol) ) {
                echo '<li><a class="button special small" data-toggle="modal" data-target="#myModal">Iniciar sesión</a></li>';
            }
            else {
                $name = getName();
                echo '<li><i class="fa fa-user" aria-hidden="true"></i> '. $name . ' - <a href="administracion.php">Administrar <i class="fa fa-cog" aria-hidden="true"></i></a> <a id="enlace-logout" href="login.php">Salir <i class="fa fa-sign-out" aria-hidden="true"></i></a></li>';
            }
        ?>
        </ul>					
    </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <a type="button" class="close" data-dismiss="modal">&times;</a>
                    <h3><span class="glyphicon glyphicon-lock"></span> Iniciar sesión</h3>
                </div>
                <div class="modal-body">
                    <form role="form" action="login.php" method="post">
                        <div class="form-group">
                            <label for="username"><span class="glyphicon glyphicon-user"></span> Usuario</label>
                            <input type="text" class="form-control" id="username" name="name" placeholder="Introduce identificador de usuario">
                        </div>
                        <div class="form-group">
                            <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Introduce contraseña">
                        </div>
                        <div>
                            <button type="submit" class="btn special btn-block"<span class="glyphicon glyphicon-off"></span> Login</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>