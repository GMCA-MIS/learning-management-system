<?php
// Start session
session_start();
// Check whether the session variable SESS_MEMBER_ID is present or not
if (!isset($_SESSION['username']) || ($_SESSION['username'] == '')) {
    header("location: ../login.php"); // Redirect to login page if not logged in
    exit();
}

// Assuming you have established a database connection already (e.g., $conn)
// Include your database connection code here if it's not included already

$username = $_SESSION['username'];
$teacher_id = $_SESSION['teacher_id'];
// You can also include other session-related checks or user-type checks here if needed
?>

<head> 

<link rel="icon" href="../img/gmlogo.png">
</head>