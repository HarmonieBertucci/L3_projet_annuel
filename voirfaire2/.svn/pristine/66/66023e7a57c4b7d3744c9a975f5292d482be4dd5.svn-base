<?php


class ImagesEnAttenteStorageMySQL
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function read($id)
    {
        $requete = "SELECT * FROM ImageEnAttente WHERE id=:id";
        $stmt = $this->pdo->prepare($requete);
        $data = array('id' => $id);
        $stmt->execute($data);
        $value = $stmt->fetch();
        if (!$value) {
            return false;
        }
        return ;
    }

    public function readWithIdFiche($id)
    {
        $requete = "SELECT * FROM ImageEnAttente WHERE idAnnonce=:id";
        $stmt = $this->pdo->prepare($requete);
        $data = array('id' => $id);
        $stmt->execute($data);
        return $stmt->fetchAll();
    }

    public function readFirstWithIdFiche($id){
      $liste=$this->readWithIdFiche($id);

      return (empty($liste) ? null : $liste[0]);
    }


    public function create($image,$idAnnonce)
    {

        $create = $this->pdo->prepare("INSERT INTO ImageEnAttente (id, img, idAnnonce) VALUES (:id, :img, :idAnnonce)");
        $create->execute([
            'id' =>$this->getLastIdForAnnonce($idAnnonce)+1,
            'img' => $image,
            'idAnnonce' => $idAnnonce,
        ]);
        return $this->pdo->lastInsertId(); // fonction  natif a mySQL


    }
public function readAll()

{

    $requete = "SELECT * FROM ImageEnAttente";
    $stmt = $this->pdo->prepare($requete);
    $stmt->execute();

    return $stmt->fetchAll();

}


    public function delete($id,$idAnnonce)
    {
        $delete = $this->pdo->prepare("DELETE FROM ImageEnAttente WHERE id=:id AND idAnnonce=:idAnnonce");
        $delete->execute(['id' => $id,
                          'idAnnonce'=>$idAnnonce
                          ]);
    }

    public function getLastIdForAnnonce($idAnnonce){
      $liste = $this->readAll();

      return ($liste!=null)?$liste[sizeof($liste)-1]["id"] : 1;
    }


}

?>
