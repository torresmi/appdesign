<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="./css/myaccount.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title> 
</title>
<h2> Account Information </h2>
<script> 

	function validateForm() {
		var form = document.forms["myForm"];
		var fname = form.fname.value;
		var lname = form.lname.value; 
		
		
		if (!isNaN(fname) || !isNaN(lname)) {
    		alert("Please enter a valid name"); 
    		return false; 
		}

		
		return true; 
	}


</script>

<script>
    $(document).ready(function() {
        console.log(<?php echo $_SESSION['id']; ?>);
       $.ajax({
           url: 'scripts/manageAccount.php',
           type: 'post',
           data: {"getdata":<?php echo $_SESSION['id']; ?>},
           success: function(response) {
                console.log(response);
               if (response != ' ') {
                   $("#userInfo").replaceWith(response);
               }
            }
       });
        
    });
</script>
</head>

<body>
    <div id="userInfo">
    </div>
	<div id="form">
	<form name="myForm" action="scripts/manageAccount.php" method="post" onsubmit="return validateForm();"
	    enctype="multipart/form-data"> 
		
		First Name: <input type="text" name="fname"/><br/>
		Last Name: <input type="text" name="lname"><br/>
		Bio:<br> <textarea name="bio" cols="40" rows="5"></textarea><br/>
		<input id="button" type="submit" value="Submit"/>
		<input id="remove" type="submit" value="Remove" name="delete"/>
	</form>
	</div>
</body>
</html>