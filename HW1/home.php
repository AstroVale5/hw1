<?php 
    require_once 'auth.php';
    if (!$username = checkAuth()) 
    {
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home3.css"/>
    <script src="home3.js" defer="true"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair:wght@600&display=swap" rel="stylesheet">
    <title>ScienceHub-Home</title>
</head>


<body>
  <article id="modale" class="hidden"></article>
    <nav id="nav-top">
        <div id="logo">
          ScienceHub
        </div>

        <div id="scritte">
            <a href="home.php">Home</a>
            <a href="galleria.php">Galleria</a>
            <a href="profilo.php">Profilo</a>
            <a href="logout.php">Esci</a>
        </div>
        
    </nav>

    <main id="content">
        <div id="NO-NAV">
            <div class="banner"><p>Benvenuto!</p></div>
        </div>
    </main>

    <div class="text">
        <span>Usando il formato anno-mese-giorno 
            effettua la tua ricerca e scopri l'astronomy 
            picture di quel giorno!
        </span>
    </div>
    <form id="esperimento" autocomplete="off">
        <label class="ric">Ricerca <input type='text' name = 'content' id ='valore' placeholder="YYYY-MM-DD"></label>
        <label>&nbsp;<input class="submit" type='submit'></label>
    </form>
    

    <div class="sfondo"></div>



    <div id="container">
        <article id="box"></article>
    </div>
    

    
    <footer>
        <nav>
          <div class="footer-container">
            <div class="footer-col">
              <h2>ScienceHub</h2>
            </div>
            <div class="footer-col">
              <strong>AZIENDA</strong>
              <p>Chi siamo</p>
              <p>Lavora con noi</p>
            </div>
            <div class="footer-col">
              <strong>CATEGORIE</strong>
              <p>Articoli</p>
            </div>
            <div class="footer-col">
              <strong>LINK UTILI</strong>
              <p>Assistenza</p>
              <p>App per cellulare</p>
              <p>Informazioni legali</p>
            </div>
          </div>
        </nav>
      </footer>

</body>
</html>
