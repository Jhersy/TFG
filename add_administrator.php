<?php
require_once("src/logic/Users.php");
require_once("src/App.php");

/*  AÑADE UN ADIMINISTRADOR EN LA BASE DE DATOS */

$rol = isAdmin(); //Return session admin or null

if (!is_null($rol)) {
    
    isset($_POST['user']) ? $user = $_POST['user'] : $user = "";
    isset($_POST['pass']) ? $password = $_POST['pass'] : $password = "";
    isset($_POST['nameAdmins']) ? $deleteAdmins = $_POST['nameAdmins'] : $deleteAdmins = "";
    
    //Insertamos en la base de datos
    $usuarios = new Users();
    
    if (!empty($deleteAdmins)) {
        $errorEliminados = false;
        //Recorres todos los usuarios que se quieren eliminar
        $admins          = explode("|", $deleteAdmins);
        foreach ($admins as $admin) {
            if (!empty($admin))
                if (!$usuarios->deleteUser($admin))
                    $errorEliminados = true;
        }
        
        if ($errorEliminados)
            echo 'Error al eliminar';
        else
            echo 'Usuario/s eliminados';
    } else {
        if (!empty($user) && !empty($password)) {
            if ($usuarios->newUser($user, $password)) { //INSERTADO CORRECTAMENTE
                echo "Usuario insertado correctamente";
            } else {
                echo "El usuario YA existe en la base de datos";
            }
        }
    }
} else {
    redirect("index.php");
}

?>