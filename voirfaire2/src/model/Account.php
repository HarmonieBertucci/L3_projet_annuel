<?php

// classe pour représenter les comptes des tuilisateurs
class Account
{
    protected $nom;
    protected $prenom;
    protected $login;
    protected $password;
    protected $statut; //"user" ou "admin"


    public function __construct($name, $surname, $login, $password, $statut=null)
    {

        $this->name = $name;
        $this->surname = $surname;
        $this->login = $login;
        $this->password = $password;
        $this->statut = $statut;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurName()
    {
        return $this->surname;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getStatut()
    {
        return $this->statut;
    }
}


?>
