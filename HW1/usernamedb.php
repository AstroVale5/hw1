<?php
/* Controllo dell'username con il database */
require_once 'dbconfig.php';

    if (!isset($_GET["q"])) 
    {
        echo "Non hai il permesso per accedere";
        exit;
    }


// Imposto l'header della risposta
header('Content-Type: application/json');

//connessione al DB
$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

//lettura dell'username inserito
$username = mysqli_real_escape_string($conn, $_GET["q"]);

//preparazione query
$query = "SELECT username FROM users WHERE username = '$username'";

//esecuzione della query
$res = mysqli_query($conn, $query) or die(mysqli_error($conn));

//controlla i risultati e li ritorna "impacchettati" in un JSON
echo json_encode(array('exists' =>mysqli_num_rows($res) > 0 ? true : false));

//chiudo la connessione
mysqli_close($conn);

?>