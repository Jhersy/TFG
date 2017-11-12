<?php

include "src/dao/DAOUsuarios.php";

Class Users{

    private $daoUsuarios;

    function Users() {
        $this->daoUsuarios = new DAOUsuarios();
    }

    function checkLogin($username, $password){

        $user = $this->daoUsuarios->findUserByName($username);

        if (is_null($user) || !password_verify($password, $user[0]['password_admin'])) {
            return null;
        }
        return $user;
      }


    function newUser($name, $password) {
        //Se encripta la password
        $hpassword = password_hash($password, PASSWORD_BCRYPT);
        return $this->daoUsuarios->insert($name, $hpassword);
    }
}
?>