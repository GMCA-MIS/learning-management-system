<?php
// update_schedule.php

require_once('db-connect.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_datetime = $_POST['start_datetime'];
    $end_datetime = $_POST['end_datetime'];

    // Perform the update query
    $updateQuery = "UPDATE `schedule_list` SET 
                    title = '$title', 
                    description = '$description', 
                    start_datetime = '$start_datetime', 
                    end_datetime = '$end_datetime' 
                    WHERE id = $id";

    if ($conn->query($updateQuery) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Event updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating event: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Close the database connection
$conn->close();
?>