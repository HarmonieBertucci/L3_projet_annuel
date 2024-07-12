<?php

require_once("FicheStorage.php");

class CommStorageSQL
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function read($id)
    {
        $requete = "SELECT * FROM Commentaire WHERE idAnnonce=:id";
        $stmt = $this->pdo->prepare($requete);
        $data = array('id' => $id);
        $stmt->execute($data);
        $value = $stmt->fetchAll();
        $liste = [];
        if (!$value) {
            return null;
        }
        foreach($value as $key => $comm){
          $liste[]=new Comm($comm["user"],$comm["comm"],$comm["idAnnonce"],$comm["notation"]);// new Comm($comm[0],$comm[1],$comm[2],$comm[3]);
        }
        return  $liste;
    }


    public function update($id, $comm)
    {
        $update = $this->pdo->prepare("UPDATE Commentaire SET comm:comm, WHERE idAnnonce = :id");
        $update->execute([
            'id'=>$id,
            'comm'=>$comm->getComm(),
        ]);


    }


    public function create(Comm $comm)
    {

        $create = $this->pdo->prepare("INSERT INTO Commentaire (id,user,comm,idAnnonce,notation) VALUES (:id,:user,:comm,:idAnnonce,:notation)");
        $create->execute([
            'id' =>$this->getLastId()+1,
            'user'=>$comm->getUser(),
            'comm'=>$comm->getComm(),
            'idAnnonce'=>$comm->getIdAnnonce(),
            'notation'=>$comm->getNotation(),
        ]);
        return $this->pdo->lastInsertId(); // fonction  natif a mySQL


    }

    public function readAll($tri = "ville")
    {

        
        $requete = "SELECT * FROM Commentaire ORDER BY :tri ";

        $stmt = $this->pdo->prepare($requete);
        $stmt->execute([":tri"=>$tri]);

        $res = $stmt->fetchAll();
        $liste = [];
        foreach ($res as $key => $value) {
            $liste[] = new Fiche($value);
        }
        return $liste;
    }


    public function findByUserId($userId)
    {
        $requete = "SELECT * FROM Commentaire WHERE user = :user";
        $stmt = $this->pdo->prepare($requete);
        $stmt->execute(['user' => $userId]);
        $res = $stmt->fetchAll();
        $liste = [];
        foreach ($res as $key => $value) {
            $liste[] = new Fiche($value);
        }
        return $liste;
    }


    public function delete($id)
    {
        $delete = $this->pdo->prepare("DELETE FROM Commentaire WHERE id=:id");
        $delete->execute(['id' => $id]);
    }

    public function getLastId(){
      $liste = $this->readAll();

      return ($liste!=null)?$liste[sizeof($liste)-1]->getId() : 1;
    }


}


?>
