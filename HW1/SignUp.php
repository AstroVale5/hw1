<?php
require_once 'auth.php';

if (checkAuth()) 
{
    header("Location: home.php");
    exit;
}  

//verifica l'esistenza dei dati compilati
if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["name"]) && 
        !empty($_POST["surname"]) && !empty($_POST["confirm_password"]) && !empty($_POST["allow"]))
{
    //inserisco gli errori in un array che, eventualmente, restituirò alla fine
    $error = array();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    /* USERNAME */
    if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) 
    {
        //inserimento nell'array
        $error[] = "Username non valido";
    }
    else 
    {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
         // Cerco se l'username esiste già
        $query = "SELECT username FROM users WHERE username = '$username'";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) 
        {
            $error[] = "Username già in uso";
        }
    }

     /* PASSWORD */
     if (strlen($_POST["password"]) < 8) 
    {
        $error[] = "Caratteri password insufficienti";
    } 

    /* CONFERMA PASSWORD */
    if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) 
    {
        $error[] = "Le password non coincidono";
    }

    /* EMAIL */
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
    {
        $error[] = "Email non valida";
    } 
    else 
    {
        $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
        $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
        if (mysqli_num_rows($res) > 0) 
        {
            $error[] = "Email già in uso";
        } 
    }

    // REGISTRAZIONE NEL DATABASE
    //se l'array degli errori è vuoto
    if(count($error) == 0)
    {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);

        $password = mysqli_real_escape_string($conn, $_POST['password']);
        //cryptiamo la password
        $password = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users(email, username, nome, cognome, password) VALUES ('$email', '$username', '$name', '$surname', '$password')";

        if (mysqli_query($conn, $query)) 
        {
            $_SESSION["sessione_user"] = $_POST["username"];
            mysqli_close($conn);
            header("Location: home.php");
            exit;
        } 
        else
        {
            $error[] = "Errore di connessione al database";
        }
    }

    //chiudiamo la connessione
    mysqli_close($conn);
}
else if (isset($_POST["username"]))
{
    $error = array("Riempi tutti i campi");
}

?>






<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signUp1.css"/>
    <script src="SignUp.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair:wght@600&display=swap" rel="stylesheet">
    <title>Registrazione</title>
</head>


<body>
    <article id="contenuto">
        <div id="box">
            <h1>REGISTRAZIONE</h1>
                <form id="fm" type="submit" method="post" autocomplete="off">
                
                    <div class="email">
                        <label for='email'>Email</label>
                        <input type='text' name='email' <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>
                        <div><img src="images/error.svg"/><span>Indirizzo email non valido</span></div>
                    </div>
                    
                    <div class="username">
                        <label for='username'>Username</label>
                        <input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                        <div><img src="images/error.svg"/><span>Nome utente non disponibile</span></div>
                    </div>

                   <div class="name">
                        <label for='name'>Nome</label>
                        <input type='text' name='name' <?php if(isset($_POST["name"])){echo "value=".$_POST["name"];} ?> >
                        <div><img src="images/error.svg"/><span>Inserisci il tuo nome</span></div>
                    </div>
                    
                    <div class="surname">
                        <label for='surname'>Cognome</label>
                        <input type='text' name='surname' <?php if(isset($_POST["surname"])){echo "value=".$_POST["surname"];} ?> >
                        <div><img src="images/error.svg"/><span>Inserisci il tuo cognome</span></div>
                    </div>

                    <div class="password">
                        <label for='password'>Password</label>
                        <input type='password' name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                        <div><img src="images/error.svg"/><span>Inserisci almeno 8 caratteri</span></div>
                    </div>

                    <div class="confirm_password">
                        <label for='confirm_password'>Conferma Password</label>
                        <input type='password' name='confirm_password' <?php if(isset($_POST["confirm_password"])){echo "value=".$_POST["confirm_password"];} ?>>
                        <div><img src="images/error.svg"/><span>Le due password sono diverse</span></div>
                    </div>
                    

                    <div class="allow"> 
                        <input type='checkbox' name='allow' value="1" <?php if(isset($_POST["allow"])){echo $_POST["allow"] ? "checked" : "";} ?>> <label for='allow'>Accetto le condizioni d'uso di ScienceHub.</label>
                    </div>
                
                    <div class="submit-container">
                        <div class="login-btn">
                            <input type='submit' value="REGISTRATI">
                        </div>
                    </div>

                </form>
                
                <div class="buttonlogin">
                    <p>Hai già un account? <a href="login.php"> login</a></p>
                </div>  
        </div>
    

    </article>

</body>
</html>