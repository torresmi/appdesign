<?php session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', '1');

/***********************************
 * This script displays 5 apps to go
 * on the home page 
 ***********************************/
// Get our database 
require_once("resources/Database.php"); 
$db = new Database(); 

// create a query
$query = "SELECT app_id, name, description FROM apps LIMIT 5 OFFSET ".$_POST['offset'];
      
$db->query($query,false);
 echo "<div id='apps'>";
if ($db->numRows() > 0) {
    foreach ($db->rows() as $app) {
         $appid = $app['app_id']; 
       
        // If not logged in then you cannot vote
        if (isset($_SESSION['id'])) {
            
             // l + appid tells the jquery method to like that app id. d means dislike 
             echo "<img class='voteup' id='l".$appid."'"."src=scripts/upload/thumbs-up.png>";
             echo "<img class='votedown' id='d".$appid."'"."src=scripts/upload/thumbs-down.png>";
             
        }
        echo "<p class='appName'>"."App Name: ".$app['name'].'</p>'; 
        echo "<p class='appDesc'>"."App Description: ".$app['description'].'</p>'; 
        
       
        
        // Get the total number of ratings 
        $query = "SELECT liked FROM Rating WHERE app_id = $appid"; 
        
        $db->query($query,false); 
        
        // If there are no reatings yet 
        if ($db->numRows() == 0) {
            echo "<p id='appTotal".$appid."'".">"."App Rating Total: 0".'</p>'; 
        } else {
            echo "<p id='appTotal".$appid."'".">"."App Rating Total: ".$db->numRows().'</p>'; 
        }
        
        // Get the number of likes 
        $query = "SELECT liked FROM Rating WHERE app_id = $appid AND liked = 1"; 
        
        $db->query($query,false); 
        
        // 1 is a like 0 is not a like
        echo "<p id='appRating".$appid."'".">"."Total Likes: ".$db->numRows().'</p>'; 
        
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
        echo "<p></p>";
        
    }

    $db->disconnect();
} else {
    echo "No more apps";
}   
echo "</div>";
?>
