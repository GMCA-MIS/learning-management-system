<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Content</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/newheader.css">
</head>
<body>


<?php
include('dbcon.php'); // Include your database connection file

if(isset($_POST['update_content'])) {
    // Name attributes should match the form input names
    $content_id = $_POST['content_id']; // Assuming you have an input with name "content_id"
    $newTitle = $_POST['missionTitle'];
    $newContent = $_POST['missionContent'];

    // Update the content in the database
    $query = "UPDATE content SET title = '$newTitle', content = '$newContent' WHERE content_id = '$content_id'";

    if (mysqli_query($conn, $query)) {
        // Content updated successfully
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Success",
            text: "Content updated successfully!",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "content.php";
        });</script>';
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Error",
            text: "Failed to update content!",
            icon: "error",
            confirmButtonText: "OK"
        });</script>';
    }
}
?>