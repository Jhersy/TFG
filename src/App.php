<?php
// require_once dirname(__DIR__) . "/config/config.php";
session_start();

// function getHostDB(){
//     return DB_HOST;
// }

// function getUserDB(){
//     return DB_USER;
// }

// function getUserPassDB(){
//     return DB_USER_PASS;
// }

// function getNameDB(){
//     return DB_NAME;
// }

function sessionLogin($name, $role, $id) {
    $_SESSION["name"] = $name;
    $_SESSION["role"] = $role;
    $_SESSION["id"] = $id;
}


function sessionLogout() {
    unset($_SESSION["name"]);
    unset($_SESSION["role"]);
    // session_destroy();
    // session_start();
}

function isAdmin() {
    if (isset($_SESSION["role"]) && $_SESSION["role"] = "admin"){
        return $_SESSION["role"];
    }else{
        return null;
    }
  }

function getName() {
    if (isset($_SESSION["name"])) {
      return $_SESSION["name"];
    } else {
      return null;
    }
}


function getID() {
    if (isset($_SESSION["id"])) {
      return $_SESSION["id"];
    } else {
      return null;
    }
}


function redirect($url, $secs = 0){
    header("Refresh: {$secs}; URL={$url}");
}


function formato_utf8($cadena){
    return str_replace(array("&aacute","&eacute","&iacute","&oacute","&uacute","&ntilde","&Aacute","&Eacute","&Iacute","&Oacute","&Uacute","&Ntilde", "&Ntilde") 
                        ,array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ","´p"), $cadena);
}


function getTipoDescarga($tipo_archivo){
    $tipo_descarga = "";
    switch ($tipo_archivo) {
        case 'application/pdf':
                $tipo_descarga = ".pdf";
            break;
        case 'text/plain':
            $tipo_descarga = ".txt";
        break;     
        case 'application/x-zip-compressed':
            $tipo_descarga = ".zip";
        break;  
        case 'image/jpeg':
            $tipo_descarga = ".jpg";
        break;  
        case 'image/png':
            $tipo_descarga = ".png";
        break;  
        default:
            $tipo_descarga = ".txt";
        break;
    }

    return $tipo_descarga;
}

?>