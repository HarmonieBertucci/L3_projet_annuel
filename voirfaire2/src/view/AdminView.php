<?php

class AdminView extends ViewConnecte
{
    //protected Account $account;
    protected $menu;
    protected $routeur;
    protected $feedback;
    public function __construct( $router, $feedback)
    {
        parent::__construct($router, $feedback);
        $this->menu = [
            "." => " Accueil ",
            $this->routeur->getListePage() => "Liste",
            $this->routeur->getCreationFichePage() => "Créer une fiche",
            $this->routeur->getEnAttentePage() => "Fiche en attente de verification",
        ];
    }


    public function makeWaitListPage($liste,$imageEnAttenteStorage){
      $this->title = "Liste des fiches en attente ";
      foreach ($liste as $key => $fiches) {
      $existeUneImage = $imageEnAttenteStorage->readFirstWithIdFiche($fiches->getId());
      $this->content .= "<div class='box_fiches_attente'>";
      $this->content .= "<img class='box_img' src=" . (($existeUneImage === null) ? 'images/Perso.png' : $existeUneImage["img"]) . ">";
      $this->content .=
      "<li><a href=\"" .
      $this->routeur->getWaitURL($fiches->getId()) .
      "\">" .
      $fiches->getId() . " : " . $fiches->getTitre() .
      "</a></li>";
      $this->content .= "</div>";
      }
      $this->content .= "</ul>";
      $this->render();
    }

  public function makeWaitPage($fiche, $id, $listeImages,$action){
    $this->title = $fiche->getTitre();
    $this->content = "<div class='wait_page'>";
    $this->content .= "<h1 id='titre_wait_page'> Proposition de ".$action. "</h1>" ;
    $this->content .= "<div class='buttons'>";
    $this->content .= "
      <form action=\"" . $this->routeur->getWaitDeleteURL($fiche->getId()) . "\" method=\"POST\"><button id='button_refuser'>Refuser la fiche " . $fiche->getTitre() . "</button></form>";
    $this->content .= "
      <form action=\"" . $this->routeur->getModifierFicheWaitURL($fiche->getId()) . "\" method=\"POST\"><button id='button_modifier'>Modifier la fiche " . $fiche->getTitre() . "</button></form>";
      $this->content .= "
        <form action=\"" . $this->routeur->getValiderFicheWaitURL($fiche->getId()) . "\" method=\"POST\"><button id='button_valider'>Valider la fiche " . $fiche->getTitre() . "</button></form>";
      $this->content .= "</div>";


      $this->content .=
          "<article id='objet'>
            <section class='txt'>
                <h1> " . $fiche->getTitre() . "</h1> <br>
                <p>Type (Lieu ou Activité) : " . $fiche->getType() . "</p>
                <p> Categorie : ". $fiche->getCategorie()."</p>
                <p> Description : " . $fiche->getDescription() . "</p>
                <p>Adresse : ". $fiche->getRue() . ", ". $fiche->getVille() . ", " .$fiche->getCodePostal() . "</p>";

    if($fiche->getTarification() != null){
      $this->content .="<p> Tarification : " . $fiche->getTarification() . " € </p>";
    }
    if($fiche->getHoraire() != null){
      $this->content .="<p> Horaires : " . $fiche->getHoraire() . " </p>";
    }
    if($fiche->getAgeMinimum() != null){
      $this->content .="<p> Age minumum : " . $fiche->getAgeMinimum() . " </p>";
    }

    $this->content .= "</section> </article><br>";
    if ($listeImages != NULL) {  //images
      $this->content.="<section id='tableauImages'>";
        foreach ($listeImages as $key => $value) {
            $this->content .= "<section class='inline'>
                                <img src='" . $value['img'] . "'>
                                <form action=\"" . $this->routeur->getImageEnAttenteSuppressionURL($id,$value['id']) . "\" method=\"POST\"><button>Supprimer l'image</button></form>
                              </section>";
        }
      $this->content .= "</section>";
    }
    $this->content.="</div>";
    $this->content .= "<br>";
    //pour les images

      $this->content .= "</div>";

      $this->render();
    }


    public function makeDeconnexionPage()
    {
        $this->title = 'Deconnexion';
        $this->content = "<section id=\"deconnect\">Voulez vous vraiment vous déconnecter  ? <br> <form action=\"" . $this->routeur->getDeconnexionURL() . "\" method=\"POST\"><button>Oui</button></form>
                                                                            <form action=\".\" method=\"POST\"><button>Non</button></form></section>";
        $this->render();
    }

    public function displayDeconnexionSucces()
    {
        $this->routeur->POSTredirect(".", "Vous êtes bien deconnecté.");
    }

    public function displayRefusSucces()
    {
        $this->routeur->POSTredirect(".", "La proposition de fiche a bien ete refusée.");
    }

    public function displayValidationFicheSucces()
    {
        $this->routeur->POSTredirect($this->routeur->getEnAttentePage(), "Fiche bien validé et disponible pour tous.");
    }





}
