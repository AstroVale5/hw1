<?php
    include 'dbconfig.php';

    // devoo startare per fare capire al destroy quale sessione distruggere
    session_start();
    // Distruggo la sessione esistente
    session_destroy();

    header('Location: index.php');
?>