<?php
/*cancella l'account dell'utente */

require_once 'auth.php';

if (!$username = checkAuth())
{
    exit;
}

header('Content-Type: application/json');

cancella();

function cancella(){
    global $dbconfig, $username;
    
    //connessione con il database
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    //costruisco la query
    $username = mysqli_real_escape_string($conn, $username);

    $query = "DELETE FROM users where username='$username'";

    $res = mysqli_query($conn, $query)or die(mysqli_error($conn));
    error_log($query);

    //chiudo la connessione
    mysqli_close($conn);
    echo json_encode(array('ok' => true));
}


?>