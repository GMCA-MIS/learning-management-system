<?php
// update_assignment_grade.php

// Include your database connection file here
include 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $assignment_grade = $_POST['assignment_grade'];

    // Check if a record for the student_id already exists
    $check_record_query = "SELECT * FROM student_grade WHERE student_id = $student_id";
    $result_check_record = mysqli_query($conn, $check_record_query);

    // Check if the query was successful
    if (!$result_check_record) {
        die("Error checking record: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result_check_record) > 0) {
        // Record exists, perform an UPDATE
        $update_assignment_grade_query = "UPDATE student_grade SET assignment_grade = $assignment_grade WHERE student_id = $student_id";
        $result_update_assignment_grade = mysqli_query($conn, $update_assignment_grade_query);

        // Check if the query was successful
        if (!$result_update_assignment_grade) {
            die("Error updating assignment grade: " . mysqli_error($conn));
        }

        echo "Assignment grade updated successfully";
    } else {
        // Record doesn't exist, perform an INSERT
        $insert_assignment_grade_query = "INSERT INTO student_grade (student_id, assignment_grade) VALUES ($student_id, $assignment_grade)";
        $result_insert_assignment_grade = mysqli_query($conn, $insert_assignment_grade_query);

        // Check if the query was successful
        if (!$result_insert_assignment_grade) {
            die("Error inserting assignment grade: " . mysqli_error($conn));
        }

        echo "Assignment grade inserted successfully";
    }
}
?>
