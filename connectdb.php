<?php
$servername = "my-db.ckifiguewtro.ap-southeast-1.rds.amazonaws.com:3306";
$username = "admin";
$password = "12345678";
$dbname = "pts";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
