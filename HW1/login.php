<?php
//verifica che l'utente sia già loggato
include 'auth.php';
if(checkAuth())
{
    header('Location: home.php');
    exit;
}


if(!empty($_POST["username"]) && !empty($_POST["password"]))
{
    //Caso in cui username e password sono stati già inviati
    //mi connetto al DB
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    //preparazione della query
    $query = "SELECT * FROM users WHERE username = '".$username."'";
    //esecuzione della query
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));;

    //verifica dei risultati tornati
    if(mysqli_num_rows($res) > 0)
    {
        //usiamo un array associativo per il risultato (sarà solo 1)
        $entry = mysqli_fetch_assoc($res);
        if (password_verify($_POST['password'], $entry['password']))
        {
            //imposto una sessione dell'utente
            $_SESSION["sessione_user"] = $entry['username'];
            header("Location: home.php");
            mysqli_free_result($res);
            mysqli_close($conn);
            exit;
        }
    }
    //se l'utente non è stato trovato o non ha passato la verifica per altri motivi
    $error = "Username e/o password errati.";
}
else if (isset($_POST["username"]) || isset($_POST["password"]))
{
    //Se ha inserito solo uno dei due
    $error = "Inserisci username e password.";
}

?>

<html>
    <head>
        <link rel='stylesheet' href='login1.css'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair:wght@600&display=swap" rel="stylesheet">
        <title>Accedi - ScienceHub</title>
    </head>

    <body>
    <article id="contenuto">
        <div id="box">
            <h2> ACCEDI </h2>
            <?php
                // Verifica la presenza di errori
                if (isset($error)) 
                {
                    echo "<p class='error'>$error</p>";
                }  
            ?>
                <form name="login" type="submit" method="POST">
                    <div id="campi"> 
                        <div class="username">
                            <label for='username'>Username</label>
                            <input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                        </div>

                        <div class="password">
                            <label for='password'>Password</label>
                            <input type='password' name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                        </div>
                    </div>

                    <div class="submit-container">
                        <div class="login-btn">
                            <input type='submit' value="ACCEDI">
                        </div>
                </div>
                    <div class="signup"><p>Non hai un account?<a href="signup.php">Iscriviti</a></p></div> 
        </div>
    

    </article>

</body>



</html>