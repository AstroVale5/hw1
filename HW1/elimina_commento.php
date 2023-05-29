<?php 
    require_once 'auth.php';
    if (!$username = checkAuth())
    {
        exit;
    }
    header('Content-Type: application/json');

    remove();

    function remove(){
        global $dbconfig, $username;

        //connessione con il database
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

        $username = mysqli_real_escape_string($conn, $username);
        $comment = mysqli_real_escape_string($conn, $_GET['comment']);
        $title = mysqli_real_escape_string($conn, $_GET['title']);

        //controlla se la foto ha già un commento
        $query= "SELECT commento FROM commenti WHERE titolo='$title' AND username='$username'";
        $res = mysqli_query($conn, $query)or die(mysqli_error($conn));

        if(mysqli_num_rows($res) > 0) 
         {
             /*sviluppare la query per cancellare */
             $query = "DELETE FROM commenti WHERE titolo = '$title' AND username ='$username'";
             $res = mysqli_query($conn, $query)or die(mysqli_error($conn));
         }

        //chiudo la connessione
        mysqli_close($conn);
        echo json_encode(array('ok' => true));
    }

?>