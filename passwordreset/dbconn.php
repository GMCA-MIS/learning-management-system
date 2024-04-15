<?php
// dbcon.php





$mysqli = new mysqli('srv1320.hstgr.io','u944705315_capstone2024','Capstone@2024','u944705315_capstone2024');

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

return $mysqli;
?>