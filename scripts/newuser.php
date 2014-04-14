<?php

/********************************
 * Creates a new user from the form data
*********************************/ 
error_reporting(E_ALL);
ini_set('display_errors', '1');


if (isset($_POST['name'], $_POST['email'], $_POST['pwd'])) {

    // Get our database 
    require_once("resources/Database.php"); 
    $db = new Database(); 
    
    // Capture the values posted to this program 
    $username = mysql_real_escape_string($_POST['name']); 
    $email = mysql_real_escape_string($_POST['email']); 
    $password = mysql_real_escape_string($_POST['pwd']); 
    
    $db->addUser($username,$email,$password);
    $db->disconnect();  

    if ($db->numRows() > 0) {
        header('Location: ../index.php'); 
        exit(); 
    } else {
        echo "Sorry could not create account"; 
    }
}


?>





