<?php

include "src/dao/DAOUsuarios.php";

Class Users{

    private $daoUsuarios;

    function Users() {
        $this->daoUsuarios = new DAOUsuarios();
    }

    function checkLogin($username){


        $user = $this->daoUsuarios->findUserByName($username);

       /* if (is_null($user) || !password_verify($password, $user["password_admin"])) {
          return null;
        }*/
        return $user;
      }
}
?>