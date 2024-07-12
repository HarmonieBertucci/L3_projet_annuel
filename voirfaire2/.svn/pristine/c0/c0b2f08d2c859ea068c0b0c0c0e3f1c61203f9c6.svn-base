<?php

// Inclusion des classes utilisées dans ce fichier
require_once("view/View.php");
require_once("view/ViewConnecte.php");
require_once("view/AdminView.php");
//require_once("view/ViewConnecte.php");

require_once("control/Controller.php");

// Le routeur nous permet de gérer les requêtes http de l'utilisateur
class Router
{


    //méthode principale de routeur
    public function main($pdo)
    {

        // Démarre une nouvelle session ou reprend une session existante
        /*  session_set_cookie_params(["samesite" => "Strict"]);
          session_name("voirfaire"); // changement du nom de cookie de session*/
        session_start();

        $feedback = key_exists('feedback', $_SESSION) ? $_SESSION['feedback'] : '';
        $_SESSION['feedback'] = '';


        //session_destroy();

        $vue = new View($this, $feedback);
        if (!key_exists('feedback', $_SESSION)) {
            $_SESSION['feedback'] = "";
        }

        if (key_exists("user", $_SESSION) && $_SESSION["user"]!==null ) {
            //var_dump($_SESSION);
            if ($_SESSION['user']['statut'] === "user") {
                $vue = new ViewConnecte($this, $feedback);
            } else if ($_SESSION['user']['statut'] === "admin") {
                $vue = new AdminView($this, $feedback);
            }
        } else {
            $vue = new View($this, $feedback);
        }



        //création du controlleur en lui donnant accès a la vue
        $controlleur = new Controller($vue, $pdo);

        $method = $_SERVER['REQUEST_METHOD'];


        if (key_exists("id", $_GET)) {
            $controlleur->showInformation($_GET["id"]);

        } else if (key_exists("liste", $_GET) ||  key_exists("geocodeInput", $_GET )) {
            if (key_exists("tri", $_POST)) {
                $controlleur->showListePage(null,$method,$_POST["tri"]);
               /* switch ($_POST["tri"]) {

                    case 'ville_ASC':
                        $controlleur->showListePage($_GET['s'], $method, ["ville", ""]);
                        break;
                    case 'ville_DESC':
                        $controlleur->showListePage($_GET['s'], $method, ["ville", "DESC"]);
                        break;
                    case 'tarification':
                        $controlleur->showListePage($_GET['s'], $method, ["tarification", ""]);
                        break;
                    case 'codePostal':
                        $controlleur->showListePage($_GET['s'], $method, ["codePostal", ""]);
                        break;
                    case 'titre':
                        $controlleur->showListePage($_GET['s'], $method, ["titre", ""]);
                        break;
                    default:
                        $controlleur->showListePage($_GET['s'], $method);
                        break;
                }*/


            }
            else if (key_exists("Lieux",$_POST) ){
                var_dump($_POST);

                $controlleur->showListePage(null, $method,null,$_POST["Lieux"]);
                echo "
                <script>
                let checkbox = document.getElementById('checkboxLieux')
                checkbox.checked = true;
                </script>
                ";
            }
            else if(key_exists("Activités",$_POST)){
                $controlleur->showListePage(null, $method,null,$_POST["Activités"]);
                echo "
                <script>
                let checkbox = document.getElementById('checkboxActivités')
                checkbox.checked = true;
                </script>
                ";
            }
            else if(key_exists("geocodeInput",$_GET)) {
                $controlleur->showListePage($_GET['geocodeInput'], $method);
              }
            else {
              $controlleur->showListePage();
            }

        } else if (key_exists("deleteFiche", $_GET)) {
            $controlleur->deleteFiche($_GET["deleteFiche"]);

        } else if (key_exists("modificationPage", $_GET)) {
            $controlleur->makeModificationPage($_GET["modificationPage"]);

        } else if (key_exists('modifierFicheWait', $_GET) && key_exists('idWait', $_GET)) {
            if(key_exists("user",$_SESSION) && $_SESSION["user"]['statut']==='admin'){
              $controlleur->modifierFicheWait($_GET["idWait"]);
            } else {
              $this->POSTredirect($this->getAccueilURL(),"vous n'avez pas le droit de faire cela");
            }


        } else if (key_exists("saveComm", $_GET)) {
            $controlleur->saveComm($_POST, $_GET["saveComm"]);

        }
        else if (key_exists("action", $_GET)) {
            switch ($_GET["action"]) {

                case 'connexion':
                    $controlleur->showConnexionPage();
                    break;
                case 'co':
                    $controlleur->connexion($_POST);
                    break;
                case 'geolocation':
                    $controlleur->geolocationFct();
                    break;
                case 'deconnexion':
                    $controlleur->showDeconnexionPage();
                    break;
                case 'deco':
                    $controlleur->deconnexion();
                    break;
                case 'create':
                    $controlleur->showCreationPage();
                    break;
                case 'saveCreation':
                    $data = array('id' => null, 'titre' => null, 'type' => null, 'categorie' => null, 'rue' => null, 'ville' => null, 'codePostal' => null, 'latitude' => 0.0000000000, 'longitude' => 0.0000000000, 'description' => null, 'tarification' => 'test', 'horaire' => null, 'ageMinimum' => null, 'notation' => null, 'commentaire' => null,
                        'image' => null, 'pseudo_proprio' => $_SESSION["user"]);
                    $images = null;

                    if (key_exists("titre", $_POST)) {
                        $data["titre"] = $_POST["titre"];
                    }
                    if (key_exists("categorie", $_POST)) {
                        $data["categorie"] = $_POST["categorie"];
                    }
                    if (key_exists("type", $_POST)) {
                        $data["type"] = $_POST["type"];
                    }
                    if (key_exists("description", $_POST)) {
                        $data['description'] = $_POST["description"];
                    }
                    if (key_exists("rue", $_POST)) {
                        $data["rue"] = $_POST["rue"];
                    }
                    if (key_exists("ville", $_POST)) {
                        $data["ville"] = $_POST["ville"];
                    }
                    if (key_exists("codePostal", $_POST)) {
                        $data["codePostal"] = $_POST["codePostal"];
                    }
                    if (key_exists("tarification", $_POST)) {
                        $data["tarification"] = $_POST["tarification"];
                    }
                    if (key_exists("horaires", $_POST)) {
                        $data["horaire"] = $_POST["horaires"];
                    }
                    if (key_exists("ageMinimum", $_POST)) {
                        $data["ageMinimum"] = $_POST["ageMinimum"];
                    }
                    if (key_exists("image", $_FILES) && $_FILES["image"]['error'][0] != 4) {

                        $images = $_FILES["image"];
                    }

                    $controlleur->saveCreation($data, $images);
                    break;


                case 'inscription':
                    $controlleur->inscription();
                    break;
                case 'saveInscription':
                    if (key_exists("nom", $_POST) && key_exists("prenom", $_POST) && key_exists("pseudo", $_POST) && key_exists("password", $_POST)) {
                        $controlleur->saveInscription($_POST["nom"], $_POST["prenom"], $_POST["pseudo"], $_POST["password"]);
                    } else {
                        $controlleur->inscription();
                    }
                    break;
                case 'create_user':
                    $controlleur->createUser($method, $_POST);
                      break;

                case 'search' :
                    $controlleur->showListePage($method, $_GET);
                    break;

                case 'saveModify':
                    $controlleur->saveModify($_GET["idModify"],$_POST);
                    break;

                case 'valid' :
                    if(key_exists("user",$_SESSION) && $_SESSION["user"]['statut']==='admin'){
                        $controlleur->ValidWait($_GET["idValid"]);
                    } else {
                      $this->POSTredirect($this->getAccueilURL(),"vous n'avez pas le droit de faire cela");
                    }

                    break;

                default:
                    $vue->showAccueilPage();
                    break;
            }
        } else if (key_exists("enAttenteList", $_GET)) {
            $controlleur->showWaitList();
        } else if (key_exists("idWait", $_GET)) {

            $controlleur->showInformationWait($_GET["idWait"]);
        } else if (key_exists("deleteWait", $_GET)) {
            if(key_exists("user",$_SESSION) && $_SESSION["user"]['statut']==='admin'){
              $controlleur->deleteWait($_GET["deleteWait"]);
            } else {
              $this->POSTredirect($this->getAccueilURL(),"vous n'avez pas le droit de faire cela");
            }

        } else if (key_exists("supprimerImage", $_GET)&&key_exists("fiche", $_GET)) {
            if(key_exists("user",$_SESSION) && $_SESSION["user"]['statut']==='admin'){
              $controlleur->deleteImage($_GET["supprimerImage"],$_GET["fiche"]);
            } else {
              $this->POSTredirect($this->getAccueilURL(),"vous n'avez pas le droit de faire cela");
            }

        } else {
            $vue->showAccueilPage();
        }


    }

    public function POSTredirect($url, $feedback)
    {
        $_SESSION['feedback'] = $feedback;
        header("Location: " . $url, true, 303);
        exit();

    }

    public function getAccueilURL()
    {
        return "?action=accueil";
    }


    public function getConnexionPage()
    {
        return ".?action=connexion";
    }

    public function getDeconnexionPage()
    {
        return ".?action=deconnexion";
    }

    public function getListePage($value = null)
    {
        return ".?liste&sortBy={$value}";
    }

    public function getFicheURL($id)
    {
        return ".?id=" . $id;
    }

    public function getCreationFichePage()
    {
        return ".?action=create";
    }

    public function getFicheSaveURL()
    {
        return ".?action=saveCreation";
    }

    public function getGeolocationURL(){
        return ".?action=geolocation";
    }

    public function getDeconnexionURL()
    {
        return ".?action=deco";
    }

    public function getInscriptionURL()
    {
        return ".?action=inscription";
    }

    public function getSaveInscriptionURL()
    {
        return ".?action=saveInscription";
    }

    public function getCreateUserURL()
    {
        return "?action=create_user";
    }

    public function getFicheAskDeletionURL($id)
    {
        return "?deleteFiche=$id";
    }

    public function getFicheAskModificationURL($id){
      return "?modificationPage=$id";
    }
    public function getSaveCommURL($idAnnonce)
    {
        return "?saveComm=$idAnnonce";
    }

    public function getListeLocationURL()
    {
        return "?listeLocation=";
    }




/////////////////////////////// partie admin
    public function getEnAttentePage()
    {
        return "?enAttenteList";
    }

    public function getWaitURL($id)
    {
        return ".?idWait=$id";
    }

    public function getModifierFicheWaitURL($id)
    {
      return "?modifierFicheWait&idWait=$id";
    }

    public function getSaveModifyURL($id){
      return "?action=saveModify&idModify=$id";
    }

    public function getValiderFicheWaitURL($id){
      return "?action=valid&idValid=$id";
    }
    public function getWaitDeleteURL($id){
      return "?deleteWait=$id";
    }

    public function getImageEnAttenteSuppressionURL($idFiche,$idImage){
      return "?supprimerImage=$idImage&fiche=$idFiche";
    }
}

?>
