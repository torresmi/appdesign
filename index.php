<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="css/main.css">
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<title>App Designs</title>
</head>

<body>
    <h1>App Designs</h1>
<?php session_start();
    
    echo "
        <div id='nav'>
            <ul id='navitems'>
                <li><a href='index.php'>Home</a></li>
                <li><a href='index.php?p=topdesigns.php'>Top Designs</a></li>
                <li><a href='index.php?p=myapps.php'>My Apps</a></li>
                <li><a href='index.php?p=newapp.html'>Add App Design</a></li>
        ";
            // If we are logged in already 
            if ($_SESSION['id']) {
                echo"<li><a href='index.php?p=editaccount.php'>My Account</a></li>";
                echo"<li> <a href='index.php?p=logout.php'>Log Out</a></li>";
            } else {
                echo "
                <li><a href='index.php?p=signup.html'>Sign Up</a></li>
                <li> <a href='index.php?p=login.html'>Log In</a></li>
                ";
            }
            echo "
                
                <li><a href='index.php?p=about.php' id='about'>About</a></li>
            </ul>
        </div>
       "
    ?>
    <div id="content">
    <?php 
        // Get the parameter and then try to include the php file in the main content  
        if (!empty($_GET['p'])) {
        
            // The directory that is holding our pages to be swapped in and out of main content
            $pages = scandir('pages',0); 
            // Get rid of the first two values because they are not pages
            unset($pages[0], $pages[1]); 
        
            $p = $_GET['p']; 
        
            // Only include our directory pages
            if (in_array($p, $pages)) {
            
                // If we are trying to access pages where we need to be logged in
                if ($p == "myapps.php" || $p == "newapp.html") {
                    if ($_SESSION['id']) {
                         include ('pages/'.$p); 
                    } else {
                        echo "<p>Please log in first</p>"; 
                    }
                } else {
                    include ('pages/'.$p); 
                }
               
            } else {
                echo "Sorry the page cannot be found";
            }
            
        // Home page if no variable given 
        } else {
            include ('pages/home.php'); 
        }
    ?>
    </div>
</body>
</html>