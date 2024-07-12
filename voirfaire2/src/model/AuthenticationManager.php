<?php

//permet de gérer la création d'un compte / la connexion/déconnexion d'un user
class AuthenticationManager
{
    protected $accountStorage;

    protected $error;

    public function __construct($listeCompte)
    {
        $this->accountStorage = $listeCompte;
        $this->error = array("nom" => "", "prenom"=> "", "login" => "", "existanceLogin" => "", "password" => "");
    }

    public function getError()
    {
        return $this->error;
    }

    //verifie que la personne a bien rentre  le bon login avec le bon password associe
    public function connectUser($login, $password)
    {
        $user = 0;
        if ($this->accountStorage->checkAuth($login, $password)) {
            $_SESSION["user"] = $login;
            return true;
        }
        return false;
    }

    public function isUserConnected()
    {
        return $_SESSION["user"] !== null;
    }

    public function isAdminConnected()
    {
        return $_SESSION["user"]->getStatut() === "admin";
    }

    public function getUserName()
    {
        if ($this->isUserConnected()) {
            return $_SESSION["user"]->getName();
        }

    }

    //on cree l'utilisateur
    public function createUser($nom,$prenom , $login, $password, $statut)
    {
        if ($this->isValid($nom, $prenom, $login, $password)) {
            if ($this->accountStorage->createUser($nom, $prenom, $login, $password, $statut)) {
                return new Account($nom, $prenom, $login, $password, $statut);
            }
            $this->error["existanceLogin"] = "Login deja existant";
        }
        return null;
    }

    public function disconnectUser()
    {
        $_SESSION["user"] = null;
    }

    //on verifie que les informations donne sont valide
    function isValid($nom, $prenom, $login, $password)
    {
        $verif = true;
        if ($nom === "") {
            $this->error["nom"] = "Vous n'avez pas renseigné de nom.";
            $verif = false;
        }
        if ($login === "") {
            $this->error["login"] = "Vous n'avez pas renseigné de login.";
            $verif = false;
        }
        if ($password === "") {
            $this->error["password"] = "Vous n'avez pas renseigné de mot de passe.";
            $verif = false;

        }

        return $verif;
    }
}

?>
