<?php

// Inclusion des classes utilisées dans ce fichier
require_once("model/Account.php");
require_once("model/AccountStorage.php");

//permet de stocker les comptes des utilisateurs dans la base sql
class AccountStorageMySQL implements AccountStorage
{
    protected $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo; //base mysql
    }

    //vérification de si le login et le password sont corrects pour la connexion
    public function checkAuth($login, $password){

             $check = $this->pdo->prepare("SELECT * FROM Account where pseudo = :pseudo ");
             $check->execute([
                 'pseudo' => $login,
             ]);
             $value = $check->fetch();

           if ($value!==false ) {
                 $_SESSION["user"] = $value; // création de la session avec les données de l'utilisateur
                 return true;
             }
         }



    //permet de créer un user dans la base
    public function createUser($nom,$prenom,$login,$password,$statut){

        //si il existe déjà un utilisateur ayant ce login on renvoie false
        $requete = 'SELECT * FROM Account WHERE pseudo= :pseudo  ;';
        $stmt = $this->pdo->prepare($requete);
        $data = array(
          ':pseudo' => $login
        );

        $stmt->execute($data);
        $ligne = $stmt->fetchAll();
        if($ligne != null){
          return false;
                  }

        //sinon on hash le pashword et on insère la ligne dans la base puis on return true
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $requete = "INSERT INTO Account VALUES (:nom,:prenom, :pseudo, :password, :statut);";
        $stmt = $this->pdo->prepare($requete);
        $data = array(
          ':nom' => $nom,
          ':prenom' => $prenom,
          ':pseudo' => $login,
          ':password' => $passwordHash,
          ':statut' => $statut
        );
        $stmt->execute($data);
        return true;
    }

    public function getListUsers()
    { // retourne une liste des utilisateurs avec leurs login et leurs noms
        $requete = 'SELECT * FROM Account ;';
        $stmt = $this->pdo->query($requete);
        $ligne = $stmt->fetchAll();
        $liste = array();
        foreach ($ligne as $key => $value) {
            $liste[$key] = $ligne[$key]["pseudo"];
        }
        return $liste;
    }

    //retourne les informations de l'utilisateur  recupere de la base de donnee
    public function getUser($login)
    {
        $requete = 'SELECT * FROM Account WHERE pseudo = :login;';
        $stmt = $this->pdo->prepare($requete);
        $data = array(
            ':login' => $login
        );
        $stmt->execute($data);
        $ligne = $stmt->fetch();
        if ($ligne !== false) {
            return new Account($ligne["nom"], $ligne["prenom"], $ligne["pseudo"], "", "");
        } else {
            return null;
        }
    }

    //suprime l'utilisateur de la base de donnee
    public function delete($login)
    {
        $requete = "DELETE FROM Account WHERE pseudo = :login;";
        $stmt = $this->pdo->prepare($requete);
        $data = array(
            ':login' => $login
        );
        $stmt->execute($data);
    }
}


?>
