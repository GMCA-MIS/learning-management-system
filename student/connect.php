<?php
// Database connection parameters
$servername = "srv1320.hstgr.io";
$username = "u944705315_capstone2024";
$password = "Capstone@2024.";
$dbname = "u944705315_capstone2024";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
