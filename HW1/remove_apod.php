<?php

    require_once 'auth.php';
    if (!$username = checkAuth())
    {
        exit;
    }
    header('Content-Type: application/json');

    ApodR();

    function ApodR(){
        global $dbconfig, $username;

         //connessione con il database
         $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

         //cotruisco la query 
         $username = mysqli_real_escape_string($conn, $username);
         $title = mysqli_real_escape_string($conn, $_GET['title']);

         //il risultato è gia presente nel database per cui non c'è bisogno di controllare 
        $query = "DELETE FROM apod WHERE title = '$title' AND username = '$username'";
        error_log($query);

        $res = mysqli_query($conn, $query)or die(mysqli_error($conn));

        //controllo se l'operazione è andata a buon fine
        if(mysqli_num_rows($res) > 0) 
        {
            echo json_encode(array('ok' => true));
            exit;
        }

        //chiudo la connessione
        mysqli_close($conn);
        echo json_encode(array('ok' => false));
        
    }  

    

?>