<?php

require_once("FicheStorage.php");

class FicheStorageMySQL implements FicheStorage
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function read($id)
    {
        $requete = "SELECT * FROM Annonces WHERE id=:id";
        $stmt = $this->pdo->prepare($requete);
        $data = array('id' => $id);
        $stmt->execute($data);
        $value = $stmt->fetch();
        if (!$value) {
            return false;
        }
        return new Fiche($value);
    }


    public function update($id, $fiche)
    {
        $update = $this->pdo->prepare("UPDATE Annonces SET titre=:titre, type=:type, categorie=:categorie,rue=:rue,ville=:ville,codePostal=:codePostal,latitude=:latitude,longitude=:longitude,tarification=:tarification,horaire=:horaire,ageMinimum=:ageMinimum,description=:description WHERE id = :id");
        $update->execute([
            'id' => $id,
            'titre' => $fiche->getTitre(),
            'type' => $fiche->getType(),
            'categorie' => $fiche->getCategorie(),
            'rue' => $fiche->getRue(),
            'ville' => $fiche->getVille(),
            'codePostal' => $fiche->getCodePostal(),
            'latitude' => $fiche->getLatitude(),
            'longitude' => $fiche->getLongitude(),
            'tarification' => $fiche->getTarification(),
            'horaire' => $fiche->getHoraire(),
            'ageMinimum' => $fiche->getAgeMinimum(),
            'description' => $fiche->getDescription(),


        ]);


    }


    public function create(Fiche $fiche)
    {

        $create = $this->pdo->prepare("INSERT INTO Annonces (id, titre, type, categorie,rue,ville,codePostal,latitude,longitude,tarification,horaire,ageMinimum,description,pseudo_proprio) VALUES (:id, :titre, :type, :categorie,:rue,:ville,:codePostal,:latitude,:longitude,:tarification,:horaire,:ageMinimum,:description, :pseudo_proprio)");
        $create->execute([
            'id' => $this->getLastId() + 1,
            'titre' => $fiche->getTitre(),
            'type' => $fiche->getType(),
            'categorie' => $fiche->getCategorie(),
            'rue' => $fiche->getRue(),
            'ville' => $fiche->getVille(),
            'codePostal' => $fiche->getCodePostal(),
            'latitude' => $fiche->getLatitude(),
            'longitude' => $fiche->getLongitude(),
            'tarification' => $fiche->getTarification(),
            'horaire' => $fiche->getHoraire(),
            'ageMinimum' => $fiche->getAgeMinimum(),
            'description' => $fiche->getDescription(),
            'pseudo_proprio' => $fiche->getIdProprio(),
        ]);
        return $this->pdo->lastInsertId(); // fonction qui natif a mySQL


    }

    public function readAll(){
      $requete = "SELECT * FROM Annonces ";
      $stmt = $this->pdo->prepare($requete);
      $stmt->execute();
      $res = $stmt->fetchAll();
      $liste = [];
      foreach ($res as $key => $value) {
          $liste[] = new Fiche($value);
      }

      return $liste;
    }

    public function readAllRecherche($data = null, $tri = [], $filter=null)

    {

        $tri = explode("_",$tri);
        if(count($tri)==2 && in_array($tri[1], ["ASC","DESC"]) && !empty($tri)){
            echo"ok";
            var_dump($tri);
            $data = htmlspecialchars($data);
            $requete = "SELECT * FROM Annonces  ORDER BY {$tri[0]} {$tri[1]}";
        }
        else if (!empty($filter)){

            $requete = "SELECT * FROM Annonces WHERE type = '{$filter}' ";
            /*
            if($filter !== null){
              $requete .=" WHERE ";

            //$requete = "SELECT * FROM Annonces ORDER BY {$tri[0]} {$tri[1]}";

              for($i =0 ; $i<strlen($filter); $i++){
                if($i >=2){
                  $requete .=" AND ";
                }
                $requete .=$filter[$i];
              }
            }
           $requete .=" ORDER BY {$tri[0]} {$tri[1]}";*/
       }
        else if (count($tri)==2 && in_array($tri[1], ["ASC","DESC"]) && !empty($tri) && !empty($filter)){
            $requete = "SELECT * FROM Annonces WHERE type = '{$filter}'ORDER BY {$tri[0]} {$tri[1]} ";
        }
        else{
            $requete = "SELECT * FROM Annonces ";

        }

        $stmt = $this->pdo->prepare($requete);
        $stmt->execute();
        $res = $stmt->fetchAll();
        $liste = [];
        foreach ($res as $key => $value) {
            $liste[] = new Fiche($value);
        }

        return $liste;
    }

    public function findByUserId($userId)
    {
        $requete = "SELECT * FROM Annonces WHERE pseudo_proprio = :pseudo_proprio";
        $stmt = $this->pdo->prepare($requete);
        $stmt->execute(['user_id' => $userId]);
        $res = $stmt->fetchAll();
        $liste = [];
        foreach ($res as $key => $value) {
            $liste[] = new Fiche($value);
        }
        return $liste;
    }


    public function delete($id)
    {
        $delete = $this->pdo->prepare("DELETE FROM Annonces WHERE id=:id");
        $delete->execute(['id' => $id]);
    }

    public function getLastId()
    {
        $liste = $this->readAll();

        return ($liste != null) ? $liste[sizeof($liste) - 1]->getId() : 0;
    }

    public function describe()
    {
        $describe = $this->pdo->prepare("DESCRIBE Image;");
        $describe->execute();
        return $describe->fetchAll();
    }
}

?>
