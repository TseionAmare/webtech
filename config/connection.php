<?php
$host = 'localhost';
$dbname = 'Farmitecture';  // Ensure this is the correct database name
$username = 'root';
$password = '';

// Set up the MySQLi connection
$con = mysqli_connect($host, $username, $password, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
