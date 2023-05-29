<?php 
    require_once 'auth.php';
    if (!$username = checkAuth()) {
        header("Location: profilo.php");
        exit;
    }

    if (!empty($_POST["nuovo"]))
    {
        $error = array();
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
        $username = $_SESSION['sessione_user'];
        
        // Controlla che l'username rispetti il pattern specificato
        if(!preg_match('/^[a-zA-Z0-9_]{1,20}$/', $_POST['nuovo']))
        {
            $error[] = "Username non valido";
        }
        else
        {
            $nuovo = mysqli_real_escape_string($conn, $_POST['nuovo']);
            // Cerco se l'username esiste già o se appartiene a una delle 3 parole chiave indicate
            $query = "SELECT username FROM users WHERE username = '$nuovo'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0)
            {
                $error[] = "Username già in uso";
            }
        }

         //REGISTRAZIONE NEL DATABASE
         if (count($error) == 0)
         {
           $query = "UPDATE users set username = '$nuovo' where  username='$username'";
            
           if (mysqli_query($conn, $query))
           {
               $_SESSION["sessione_user"] = $_POST["username"];
               mysqli_close($conn);
               header("Location: profilo.php");
               exit;
           }
           else 
           {
               $error[] = "Errore di connessione al Database";
           }
       }
       mysqli_close($conn);
    }
    else if (!isset($_POST["nuovo"]))
    {
        $error = array("Riempi tutti i campi");
    }

?>


<html>
    <?php 
        // Carico le informazioni dell'utente loggato per visualizzarle nella sidebar
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $username = mysqli_real_escape_string($conn, $username);
        $query = "SELECT * FROM users WHERE username = '$username'";
        $res_1 = mysqli_query($conn, $query);
        $userinfo = mysqli_fetch_assoc($res_1);   
    ?>

    <head>
        <link rel='stylesheet' href='profilo.css'>
        <script src='profilo.js' defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">

        <title>ScienceHub - <?php echo $userinfo['nome']." ".$userinfo['cognome'] ?></title>
    </head>

    <body>

    <nav id="nav-top">
        <div id="logo">
          ScienceHub
        </div>

        <div id="scritte">
            <a href="home.php">Home</a>
            <a href="">Contatti</a>
            <a href="logout.php">Esci</a>
        </div>
        
    </nav>

    <article id="sfondo">

    <div class="nascosto">
        <span class="name"> Cambio username </span>

        <form type="submit" method="POST" autocomplete="off">
            <div id="campi">
                <div class="username">
                    <label for='nuovo'>Nuovo username</label>
                    <input type='text' name='nuovo' <?php if(isset($_POST["nuovo"])){echo "value=".$_POST["nuovo"];} ?>>
                    <div><span> username già in uso </span></div>

                </div>
                
            </div>
        </form>
    

    </div>

        <main id="riquadro">
            <span class="name"> Menù - <?php echo $userinfo['username']?></span>

            <span class="menù"> <a href="galleria.php">Galleria</a></span>

            <span class="menù"> <a id="cancella" href="">Cancella account </a> </span>

            <span class="menù"> <a id="cambioUser" href="">Cambia username</a></span>
        </main>

    </article>





    </body>


</html>