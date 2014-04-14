<?php session_start(); 
/************************************
 * This script handles the uploading
 * of the images to the server
*************************************/

// Allowed file types
error_reporting(E_ALL);
ini_set('display_errors', '1');


// Get our database 
require_once("resources/Database.php"); 
$db = new Database(); 


$appid = createApp(); 


// Upload our files 
uploadFile('file', $appid); 
uploadFile('file2', $appid);
uploadFile('file3', $appid);
uploadFile('file4', $appid); 


 // Close connection 
$db->disconnect(); 
header('Location: ../index.php'); 
exit(); 
  
// Upload a file to the server 
function uploadFile($fname, $app) {
    
    $allowedExts = array("jpeg", "jpg", "png", "tiff");
    $temp = explode(".", $_FILES[$fname]["name"]);
    $extension = end($temp);
    echo var_dump($_FILES);


    if ((($_FILES[$fname]["type"] == "image/png")
    || ($_FILES[$fname]["type"] == "image/jpeg")
    || ($_FILES[$fname]["type"] == "image/jpg")
    || ($_FILES[$fname]["type"] == "image/tiff")
    || ($_FILES[$fname]["type"] == "image/x-png"))
    && ($_FILES[$fname]["size"] < 20000000)
    && in_array($extension, $allowedExts)) {

  if ($_FILES[$fname]["error"] > 0) {
        echo "Return Code: " . $_FILES[$fname]["error"] . "<br>";
    } 

    // If the file exists already
    if (file_exists("upload/" . $_FILES[$fname]["name"])) {
      echo $_FILES[$fname]["name"] . " already exists. ";
      } else {
      move_uploaded_file($_FILES[$fname]["tmp_name"],
      "upload/" . $_FILES[$fname]["name"]);
      echo "Stored in: " . "upload/" . $_FILES[$fname]["name"];
      
    }
    
    saveImagesToDatabase($_FILES[$fname]["name"], $app);
  } else {
    echo "Invalid file";
  }
}

// Store the images in the database 
function saveImagesToDatabase($fname, $app) {
    global $db;
    
    /* create a query*/
    $query = "INSERT INTO images(name,app_id) VALUES (
                    '$fname',
                    '$app'
                    )"; 
    
   
    $db->query($query,true); 
    
    if ($db->numRows() == 0) {
        echo 'error uploading picture'; 
        echo($query);
    }
}

// Creates an app in the database 
function createApp() {
    $user = $_SESSION['id']; 
    $name = mysql_real_escape_string($_POST['name']); 
    $desc = mysql_real_escape_string($_POST['desc']); 
    global $db; 
    
    // Check if we already have an app with the same name 
    $query = "SELECT app_id FROM apps WHERE name = '$name'"; 
    $db->query($query, false); 
    if ($db->numRows() > 0) {
        echo 'app already has that name'; 
    } else {
        
        $query = "INSERT INTO apps(description,name,user_id) VALUES (
                    '$desc',
                    '$name',
                    $user
                    )"; 
        $db->query($query,true);
        
        // App is inserted so get the id
        if ($db->numRows() > 0) {
            $query = "SELECT app_id FROM apps WHERE name = '$name'"; 
            $db->query($query,false); 
            if ($db->numRows() > 0) {
                $row = $db->rows();
                return $row[0]['app_id']; 
            } else {
                echo 'error getting app id'; 
            }
        } else {
            echo 'failed to get app identifier';
        }
    }
}


?>