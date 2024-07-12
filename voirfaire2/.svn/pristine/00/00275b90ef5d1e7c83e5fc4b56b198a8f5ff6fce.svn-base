<?php


class LocationCall{
  public function __construct(){
  }

  public function getUserCoordinates($coordonneeAnnonces){ // apelle le JS mais la fct JS à changer pour la faire en php
    $JsonFiches= json_encode($coordonneeAnnonces);
    $ip = $_SERVER['REMOTE_ADDR'];
    $ip = '194.199.104.46';
    $api_url_geolocation = 'http://ip-api.com/json/'. $ip;
    echo "
    <script>
    function callbackAPIGeoloc() {
      if (request_geoloc.status === 200) {
        let data = JSON.parse(request_geoloc.responseText);
        let lat = data.lat;
        let lng = data.lon;
        getUserCity(lat, lng, $JsonFiches);
      }
    }
    let request_geoloc = new XMLHttpRequest();
    request_geoloc.open('GET', '$api_url_geolocation');
    request_geoloc.onload = callbackAPIGeoloc;
    request_geoloc.send();
    </script>
    ";
  } // End getUserCoordinates()

  public function getUserGeocode($geocodeInput,$coordonneeAnnonces){ // pour afficher les annonces sur la map comme d'hab
      $api_url_geocode = 'https://api.opencagedata.com/geocode/v1/json?key=45d26994dcc44112a048289356be3a5b&q=' . $geocodeInput;
      $JsonFiches= json_encode($coordonneeAnnonces);

      echo "
      <script>
      function callbackAPIGeocode(){
        if(request_geocode.status === 200){
          let data = JSON.parse(request_geocode.responseText);
          let lat = data.results[0]['geometry']['lat'];
          let lng = data.results[0]['geometry']['lng'];
          let type = data.results[0]['components']['_type'];
          let municipality = data.results[0]['components']['municipality'];
          let city = data.results[0]['components']['city'];
          let town = data.results[0]['components']['town'];
          let village = data.results[0]['components']['village'];
          let commune;
          if(type === 'city'){
            if(city === municipality){
              commune = city;
            }
            if(city !== municipality){
              commune = town;
            }
          }
          else if(type === 'village'){
            commune = village;
          }
          else if(type === 'road' || type === 'building'){
            commune = city;
          }
          else if(type === 'state' || type === 'country'){
            console.log('Erreur');
          }
          console.log(type + ', ' + commune + ', ' + lat + ', ' + lng);
          initMap(lat, lng, commune,$JsonFiches);
        }
        else if (request_geocode.status <= 500){
          console.log('unable to geocode! Response code: ' + request_geocode.status);
          var data = JSON.parse(request_geocode.responseText);
          console.log('error msg: ' + data.status.message);
        }
        else {
          console.log('server error');
        }
      }
      let request_geocode = new XMLHttpRequest();
      request_geocode.open('GET', '$api_url_geocode');
      request_geocode.onload = callbackAPIGeocode;
      request_geocode.send();
      </script>
      ";
  } // End getUserGeocode()

  public function adressInCoordinates($geocodeInput){ // à apeler pour transformr l'adresse postale en coordonnées
    $geocodeInput = str_replace(" ","%20",$geocodeInput);
    $api_url_geocode = 'https://api.opencagedata.com/geocode/v1/json?key=45d26994dcc44112a048289356be3a5b&pretty=1&q=' . $geocodeInput; // api call

    $proxy = "http://proxy.unicaen.fr:3128"; // A mettre pour le DevEtudiant de la FAC
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_PROXY, $proxy); // Idem
    curl_setopt($curl, CURLOPT_URL, $api_url_geocode);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    $decoded_data = json_decode($data, true);
    if( $decoded_data['status']['code'] === 200){
      $lat = $decoded_data['results'][0]['geometry']['lat'];
      $lng = $decoded_data['results'][0]['geometry']['lng'];

      return [$lat, $lng];
    }

  } // end fct adressInCoordinates()



  public function getListingGeocode($listeAnnonces){
    $listeAnnoncesJSON = json_encode($listeAnnonces);
    $taille =count($listeAnnonces);
    $api_url_geocode = 'https://api.opencagedata.com/geocode/v1/json?key=45d26994dcc44112a048289356be3a5b&q='; // api call

    echo "
    <script>
    let listeFiche = $listeAnnoncesJSON;
    let liste = [];
    let listeFinale = [];
    let fiche = [];
    let lat, lng;
    let request_geocode = new XMLHttpRequest();
    function getCoordonnee(){
      if(request_geocode.status === 200){
        console.log('Decode ok');
        let data = JSON.parse(request_geocode.responseText);
        lat = data.results[0]['geometry']['lat'];
        lng = data.results[0]['geometry']['lng'];
        console.log('Coordinates :' + lat + ' ' + lng);
      }
      else{
        console.log('Decode failed');
      }
    }
    function APICall(input){
      let api_url = '$api_url_geocode' + input[0];
      console.log(api_url);
      request_geocode.open('GET', api_url);
      request_geocode.onload = getCoordonnee;
      request_geocode.send();
    }
    }
    </script>
    ";
  }// end fct getListingGeocode()

  }
?>
