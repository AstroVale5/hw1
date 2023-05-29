<?php

    require_once 'auth.php';

    if (!$username = checkAuth())
    {
        exit;
    }

    comment();

    function comment(){
        global $dbconfig, $username;

         //connessione con il database
         $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

        //costruisco la query
        $username = mysqli_real_escape_string($conn, $username);
        $comment = mysqli_real_escape_string($conn, $_GET['comment']);
        $title = mysqli_real_escape_string($conn, $_GET['title']);


        //eseguo la query
        $query = "INSERT INTO commenti(username, commento, titolo) VALUES ('$username', '$comment', '$title')";
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