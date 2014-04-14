<?php session_start(); 


/***********************************
 * Logs the user in 
 ***********************************/

if (isset($_POST['name'], $_POST['pwd'])) {

    // Capture the values posted to this program.
    $username = mysql_real_escape_string($_POST['name']); 
    $password = mysql_real_escape_string($_POST['pwd']); 
    
    // Get our database 
    require_once("resources/Database.php"); 
    $db = new Database(); 

    // Try to login 
    $db->login($username, $password);
    $db->disconnect();  
    if ($db->userID() > -1) {
        $_SESSION['id'] = $db->userID(); 
        header('Location: ../index.php'); 
        exit(); 
    } else {
        echo 'Login failed. Please check password and try again'; 
    }
} 
?>





