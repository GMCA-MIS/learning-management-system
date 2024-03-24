<?php
// fetch-max-score.php

// Assuming you have a database connection
include 'dbcon.php';

$taskID = $_GET['task_id'];

// Fetch max_score from the database based on the selected task
$query = mysqli_query($conn, "SELECT max_score FROM task WHERE task_id = $taskID");

if ($query && mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);
    $maxScore = $row['max_score'];

    // Return max_score as a JSON response
    echo json_encode($maxScore);
} else {
    // Handle errors accordingly
    echo json_encode('Error fetching max score');
}

mysqli_close($conn);
?>