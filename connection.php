<?php
// Display all errors, very useful for PHP debugging (disable in production)

// Parameters of the MySQL connection 
$servername = "cmsc508.com";
$username = "23SP_wicklandde";
$password = "23SP_wicklandde";
$database = "23SP_wicklandde_pr";

if(!$conn = mysqli_connect($servername, $username, $password, $database)){
    die("failed to connect to database!");
}

?>