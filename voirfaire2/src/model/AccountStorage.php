<?php

//permet de stocker les comptes des utilisateurs
interface AccountStorage
{
    public function checkAuth($login, $password);

}

?>
