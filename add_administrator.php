<?php

require_once("src/logic/Users.php");
require_once("src/App.php");

$rol = isAdmin(); //Return session admin or null

if(!is_null($rol)){

    $user = $_POST['user'];
    $password = $_POST['pass']; 

    //Insertamos en la base de datos
    $usuarios = new Users();

    if($usuarios->newUser($user, $password)){ //INSERTADO CORRECTAMENTE
        echo "Usuario insertado correctamente";
    }else{
        echo "El usuario YA existe en la base de datos";
    }

}else{
    redirect("index.php");
}

?>