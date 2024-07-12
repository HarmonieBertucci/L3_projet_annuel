<?php


class WaitStorageMySQL
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function read($id)
    {
        $requete = "SELECT * FROM Attente WHERE id=:id";
        $stmt = $this->pdo->prepare($requete);
        $data = array('id' => $id);
        $stmt->execute($data);
        $value = $stmt->fetch();
        if (!$value) {
            return false;
        }
        return $value;
    }
    public function updateAdmin($id, $fiche)
    {
        $update = $this->pdo->prepare("UPDATE Attente SET titre=:titre, type=:type, categorie=:categorie,rue=:rue,ville=:ville,codePostal=:codePostal,latitude=:lat,longitude=:lng,tarification=:tarification,horaire=:horaire,ageMinimum=:ageMinimum,description=:description WHERE id = :id");
        $update->execute([
            'id' => $id,
            'titre' => $fiche->getTitre(),
            'type' => $fiche->getType(),
            'categorie' => $fiche->getCategorie(),
            'rue' => $fiche->getRue(),
            'ville' => $fiche->getVille(),
            'codePostal' => $fiche->getCodePostal(),
            'lat' => $fiche->getLatitude(),
            'lng' => $fiche->getLongitude(),
            'tarification' => $fiche->getTarification(),
            'horaire' => $fiche->getHoraire(),
            'ageMinimum' => $fiche->getAgeMinimum(),
            'description' => $fiche->getDescription(),


        ]);


    }

    public function updateUser($id, $fiche)
    {
        $update = $this->pdo->prepare("INSERT INTO Attente (id, titre, type, categorie,rue,ville,codePostal,latitude,longitude,tarification,horaire,ageMinimum,description,pseudo_proprio,id_existant, action) VALUES (:id, :titre, :type, :categorie,:rue,:ville,:codePostal,:lat,:lng,:tarification,:horaire,:ageMinimum,:description, :pseudo_proprio, :id_existant, :action)");
        $update->execute([
            'id' => $this->getLastId() + 1,
            'titre' => $fiche->getTitre(),
            'type' => $fiche->getType(),
            'categorie' => $fiche->getCategorie(),
            'rue' => $fiche->getRue(),
            'ville' => $fiche->getVille(),
            'codePostal' => $fiche->getCodePostal(),
            'lat' => $fiche->getLatitude(),
            'lng' => $fiche->getLongitude(),
            'tarification' => $fiche->getTarification(),
            'horaire' => $fiche->getHoraire(),
            'ageMinimum' => $fiche->getAgeMinimum(),
            'description' => $fiche->getDescription(),
            'pseudo_proprio' => $fiche->getIdProprio(),
            'id_existant' => $id,
            'action' => 'modification',
        ]);


    }


    public function create(Fiche $fiche)
    {

        $create = $this->pdo->prepare("INSERT INTO Attente (id, titre, type, categorie,rue,ville,codePostal,latitude,longitude,tarification,horaire,ageMinimum,description,pseudo_proprio,id_existant, action) VALUES (:id, :titre, :type, :categorie,:rue,:ville,:codePostal,:lat,:lng,:tarification,:horaire,:ageMinimum,:description, :pseudo_proprio, :id_existant, :action)");
        $create->execute([
            'id' => $this->getLastId() + 1,
            'titre' => $fiche->getTitre(),
            'type' => $fiche->getType(),
            'categorie' => $fiche->getCategorie(),
            'rue' => $fiche->getRue(),
            'ville' => $fiche->getVille(),
            'codePostal' => $fiche->getCodePostal(),
            'lat' => $fiche->getLatitude(),
            'lng' => $fiche->getLongitude(),
            'tarification' => $fiche->getTarification(),
            'horaire' => $fiche->getHoraire(),
            'ageMinimum' => $fiche->getAgeMinimum(),
            'description' => $fiche->getDescription(),
            'pseudo_proprio' => $fiche->getIdProprio()["pseudo"],
            'id_existant' => null,
            'action' => 'creation',
        ]);
        return $this->pdo->lastInsertId(); // fonction qui natif a mySQL


    }

    public function readAll($data = null,$tri = ["id", "ASC"])

    {
        $requete = "SELECT * FROM Attente ";

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
        $requete = "SELECT * FROM Attente WHERE pseudo_proprio = :pseudo_proprio";
        $stmt = $this->pdo->prepare($requete);
        $stmt->execute(['user_id' => $userId]);
        $res = $stmt->fetchAll();
        $liste = [];
        foreach ($res as $key => $value) {
            $liste[] = new Fiche($value);
        }
        return $liste;
    }

    public function deleteUser($id){

              $create = $this->pdo->prepare("INSERT INTO Attente (id, titre, type, categorie,rue,ville,codePostal,latitude,longitude,tarification,horaire,ageMinimum,description,pseudo_proprio,id_existant, action) VALUES (:id, :titre, :type, :categorie,:rue,:ville,:codePostal,:lat,:lng,:tarification,:horaire,:ageMinimum,:description, :pseudo_proprio, :id_existant, :action)");
              $create->execute([
                  'id' => $this->getLastId() + 1,
                  'titre' => $fiche->getTitre(),
                  'type' => $fiche->getType(),
                  'categorie' => $fiche->getCategorie(),
                  'rue' => $fiche->getRue(),
                  'ville' => $fiche->getVille(),
                  'codePostal' => $fiche->getCodePostal(),
                  'lat' => $fiche->getLatitude(),
                  'lng' => $fiche->getLongitude(),
                  'tarification' => $fiche->getTarification(),
                  'horaire' => $fiche->getHoraire(),
                  'ageMinimum' => $fiche->getAgeMinimum(),
                  'description' => $fiche->getDescription(),
                  'pseudo_proprio' => $fiche->getIdProprio()["pseudo"],
                  'id_existant' => null,
                  'action' => 'delete',
              ]);
              return $this->pdo->lastInsertId(); // fonction qui natif a mySQL

    }

    public function delete($id)
    {
        $delete = $this->pdo->prepare("DELETE FROM Attente WHERE id=:id");
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
