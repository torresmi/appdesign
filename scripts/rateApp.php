<?php session_start(); 
error_reporting(E_ALL);

/***********************************
 * Rates an app 
 ***********************************/
ini_set('display_errors', '1');

    // Get our database 
    require_once("resources/Database.php"); 
    $db = new Database(); 

    $id = $_SESSION['id'];
    $appid = $_POST['appid']; 
    $liked = $_POST['liked']; 
    
    $shouldInsert = 0; 
    // Check to see if the user has already rated the application 
    $query = "SELECT rate_id FROM Rating WHERE app_id = $appid AND user_id = $id";
    $db->query($query, false); 
    if ($db->numRows() > 0) {
        echo "already voted"; 
    } else {
        $shouldInsert = 1; 
    }
    
    if ($shouldInsert == 1) {
        // create a query
        $query = "INSERT INTO Rating(app_id,user_id,liked) VALUES (
                        $appid,
                        $id,
                        $liked
                        )"; 
                
        $db->query($query,true);
    }
    $db->disconnect();
?>
