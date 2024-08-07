<?php

require_once "model/LocationCall.php";
require_once "model/Fiche.php";

class View
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
        $this->menu = [
            "." => " Accueil ",
            $this->routeur->getListePage() => "Liste",
        ];
        $this->menuConnexion = "<li id='inscription'><a href=" . $this->routeur->getInscriptionURL() . ">Inscription</a></li>
                              <li id='connexion'><a href=" . $this->routeur->getConnexionPage() . ">Connexion</a></li>";
    }

//squelette permettant d'afficher la page que l'on veut
    public function render()
    {
        include "squelette.php";
    }

//squelette permettant d'afficher la page login
    public function render2()
    {
        include "squeletteLogin.php";
    }

    public function render3(){
        include "squeletteInscription.php";
    }
////////////////////////////////////// Page d'accueil

    public function showAccueilPage()
    {
        if (key_exists("user", $_SESSION) && $_SESSION['user'] !== null) {
            $this->title = "Bienvenue " . $_SESSION['user']['statut'];
        } else {
            $this->title = 'Bienvenue';
        }

        $this->content = "<section class='Accueil'>";
        $this->content .= "<h1 id= 'titre_accueil'> A Voir A Faire </h1>";
        $this->content .= "<p id='text_accueil'> Le prochain musée ? La prochaine activité à sensations fortes ? Trouvez ce qu'il vous faut en renseignant votre destination dans la barre de recherche !</p>";
        $this->content .= "<div class='accueil_geocode'>";
        $this->renderGeocodeField();
        $this->content .= "</div>";

        $this->renderGeolocationButton();

        $this->content .= "</section>";
        $this->content.= "<section class='section_goals'>";
        $this->content .= "<h1> NOTRE MOTEUR DE RECERCHE </h1>";
        $this->content.= "<div class='Goals'>";
        $this->content .= "<div class = bloc>  <h2>RAPIDE</h2>  <p> C'est vraiment rapide ! Ma recherche s'est effectuée en quelques secondes, j'ai rapidemment trouvé une exposition sur Paris comme je le souhaitait !! - T.BERNARD </p> </div>";
        $this->content .= "<div class = bloc>  <h2>PERTINENT</h2>  <p> Je cherchais des activités centrées autour du bilboquet, j'ai trouvé ! Merci ! - H.GABIN </p> </div>";
        $this->content .= "<div class = bloc>  <h2>EFFICACE</h2>  <p> Grace à cette plateforme, j'ai pu enmener ma famille à Mickeyland Paris, les enfants étaient heureux comme tout ! Merci à vous, c'est un séjour réussi ! - J.DUJARDIN </p> </div>";
        $this->content .= "</div>";
        $this->content .= "</section>";


        $this->content .= "</section>";
        $this->content.= "<section class='section_explore'>";
        $this->content .= "<h1> DECOUVREZ NOS ANNONCES FAVORITES DU JOUR </h1>";
        $this->content.= "<div class='Explore'>";
        $this->content .= "<div class = bloc_image> <img src='images/1.jpg'> <p> Chateau du dauphin-duc de bourgogne </p>  </div>";
        $this->content .= "<div class = bloc_image> <img src='images/2.jpg'>  <p> Le lac St-Guillaume de Wolshteim </p> </div>";
        $this->content .= "<div class = bloc_image> <img src='images/3.jpg'>  <p> Initiation au Badminton - Paris 12  </p> </div>";
        $this->content.= "</div>";
        $this->content .= "</section>";
        $this->render();

    }

    public function renderMapDiv()
    {
        $this->content .= "
      <div id='map'>
      </div>
      ";
    } // Enf fct renderLocationDiv

    public function renderGeocodeField()
    { // barre de recherche
        $this->content .= "
        <form method=\"GET\" action=" . $this->routeur->getListeLocationURL() . ">
          <div class='GeocodeInputDiv'>
            <input type='text' name='geocodeInput' class='geocodeInput' placeholder='Lieu...'/>
          </div>
        </form>
      ";
    } // End renderGeocodeField()

    public function renderGeolocationButton()
    {
        $this->content .= "
        <div id='geolocationDiv'>
          <a id='geolocationButton' href={$this->routeur->getGeolocationURL()}> ME LOCALISER </a>
        </div>


      ";
    }

    public function cleanUserInput($input)
    {
        $clean_input = trim($input);
        $clean_input = stripslashes($clean_input);
        $clean_input = htmlspecialchars($clean_input);
        return $clean_input;
    }

    public function urlCheck($input)
    {
        if (key_exists($input, $_GET) && trim($_GET[$input]) != '') {
            return 0;
        } else if (empty($_GET[$input])) {
            return 1;
        } else {
            return 2;
        }
    } // End urlCheck()


///////////////////////////affichage info

    public function makeListPage($tabFiches, $imageStorage)
    {
        $LocationCall = new LocationCall();
        $this->title = "Liste des fiches";
        $this->content .= "<div class='liste_geocode'>";
        $this->renderGeocodeField();
        $this->content .= "
      <form method='post' action=''>
    <div id='checkboxDiv'>
      <input id = 'checkboxLieux' type='checkbox' class='checkbox' name='Lieux' value='Lieu' onChange='this.form.submit()' >
      <label for='checkboxLieux'>Lieux</label>
    </div>

    <div id='checkboxDiv'>
      <input id = 'checkboxActivités' type='checkbox' class='checkbox' name='Activités' value='Activitée' onChange='this.form.submit()'>
      <label for='checkboxActivités'>Activités</label>
    </div>
    </form>";
        $this->content .=
            "<section class='tri'> <form action='' method='post'>
        <select name='tri' id='tri' >
        <option value = '' > Trier par :  </option >
        <option value = 'ville_ASC' > Ville Croissant </option >
        <option value = 'ville_DESC' > Ville Decroissant </option >
        <option value = 'tarification_ASC' > Prix Croissant </option >
        <option value = 'tarification_DESC' > Prix Decroissant</option >
        <option value = 'type_ASC' > type Croissant</option >
        <option value = 'type_DESC' > type Decroissant</option >



        </select >
        <input id='tri_button' type='submit' name='submit' value = 'trier'>
        <form/>
        </section>";

        $this->content .= "</div>";

        if ($this->urlCheck('geocodeInput') == 0 || (key_exists("action",$_GET) && $_GET["action"]=="geolocation") ) {
            echo "
          <script src='js/map.js'> </script>
          <script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDFuNgEHVHoKsJOaNVhYEFVLIWecfBLhfg&callback=initMap&libraries=&v=weekly&channel=2' type='text/javascript'></script>
          ";
            $this->renderMapDiv();
        }





        $this->content .= "<ul id='grille'>";
        foreach ($tabFiches as $key => $fiches) {
            $existeUneImage = $imageStorage->readFirstWithIdFiche($fiches->getId());
            $this->content .= "<div class='box_fiches'>";
            $this->content .= "<img class='box_img' src=" . (($existeUneImage === null) ? 'images/Perso.png' : $existeUneImage["img"]) . ">";
            $this->content .="<div class='description_fiche'>".
                "<li><a href=\"" .
                $this->routeur->getFicheURL($fiches->getId()) .
                "\">" . $fiches->getTitre() .
                "</a></li>";
            $this->content.= "<p> Description : ". $fiches->getDescription() ."</p>";
            $this->content .= "</div>";
            $this->content .= "</div>";
        }
        $this->content .= "</ul>";
        $this->render();
    }

    protected function displayFeedback()
    {
        if ($this->feedback) {
            return "<div class = 'feedback'> $this->feedback </div>";
        }
    }

    public function makeFichePage($fiche, $id, $listeComm, $images)

    {
        $this->content="";
        $this->title = $fiche->getTitre();
        $this->content ="<div class='fiche_details'>";
        $this->content .= " <br>";
        if(key_exists("user",$_SESSION) && $_SESSION["user"]!== null){
            $this->content .= "<form action=\"" . $this->routeur->getFicheAskModificationURL($fiche->getId()) . "\" method=\"POST\"><button id='buttonmodifierfiche'>Modifier la fiche " . $fiche->getTitre() . "</button></form>";
          }

        $this->content .=
            " <h1> " . $fiche->getTitre() . "</h1> <br>
                <article id='objet'>
                <section class='txt'>
                    <p>Type (Lieu ou Activité) : " . $fiche->getType() . "</p>
                    <p> Categorie : ". $fiche->getCategorie()."</p>
                    <p> Description : " . $fiche->getDescription() . "</p>
                    <p>Adresse : " . $fiche->getRue() . ", " . $fiche->getVille() . ", " . $fiche->getCodePostal() . "</p>";


        if ($fiche->getTarification() != null) {
            $this->content .= "<p> Tarification : " . $fiche->getTarification() . " € </p>";
        }
        if ($fiche->getHoraire() != null) {
            $this->content .= "<p> Horaires : " . $fiche->getHoraire() . " </p>";
        }
        if ($fiche->getAgeMinimum() != null) {
            $this->content .= "<p> Age minumum : " . $fiche->getAgeMinimum() . " </p>";
        }

        $this->content .= "</section>";
        if ($images != NULL) {
            $this->content .=
                "<section><div class='diapo'><div class='elements'>";

            //images
            foreach ($images as $key => $value) {
                $this->content .= "<div class='" . (($key > 1) ? 'element' : 'element active') . "'>
                              <img src='" . $value['img'] . "'>
                          </div>";
            }
            $this->content .= "</div>";
            if (sizeof($images) > 1) {
                $this->content .= "<span class='fleche' id='nav-gauche' >←</span>
                                   <span class='fleche' id='nav-droite'>→</span></div></section>";
            }
        }
        $this->content .="</article></div>";





        $this->content .= "<br>";
        $this->content .= "<div class='espace_commentaire'>";
        $this->content .= "<h1> ESPACE COMMENTAIRE</h1>";

        if ($listeComm != null) {

            $this->content .= "<section id='comm_esp'>";
            foreach ($listeComm as $key => $value) {

                $this->content .= "<h3>Utilisateur : " . $value->getUser();
                $this->content .= "</h3><p>" . $value->getComm() . "</p>";

            }
            $this->content .= "</section>";
        } else {
            $this->content .= "<p id='fiche_p'>Il n'y a pas encore de commentaires.</p>";
        }
        $this->content.= "<div id='commentaire'>";
        if (key_exists('user', $_SESSION) && $_SESSION['user'] != null) {
            $this->content .= "<h3>Ajouter un commentaire</h3><br> <form action=" . $this->routeur->getSaveCommURL($fiche->getId()) .
                " method=\"POST\" > <textarea cols='50' rows='5' name='comm'></textarea><br><br> <input id='input_commentaire' type=\"submit\" name=\"bouton\" value='Poster'> </form> <br>";
        }
        //pour le diapo d'images
        $this->content .= "</div>";
        $this->content .= "<script src='js/diapo.js'></script>";
        $this->render();

    }


    /////////////////////////////////////////////// Comptes

    public
    function makeInscriptionPage()
    {
        $this->title = "Page de creation de compte";
        $this->content = "<div class= 'inscription_page'>";
        $this->content .=
            "<h1 id='Titre'>Inscription</h1><br>
      <form action=" . $this->routeur->getSaveInscriptionURL() ." method=\"POST\" >
      <div id='fields'>
      <div id='nom'>
      <input type=\"text\" name=\"nom\" placeholder='Nom'/><br>
      </div>
      <div id='prenom'>
      <input type=\"text\" name=\"prenom\" placeholder='Prenom'/><br>
      </div>
      <div id='pseudo'>
      <span>*</span> <input type=\"text\" name=\"pseudo\" placeholder='Pseudo'/><br>
      </div>
      <div id='password'
      <span>*</span> <input type=\"password\"  name=\"password\" placeholder='Password'/><br>
      </div>
      <span> <p> * : Champs Obligatoires </p></span>

      </div>
        <input id='signup-button' type=\"submit\" name=\"bouton\" value='Inscription'>

      <div id='toConnexion'><a href='{$this->routeur->getConnexionPage()}'> Vous avez déjà un compte ?</a></div>

      </form> <br>";
        $this->content .= "</div>";

        $this->render3();
    }

    public
    function makeConnexionPage()
    {
        $this->title = "Page de connexion";
        $this->content = "
      <div id='PageDeConnexion'>
        <div id='Titre'>
         Hi!
        </div>

        <div id='form_div'>
          <form action='.?action=co' method='post'>
            <div id='fields'>
              <div id='Username'>
                <input type='text' name='login' id='user_input' placeholder='Pseudo'  required/>
              </div>
              <div id='Password'>
                <input type='password' name='password' id='pass_input' placeholder='Mot de passe'  required/>
              </div>
            </div>
            <input type='submit' id='signin-button' value='Connexion'>
          </form>
          <div id='toInscription'><a href='{$this->routeur->getInscriptionURL()}'> Vous n'avez pas de compte ?</a></div>
        </div>

      </div>
              <p> Repartons pour de nouvelles aventures !</p>

      ";
        if (!empty($_POST)) {
            console . log("FORM SENT");
            $username = $_POST["username"]; // récupération de l'email du form html
            $passwd = $_POST["password"]; // récupération du mot de passe du form html
            $this->code->authentication(
                $this->cleanUserInput($username),
                $this->cleanUserInput($passwd)
            );
        }
        $this->render2();
    } // End fct makeConnexionPage();


    public function displayConnexionSuccess()
    {
        $this->routeur->POSTredirect(".", "Succès de la connexion.");
    }


    //page de debug
    public function makeDebugPage($variable)
    {
        $this->title = "Debug";
        $this->content =
            "<pre>" . htmlspecialchars(var_export($variable, true)) . "</pre>";
        $this->render();
    }

    public
    function displayCreationFail()
    {
        $this->routeur->POSTredirect(
            $this->routeur->getCreateUserURL(),
            "Une erreur est survenue lors de la création de votre compte."
        );
    }

    public
    function displayFicheCreationFailure($cause)
    {
        $this->routeur->POSTredirect(
            $this->routeur->getCreationFichePage(),
            "La fiche soumise ne peut être crée, des informations sont incomplêtes/invalides a cause de " . $cause
        );
    }

    public
    function dispalyFicheDeleteSucces()
    {
        $this->routeur->POSTredirect($this->routeur->getAccueilURL(),
            "la fiche a ete suprimé"
        );
    }

    public
    function displayCreationSuccess()
    {
        $this->routeur->POSTredirect(
            $this->routeur->getAccueilURL(),
            "Votre compte a bien été créé, vous etes connécté"
        );
    }

    public
    function displayConnexionFailure()
    {
        $this->routeur->POSTredirect(
            $this->routeur->getConnexionPage(),
            "Votre login/mot de passe est invalide"
        );
    }

    public
    function displayAccountCreationFailure()
    {
        $this->routeur->POSTredirect(
            $this->routeur->getInscriptionURL(),
            "Données transmises non valides."
        );
    }

    public
    function displayModifySucess($id)
    {
        $this->routeur->POSTredirect(
            $this->routeur->getEnAttentePage(),
            "Données transmises non valides."
        );
    }

    public
    function displayInscriptionSucces()
    {
        $this->routeur->POSTredirect(
            $this->routeur->getAccueilURL(),
            "Succès de l'inscription."
        );
    }

    public
    function makeUnknownFichePage($data = null)
    {
        $this->title = "page introuvable";
        $this->content = "<h1> ERROR 404 : $data</h1>";
        $this->render();
    }

    public function makeVerificationPage()
    {
        $this->title = "Verification des annonces";
        $this->content = "";
        $this->render();
    }


}

?>
