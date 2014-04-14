<?php session_start();  

error_reporting(E_ALL);
ini_set('display_errors', '1');

/***********************************
 * Functions to manage account 
 ***********************************/

if (isset($_POST['delete'])) {
    removeAccount(); 
} else if (isset($_SESSION['id'], $_POST['fname'], $_POST['lname'], $_POST['bio'])) {
    editInfo(); 
} else if(isset($_POST['getdata'])) {
    getData($_POST['getdata']); 
}


function editInfo() {
    
    // Get our database 
    require_once("resources/Database.php"); 
    $db = new Database(); 
    
    $id = $_SESSION['id']; 
    $fname = mysql_real_escape_string($_POST['fname']); 
    $lname = mysql_real_escape_string($_POST['lname']);
    $bio =  mysql_real_escape_string($_POST['bio']); 
    
    // create a query
     $query = "INSERT INTO UserExtra(user_id,first_name,last_name,bio) VALUES (
                $id,
                '$fname',
                '$lname',
                '$bio'
                    )";     
    
      $db->query($query, true); 
      $db->disconnect(); 
      if ($db->numRows() > 0) {
          header('Location: ../index.php'); 
          exit(); 
      } else {
          echo 'database error';
      }        
}

// get the account information to display
function getData($id) {
   
    // Get our database 
    require_once("resources/Database.php"); 
    $db = new Database(); 
    
    $query = "Select first_name, last_name, bio, rated_total FROM UserExtra WHERE user_id = '$id'"; 
    
    $db->query($query,false);
    $db->disconnect();
    if ($db->numRows() > 0) {
        $rows = $db->rows(); 
        $row = $rows[0];
        
        echo "<p id='accountInfo'>First Name: ".$row['first_name']."<br>"."Last Name: ".$row['last_name']."<br>"."Bio: ".$row['bio']."</p>";

    } else {
        echo ' ';
    }
}

// Remove user account 
function removeAccount() {

    // Get our database 
    require_once("resources/Database.php"); 
    $db = new Database(); 
   
    $id = $_SESSION['id']; 
    
	// create a query
    $query = "DELETE FROM Users WHERE user_id = $id"; 
    
          
    $db->query($query,true);
     
    if ($db->numRows() > 0) {
        unset($_SESSION['id']); 
	} else {
    	echo "error in database";
	}  
	
	 // Delete from UserExtra Table 
	 $query = "DELETE FROM UserExtra WHERE user_id = $id"; 
	 
	 $db->query($query,true); 
	 
	 if ($db->numRows() > 0) {
    	 header('Location: ../index.php'); 
         exit(); 
	 } else {
    	 echo "error in database";
	 }
	
	$db->discconect();
}

?>