<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>My Apps</title>
</head>

<body>

<?php session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', '1');

    // Get our database 
    require_once("scripts/resources/Database.php"); 
    $db = new Database(); 

    $id = $_SESSION['id'];
    
    // create a query
    $query = "SELECT app_id, name, description FROM apps WHERE user_id = $id";
            
    $db->query($query,false);
    
    if ($db->numRows() > 0) {
        foreach ($db->rows() as $app) {
            echo "<p class='appName'>"."App Name: ".$app['name'].'</p>'; 
            echo "<p class='appDesc'>"."App Description: ".$app['description'].'</p>'; 
            
            $appid = $app['app_id']; 
            
            // Get the total number of ratings 
            $query = "SELECT liked FROM Rating WHERE app_id = $appid"; 
            
            $db->query($query,false); 
            
            // If there are no reatings yet 
            if ($db->numRows() == 0) {
                echo "<p class='appRating'>"."App Rating Total: 0".'</p>'; 
            } else {
                echo "<p class='appRating'>"."App Rating Total: ".$db->numRows().'</p>'; 
            }
            
            // Get the number of likes 
            $query = "SELECT liked FROM Rating WHERE app_id = $appid AND liked = 1"; 
            
            $db->query($query,false); 
            
            // 1 is a like 0 is not a like
            echo "<p class='appRating'>"."Total Likes: ".$db->numRows().'</p>'; 
            
            // Get the first image for the app
            $query = "SELECT name FROM images WHERE app_id = $appid"; 
            $db->query($query,false);
            if ($db->numRows() == 0) {
                echo 'error getting images'; 
            } else {
                foreach ($db->rows() as $image) {
                    echo "<img src=scripts/upload/".$image['name']." width='300' height='500'>";
                }
            }
        }
        $db->disconnect();
    } else {
        echo "<p>No apps yet</p>";
    }   
    
    
?>
</body>
</html>