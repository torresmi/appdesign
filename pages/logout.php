<?php session_start();  

/* Logs out of the website */ 

if (isset($_SESSION['id'])) {
    unset($_SESSION['id']); 
}

header('Location: ./index.php'); 
exit();

?> 