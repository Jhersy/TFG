<?php
require_once("src/App.php");
require_once("src/logic/Users.php");

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
	<link rel="icon" href="https://secure.gravatar.com/blavatar/3455840a986cc52bce4a312622afb6b5?s=32" type="image/x-icon">
    <link rel="stylesheet" href="resources/assets/css/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Subir subtítulo</title>
    <script>


    function insertAdmin(){
        var password = $("#password1").val();
        var repeatPass = $("#confirm_password").val();
        var usuario = $("#usernametext").val().trim();
        if(usuario == ""){
            alert('El usuario no puede ser vacío');
        }else if(password == "" || repeatPass == ""){
            alert('Las contraseñas no pueden ser vacías');
        }else if(password != repeatPass){
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

    function deleteAdmin(){

        if($("input:checkbox:checked").length < 0){
            alert('No has seleccionado ningún administrador');
        }else{
            var nameAdmins = "";
            $("input:checkbox:checked").each(function(){    
                nameAdmins += $(this).attr("id") + '|';         
            });

            var parametros = { 
                "nameAdmins" : nameAdmins
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

            <!-- Cabecera -->
            <?php require('includes/cabecera.php'); ?>
            <!-- 		-->

            <section>

                <div class="features">
                    <article>
                        <span class="icon fa fa-plus small"></span>
                        <div class="content">
                            <h4><a data-toggle="modal" data-target="#myModal2">Añadir administrador</a></h4>
                        </div>
                    </article>
                    <article>
                        <span class="icon fa fa-minus small"></span>
                        <div class="content">
                            <h4><a data-toggle="modal" data-target="#myModal3">Eliminar administrador</a></h4>
                        </div>
                    </article>
                </div>
            </section>




            <!--  MODAL AÑADIR ADMINISTRADOR  -->
            <div class="modal fade" tabindex="-1" role="dialog" id="myModal2" aria-labelledby="gridSystemModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <a type="button" class="close" data-dismiss="modal">&times;</a>
                            <h4 class="modal-title" id="gridSystemModalLabel">Añadir administrador</h4>
                        </div>
                        <div class="modal-body">
                            <!-- <form role="form" action="add_administrator.php" method="post"> -->
                            <label ><span class="glyphicon glyphicon-user"></span> Usuario</label>
                            <input type="text"  id="usernametext" name="name" >
                            <br>
                            <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Contraseña</label>
                            <input type="password" class="form-control" id="password1" name="password" required>
                            <br>
                            <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Repetir contraseña</label>
                            <input type="password" class="form-control" id="confirm_password" name="password" required>
                            <br>
                        <!-- </form>         -->
                    
                        </div>
                            <div class="modal-footer">
                                <button type="button" class="button small" data-dismiss="modal">Cancelar</button>
                                <button type="submit" onclick="insertAdmin()"  class="button special small"<span class="glyphicon glyphicon-off"></span> Añadir administrador</button>
                            </div>
                            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
                    </div>
                </div>
            </div>


            <!--  MODAL ELIMINAR ADMINISTRADOR  -->
            <div class="modal fade" tabindex="-1" role="dialog" id="myModal3" aria-labelledby="gridSystemModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <a type="button" class="close" data-dismiss="modal">&times;</a>
                            <h4 class="modal-title" id="gridSystemModalLabel">Eliminar administrador</h4>
                        </div>
                        <div class="modal-body">
                            <div style="width:100%; height:22em;  border:solid 0.5px #FAFAFA;   overflow:auto;">
                                <ul class="alt">
                                    <?php 
                                        /* LISTAMOS LOS ADMINSITRADORES DE LA BASE DE DATOS */
                                        $admins = new Users();
                                        $administradores = $admins->getAllAdmins(getName());
                                        if( sizeof($administradores) == 0){
                                            echo 'No se han encontrado más administradores en la base de datos';
                                        }else{
                                        foreach($administradores as $admin){ 
                                    ?>
                                    <li>
                                        <input type="checkbox" id="<?=$admin['name_admin']?>" name="<?=$admin['name_admin']?>" >
                                        <label style="width:100%" for="<?=$admin['name_admin']?>"><?=$admin['name_admin']?></label>                                    
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
                            <button type="submit" onclick="deleteAdmin()"  class="button special small"<span class="glyphicon glyphicon-off"></span> Eliminar administrador</button>
                        </div>
                    </div>
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