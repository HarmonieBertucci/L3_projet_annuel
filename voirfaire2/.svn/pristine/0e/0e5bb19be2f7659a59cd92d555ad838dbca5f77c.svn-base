<?php

class Fiche
{


    const TYPE_CHOICE = ["Lieu", "Activité", "Les deux"];
    protected $id;
// titre donné par la personne qui ajoute la Superstition
    protected $titre;
//si la Superstition est positive ou négative
    protected $type;

    protected $categorie;
//descriptif de la Superstition
    protected $description;
//lieu si connue de la Superstition
    protected $rue;

    protected $codePostal;

    protected $ville;

    protected  $longitude;

    protected  $latitude;

    protected $tarification;

    protected $horaire;

    protected $ageMinimum;

    protected $commentaire;

    protected $etoile;
//image si donnée par l'ajouteur
    protected $image;
//login de la personne qui ajoute
    protected $pseudo_proprio;

    function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'id';
                    $this->id = $value;
                    break;
                case 'titre';
                    $this->titre = $value;
                    break;
                case 'type';
                    $this->type = $value;
                    break;
                case 'categorie';
                    $this->categorie = $value;
                    break;
                case 'rue';
                    $this->rue = $value;
                    break;
                case 'ville';
                    $this->ville = $value;
                    break;
                case 'codePostal';
                    $this->codePostal = $value;
                    break;
                case 'latitude';
                    $this->latitude = $value;
                    break;
                case 'longitude';
                    $this->longitude = $value;
                    break;
                case 'description';
                    $this->description = $value;
                    break;
                case 'tarification';
                    $this->tarification = $value;
                    break;
                case 'horaire';
                    $this->horaire = $value;
                    break;
                case 'ageMinimum';
                    $this->ageMinimum = $value;
                    break;

                case 'pseudo_proprio';
                    $this->pseudo_proprio = $value;
                    break;


            }
        }


    }

    function getId()
    {
        return $this->id;
    }

    function getTitre()
    {
        return $this->titre;
    }

    function getType()
    {
        return $this->type;
    }

    function getCategorie()
    {
        return $this->categorie;
    }

    function getRue()
    {
        return $this->rue;
    }

    function getVille()
    {
        return $this->ville;
    }

    function getCodePostal()
    {
        return $this->codePostal;
    }

    function getLatitude()
    {
        return $this->latitude;
    }

    function getLongitude()
    {
        return $this->longitude;
    }

    function getDescription()
    {
        return $this->description;
    }


    public function getTarification()
    {
        return $this->tarification;
    }

    public function getHoraire()
    {
        return $this->horaire;
    }


    public function getAgeMinimum()
    {
        return $this->ageMinimum;
    }

    public function getNotation()
    {
        return $this->notation;
    }

    public function getCommentaire()
    {
        return $this->pseudo_proprio;
    }

    public function getImage()
    {
        return $this->image;
    }

    function getIdProprio()
    {
        return $this->pseudo_proprio;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }


    public function setTitre($titre): void
    {
        $this->titre = $titre;
    }

    public function setType($type): void
    {
        $this->type = $type;
    }


    public function setCategorie($categorie): void
    {
        $this->categorie = $categorie;
    }


    public function setDescription($description): void
    {
        $this->description = $description;
    }


    public function setRue($rue): void
    {
        $this->rue = $rue;
    }


    public function setCodePostal($codePostal): void
    {
        $this->codePostal = $codePostal;
    }


    public function setVille($ville): void
    {
        $this->ville = $ville;
    }



    public function setTarification($tarification): void
    {
        $this->tarification = $tarification;
    }


    public function sethoraire($horaire): void
    {
        $this->horaire = $horaire;
    }


    public function setAgeMinimum($ageMinimum): void
    {
        $this->ageMinimum = $ageMinimum;
    }



}


?>
