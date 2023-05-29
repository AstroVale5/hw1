<?php

require_once 'dbconfig.php';
session_start();
function checkAuth()
{
//verifico se esiste già una sessione, in caso positivo la ritorno
if(isset($_SESSION['sessione_user'])) 
{
    return $_SESSION['sessione_user'];
} 
else
{
    return 0;
}
 
}
?>