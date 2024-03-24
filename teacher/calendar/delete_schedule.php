<?php
require_once('db-connect.php');

if (!isset($_POST['id'])) {
    error_log("ID not set in POST request", 0);  // Log an error message
    echo "error";
    exit;
}

$id = $_POST['id'];

$delete = $conn->query("DELETE FROM `schedule_list` WHERE id = '$id'");
if ($delete) {
    echo "success";
} else {
    error_log("Failed to delete event: " . $conn->error, 0);  // Log an error message
    echo "error";
}

$conn->close();
?>
