<?php


require_once("model/LocationCall.php");
require_once("model/Fiche.php");

class ViewConnecte extends View
{
    protected $title;
    protected $menu;
    protected $menuConnexion;
    protected $content;
    protected $routeur;
    protected $feedback;


    public function __construct($routeur, $feedback)
    {
        $this->routeur = $routeur;
        $this->feedback = $feedback;
        $this->menu = array("." => " Accueil",
            $this->routeur->getListePage() => "Liste",
            $this->routeur->getCreationFichePage() => "Créer une fiche");

        $this->menuConnexion="<li id='deconnection'><a href=".$this->routeur->getDeconnexionPage().">Déconnection</a></li>";


    }
    //squelette permettant d'afficher la page login

    public function makeDeconnexionPage()
    {
        $this->title = 'Deconnexion';
        $this->content = "<section id=\"deconnect\">Voulez vous vraiment vous déconnecter  ? <br> 
                           <form action=\"" . $this->routeur->getDeconnexionURL() . "\" method=\"POST\">
                           <button id='button_oui'>Oui</button></form>
                           <form action=\".\" method=\"POST\">
                           <button id='button_non'>Non</button></form>
                           </section>";
        $this->render();
    }

    public function displayDeconnexionSucces()
    {
        $this->routeur->POSTredirect(".", "Vous êtes bien deconnecté.");
    }

    public function makeCreationPage(FicheBuilder $ficheBuilder)
    {
        $this->title = "Création d'une fiche de lieu/annonce";
        if ($ficheBuilder->getErrors()) {
            $this->content = "Il y a des erreurs dans le formulaire :";
            $this->content .= " < ul>";
            foreach ($ficheBuilder->getErrors() as $error) {
                $this->content .= " <li>{$error}</li > ";
            }
            $this->content .= "</ul > ";
        }
        $this->content .= "
        <section id='create'>

        <form class= 'form_create'enctype=\"multipart/form-data\" action=\"" . $this->routeur->getFicheSaveURL() . "\" method='POST' >
        <h1 id='titreCreation' class='gradientOnText'> Creez votre annonce </h1 >

        <div id='organized_form'>

        <span class='obligation'>*</span>  <p>Nom : </p>                   <input type='text' name='titre' required>

        <span class='obligation'>*</span> <p>Type d'annonce : </p>
        <select name = '" . FicheBuilder::TYPE_REF . "' > ";
        foreach (FicheBuilder::TYPE_CHOICE as $option) {
          $selected = $ficheBuilder->getItem("type") == $option ? "selected" : '';
          $this->content .= " <option {$selected} value = '{$option}' >{$option}</option > ";
        };
        $this->content .= "</select>";
        $this->content .= "

        <span class='obligation'>*</span>  <p>Catégorie : </p>             <input type='text' name='categorie'  required>
        <span class='obligation'>*</span>  <p>Description : </p>           <textarea cols='50' rows='5' name='description'> </textarea>
        <span class='obligation'>*</span>  <p>Rue : </p>                   <input type='text' name='rue' required>
        <span class='obligation'>*</span>  <p>Code Postal : </p>           <input type='text' name='codePostal' required>
        <span class='obligation'>*</span>  <p>Ville : </p>                 <input type='text' name='ville' required>
        <span class='obligation'></span>   <p>Tarification (en €): </p>    <input type='text' name='tarification'>
        <span class='obligation'></span>   <p>Horaires : </p>              <input type='text' name='horaires'>
        <span class='obligation'></span>   <p>Age minimal : </p>           <input type='text' name='ageMinimum'>
        <span class='obligation'></span>   <p>Ajoutez une image : </p>     <input type='file' name='image[]' multiple='multiple'>
        </div>

        <p class='obligation'> * : Champs Obligatoires </p>
        <input type='submit' id='boutonCreation' name='bouton' value='Envoyer'>
        </form>

        </section>";
        $this->render();
    }

    public function makeModificationPage($fiche){
      $this->title = "Mofification d'une fiche de lieu/annonce";

      $this->content .= "
      <section id='create'>

      <form enctype=\"multipart/form-data\" action=\"" . $this->routeur->getSaveModifyURL($fiche->getId()) . "\" method='POST' >
      <div class='modification_Page'>
      <h1 id='titreModification' class='gradientOnText'>Modification d'une fiche</h1 >

      <div id='organized_form'>
        
      <p class='obligation'>*</p>  <p>Nom : </p>                   <input type='text' name='titre' value=".$fiche->getTitre()." required>

      <p class='obligation'>*</p> <p>Type d'annonce : </p>
      <select name = '" . FicheBuilder::TYPE_REF . "' > ";
      foreach (FicheBuilder::TYPE_CHOICE as $option) {
        $selected = $fiche->getType() == $option ? "selected" : '';
        $this->content .= " <option {$selected} value = '{$option}' >{$option}</option > ";
      };

      $this->content .= "
      </select>
      <span class='obligation'>*</span>  <p>Catégorie : </p>             <input type='text' name='categorie' value=".$fiche->getCategorie()."  maxlength = '35' required>
      <span class='obligation'>*</span>  <p>Description : </p>           <textarea cols='50' rows='5' name='description' >".$fiche->getDescription()." </textarea>
      <span class='obligation'>*</span>  <p>Rue : </p>                   <input type='text' name='rue' value='{$fiche->getRue()}' maxlength = '35'required>
      <span class='obligation'>*</span>  <p>Code Postal : </p>           <input type='text' name='codePostal' value='{$fiche->getCodePostal()}'  maxlength = '35' required>
      <span class='obligation'>*</span>  <p>Ville : </p>                 <input type='text' name='ville' value='{$fiche->getVille()}'  maxlength = '35' required>
      <span class='obligation'></span>   <p>Tarification (en €): </p>    <input type='text' name='tarification' value='{$fiche->getTarification()}'>
      <span class='obligation'></span>   <p>Horaires : </p>              <input type='text' name='horaires' value='{$fiche->getHoraire()}'>
      <span class='obligation'></span>   <p>Age minimal : </p>           <input type='text' name='ageMinimum' value='{$fiche->getAgeMinimum()}'>
      <span class='obligation'></span>   <p>Ajoutez une image : </p>     <input id='input_image' type='file' name='image[]' multiple='multiple'>
      </div>

      <p class='obligation'> * : Champs Obligatoires </p>
      <input type='submit' id='boutonModification' name='bouton' value='Envoyer'>

      </div>
      </form>

      </section>";
      $this->render();

    }
    public function displayFicheModifyFailure($cause){

      $this->routeur->POSTredirect($this->routeur->getAccueilURL(), "La modification a echoué a cause de {$cause}, veuillez recommencer");
    }

    public function displayModifySucessFicheSucces(){
      $message = "la modification a ete enregistré";
      if($_SESSION['user']['statut'] !== "admin"){
        $message.=", elle sera appliqué lorsqu'un administrateur l'aura validé";
      }
      $this->routeur->POSTredirect($this->routeur->getAccueilURL(),$message);
    }
    public function displayCreationFicheSucces()
    {
        $this->routeur->POSTredirect($this->routeur->getAccueilURL(), "Fiche bien créée, elle est en attente de la validation par un admin");

    }
}

?>
