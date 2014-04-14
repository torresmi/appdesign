<?php
class Database {

    // Properties for the class 
    protected $_link, $_result, $_numRows, $_userID; 
    
    // Connect to the database 
    public function __construct() {
        $this->_link = mysql_connect('cis.gvsu.edu','torresmi','torresmi0596');
        if (!$this->_link) {
            die('Could not connect: '.mysql_error());
        }
        mysql_select_db("torresmi");
    }

    // Disconnect to the database 
    public function disconnect() {
        mysql_close($this->_link); 
    }
    
    // Query 
    public function query($sql, $isSetter) {
        $this->_result = mysql_query($sql, $this->_link); 
        
        if (!$this->_result) {
            echo "<p>query failed</p>";
        } else if ($isSetter) {
          $this->_numRows = mysql_affected_rows(); 
        } else {
            $this->_numRows = mysql_num_rows($this->_result); 
        }
    }

    // Get the number of rows from the query 
    public function numRows() {
        return $this->_numRows; 
    }
    
    // Get the user id 
    public function userID() {
        return $this->_userID; 
    }
    
    // Get the rows from the query 
    public function rows() {
        $rows = array(); 
        for($i = 0; $i < $this->numRows(); $i++) {
            $rows[] = mysql_fetch_array($this->_result); 
        }
        return $rows; 
    }
    
    // Add a new user 
    public function addUser($name, $email, $password) {
    
        $name = mysql_real_escape_string($name); 
        $email = mysql_real_escape_string($email);
        $password = mysql_real_escape_string($password); 
        
        
        // Secure the password 
        $salt = bin2hex(openssl_random_pseudo_bytes(50));
        $hash = crypt($password, '$2a$11$' . $salt);
        
        $query = "INSERT INTO Users(email,display_name,salt, hash) VALUES (
                    '$email',
                    '$name',
                    '$salt',
                    '$hash'
                        )"; 
        
        self::query($query, true); 
        
    }
    
    // Check login 
    public function login($name,$password) {
        $name = mysql_real_escape_string($name); 
        $password = mysql_real_escape_string($password); 
        
        $query = "SELECT user_id,salt, hash FROM Users WHERE display_name = '$name'"; 
        $result = mysql_query($query);
        $data = mysql_fetch_array($result);
        $salt = $data['salt'];
        $hash = $data['hash']; 
        
        if (crypt($password, '$2a$11$' . $salt) == $hash) {
            $this->_userID = $data['user_id']; 
        } else {
            $this->_userID = -1; 
        }
    }
    
}
?> 