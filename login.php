<?php

include "src/logic/Users.php";
include "src/App.php";



if (is_null(isAdmin())) {

    $name = $_REQUEST["name"];
    $pass = $_REQUEST["password"];
    $logic = new Users();
    $user = $logic->checkLogin($name, $pass);

    if (!is_null($user)) {
        sessionLogin($user[0]["name_admin"], "admin", $user[0]["id_admin"]);
        //Redirigir a página del administrador
        redirect("administracion.php");
    } else {
        redirect("index.php");
    }
} else {
    sessionLogout();
    redirect("index.php");
}


?>