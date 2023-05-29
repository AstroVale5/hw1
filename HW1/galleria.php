<?php 
    require_once 'auth.php';
    if (!$userid = checkAuth()) 
    {
        header("Location: login.php");
        exit;
    }

?>


<html>
    <head>
        <link rel='stylesheet' href='galleria.css'>
        <script src='galleria.js' defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>ScienceHub</title>
    </head>

    <body>
    <article id="modale" class="hidden"></article>

    <nav id="nav-top">
        <div id="logo">
          ScienceHub
        </div>

        <div id="scritte">
            <a href="home.php">Home</a>
            <a href="">Contatti</a>
            <a href="profilo.php">Profilo</a>
            <a href="logout.php">Esci</a>
        </div>
        
    </nav>

    <section class="container">
        <div id="results">

        </div>
    </section>
    </body>
    


</html>

