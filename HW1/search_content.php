<?php
/* Ritorna un JSON con i risultati dell'API selezionata */

require_once 'auth.php';

//se la sessione è scaduta esco
if (!checkAuth())
{
    exit;
}

//imposto l'header della risposta
header('Content-Type: application/json');

Apod();

function Apod(){
    $api_key = '7IcOqyfEQumOtp5ItKoYZpwt06S1Q9FPZF4rzSSG';

    $curl = curl_init();
    //prendo il contenuto per la ricerca
    $query = urlencode($_GET["q"]);
    //per comodità salvo l'url in una variabile
    $url = 'https://api.nasa.gov/planetary/apod?api_key=' .$api_key .'&date=' .$query;
    //fetch che usa come endpoint l'url che abbiamo assegnato 
    curl_setopt($curl, CURLOPT_URL, $url);
    //restituisci il risultato come stinga
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //risultato
    $res = curl_exec($curl);
    curl_close($curl);
    echo $res;
}


?>