<?php
/* Inserisce nel database gli elementi interessati */
    require_once 'auth.php';
    if (!$username = checkAuth())
    {
        exit;
    }
    header('Content-Type: application/json');
    
    ApodS();
    function ApodS(){
        global $dbconfig, $username;
        
        //connessione con il database
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

        //costruisco la query
        $username = mysqli_real_escape_string($conn, $username);
        $title = mysqli_real_escape_string($conn, $_GET['title']);
        $image = mysqli_real_escape_string($conn, $_GET['image']);
        
        //controlla se l'apod è già presente per l'user
        $query = "SELECT * FROM apod WHERE title = '$title' AND username = '$username'";
        $res = mysqli_query($conn, $query)or die(mysqli_error($conn));

        //Se l'apod è già presente non fare nulla 
        if(mysqli_num_rows($res) > 0) 
        {
            echo json_encode(array('ok' => true));
            exit;
        }
        //eseguo la query
        $query = "INSERT INTO apod(title, username, content) VALUES ('$title', '$username', JSON_OBJECT('title', '$title', 'image', '$image'))";
        error_log($query);
        //se corretta, ritorna un JSON con {ok: true}
        if(mysqli_query($conn, $query) or die(mysqli_error($conn)))
        {
            echo json_encode(array('ok' => true));
            exit;
        }
        //chiudo la connessione
        mysqli_close($conn);
        echo json_encode(array('ok' => false));
    }
?>