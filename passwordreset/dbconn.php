<?php
// dbcon.php

$mysqli = new mysqli('localhost','root','','capstone');

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

return $mysqli;
?>