<?php

class FicheBuilder
{
    const TITRE_REF = "titre";
    const TYPE_REF = "type";
    const CATEGORIE_REF = "categorie";
    const RUE_REF = "rue";
    const VILLE_REF = "ville";
    const CODE_POSTAL_REF = "codePostal";
    const LAT_CHOICE = "lat";
    const LNG_REF = "lng";
    const DESCRIPTION_CHOICE = "description";
    const TARIFICATION_REF = "tarification";
    const HORAIRES_REF = "horaires";
    const AGE_MINIMUM_REF = "ageMinimum";
    const PSEUDO_PROPRIO_REF = "pesudo_Proprio";
    const TYPE_CHOICE = ["Lieu", "Activitée", "Les Deux"];
    const TRI_CHOICE = ["Ville", "Prix", "Pertinence"];



    protected array $data = [];
    protected array $errors = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }


    public function getErrors()
    {
        return $this->errors;
    }

    public static function buildFromFiche(Fiche $fiche)
    {
        return new FicheBuilder(array(
            self::TITRE_REF => $fiche->getTitre(),
            self::TYPE_REF => $fiche->getType(),
            self::CATEGORIE_REF => $fiche->getCategorie(),
            self::RUE_REF => $fiche->getRue(),
            self::VILLE_REF => $fiche->getVille(),
            self::CODE_POSTAL_REF => $fiche->getCodePostal(),
            self::LAT_CHOICE => $fiche->getLatitude(),
            self::LNG_REF => $fiche->getLongitude(),
            self::DESCRIPTION_CHOICE => $fiche->getDescription(),
            self::TARIFICATION_REF => $fiche->getTarification(),
            self::HORAIRES_REF => $fiche->getHoraire(),
            self::AGE_MINIMUM_REF => $fiche->getAgeMinimum(),
            self::PSEUDO_PROPRIO_REF => $fiche->getIdProprio(),


        ));
    }


    public function updateFiche(Fiche $fiche)
    {
        if (key_exists(self::TITRE_REF, $this->data))
            $fiche->setTitre($this->data[self::TITRE_REF]);
        if (key_exists(self::TYPE_REF, $this->data))
            $fiche->setType($this->data[self::TYPE_REF]);
        if (key_exists(self::DESCRIPTION_CHOICE, $this->data))
            $fiche->setDescription($this->data[self::DESCRIPTION_CHOICE]);
        if (key_exists(self::RUE_REF, $this->data))
            $fiche->setRue($this->data[self::RUE_REF]);
        if (key_exists(self::VILLE_REF, $this->data))
            $fiche->setVille($this->data[self::VILLE_REF]);
        if (key_exists(self::CODE_POSTAL_REF, $this->data))
            $fiche->setCodePostal($this->data[self::CODE_POSTAL_REF]);
        if (key_exists(self::TARIFICATION_REF, $this->data))
            $fiche->setTarification($this->data[self::TARIFICATION_REF]);
        if (key_exists(self::HORAIRES_REF, $this->data))
            $fiche->setHoraires($this->data[self::HORAIRES_REF]);
        if (key_exists(self::AGE_MINIMUM_REF, $this->data))
            $fiche->setAgeMinimum($this->data[self::AGE_MINIMUM_REF]);
    }

    public function isValid()
    {
        $this->errors = [];
        if (!key_exists(self::TITRE_REF, $this->data) || $this->data[self::TITRE_REF] === "") {
            $this->errors[self::TITRE_REF] = "Vous devez entrer un titre";
        } else if (mb_strlen($this->data[self::TITRE_REF], 'UTF-8') >= 30) {
            $this->errors[self::TITRE_REF] = "Le titre doit faire moins de 30 caractères";
        } else if (mb_strlen($this->data[self::TITRE_REF], 'UTF-8') <= 3) {
            $this->errors[self::TITRE_REF] = "Le titre doit faire plus de 3 caractères";
        }

        if (!key_exists(self::TYPE_REF, $this->data) || $this->data[self::TYPE_REF] === "") {
            $this->errors[self::TYPE_REF] = "Vous devez choisir un type";

}
            if (!key_exists(self::CATEGORIE_REF, $this->data) || $this->data[self::CATEGORIE_REF] === "") {
                $this->errors[self::CATEGORIE_REF] = "Vous devez entrer une catégorie";
            } else if (mb_strlen($this->data[self::CATEGORIE_REF], 'UTF-8') >= 30) {
                $this->errors[self::CATEGORIE_REF] = "La catégorie doit faire moins de 30 caractères";
            } else if (mb_strlen($this->data[self::CATEGORIE_REF], 'UTF-8') <= 3) {
                $this->errors[self::CATEGORIE_REF] = "Le catégorie doit faire plus de 3 caractères";
            }


            if (!key_exists(self::RUE_REF, $this->data) || $this->data[self::RUE_REF] === "") {
                $this->errors[self::RUE_REF] = "Vous devez entrer une rue";
            } else if (mb_strlen($this->data[self::RUE_REF], 'UTF-8') >= 30) {
                $this->errors[self::RUE_REF] = "La rue doit faire moins de 30 caractères";
            } else if (mb_strlen($this->data[self::RUE_REF], 'UTF-8') <= 1) {
                $this->errors[self::RUE_REF] = "Le rue doit faire plus de 3 caractères";
            }

            if (!key_exists(self::VILLE_REF, $this->data) || $this->data[self::VILLE_REF] === "") {
                $this->errors[self::VILLE_REF] = "Vous devez entrer une ville";
            } else if (mb_strlen($this->data[self::VILLE_REF], 'UTF-8') >= 30) {
                $this->errors[self::VILLE_REF] = "La ville doit faire moins de 30 caractères";
            } else if (mb_strlen($this->data[self::VILLE_REF], 'UTF-8') <= 3) {
                $this->errors[self::VILLE_REF] = "Le ville doit faire plus de 3 caractères";
            }

            if (!key_exists(self::TYPE_REF, $this->data) || !in_array($this->data[self::TYPE_REF], self::TYPE_CHOICE)) {
                $this->errors[self::TYPE_REF] = "Vous devez entrer un type valide";
            }
           return count($this->errors) ==0  ;
    }

    public function getItem($name)
    {
        if (key_exists($name, $this->data)) {
            return $this->data[$name];
        }
    }


}


?>
