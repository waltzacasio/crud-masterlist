<?php

// server info
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'masterlist';

// connect to the database
$conn = mysqli_connect($server, $user, $pass, $db);



// show errors (remove this line if on a live site)
//mysqli_report(MYSQLI_REPORT_ERROR);

if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>