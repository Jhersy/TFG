<?php

include "src/dao/DAOUsuarios.php";

Class Users{

    private $daoUsuarios;

    function Users() {
        $this->daoUsuarios = new DAOUsuarios();
    }

    function checkLogin($username, $password){

        $user = $this->daoUsuarios->findUserByName($username);

        if (empty($user) || !password_verify($password, $user[0]['password_admin'])) {
            return null;
        }
        return $user;
      }


    function newUser($name, $password) {
        //Se comprueba que le administrador no está dado de alta 
        $user = $this->daoUsuarios->findUserByName($name);

        $insertado = "";

        if (empty($user)) {
            //Se encripta la password
            $hpassword = password_hash($password, PASSWORD_BCRYPT);
            $insertado = $this->daoUsuarios->insert($name, $hpassword);
        }
        return !empty($insertado);
    }

    function deleteUser($name) {
        $user = $this->daoUsuarios->findUserByName($name);        
        $eliminado = false;

        if (!empty($user)) {
            $eliminado = $this->daoUsuarios->delete($name);
        }

        return $eliminado;
    }


    function getAllAdmins($currentAdmin){
        return  $this->daoUsuarios->getAllAdmins($currentAdmin);
    }
}
?>