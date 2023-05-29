<?php

require_once 'auth.php';
    if (!$username = checkAuth()) exit;

    header('Content-Type: application/json');

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    $username = mysqli_real_escape_string($conn, $username);

     // Seleziono tutti gli attributi che mi interessano
    $query = "SELECT title , content, commento FROM apod a LEFT JOIN commenti c ON a.title=c.titolo WHERE a.username = '$username' ";


    //eseguo la query
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $apod = array();
    while($entry = mysqli_fetch_assoc($res)) {
        // Scorro i risultati ottenuti e creo l'elenco 
        $apod[] = array('title' => $entry['title'], 'content' => json_decode($entry['content']), 'commento' => $entry['commento']);
    }
    echo json_encode($apod);
    exit;

?>