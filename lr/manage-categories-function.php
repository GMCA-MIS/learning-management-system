<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Instructors</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/newheader.css">
</head>
<body>


<?php
include('dbcon.php');

// Manage User Delete Function
if (isset($_POST['delete_category'])) {
    $id = $_POST['delete_ID'];

    // Check if there are books associated with this category
    $check_query = "SELECT * FROM booklist WHERE category_id = '$id'";
    $check_query_run = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_query_run) > 0) {
        // Books are associated with this category, show warning and redirect
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Error",
            text: "Cannot delete category. Books are still connected with the category",
            icon: "error",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "manage-categories.php";
        });</script>';
    } else {
        // No books associated, delete the category
        $query = "DELETE FROM category WHERE category_id = '$id' ";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Category has been deleted successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-categories.php";
            });</script>';
        } else {
            // Delete query failed
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to delete Category!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    }
}
?>


<?php 
    // Manage-Users Edit Function 
    if(isset($_POST['edit_category'])) // Button Name
    {       
        // Name attributes are used here, make sure they match your form fields
        $id = $_POST['edit_ID'];

        $category_name = $_POST['category_name'];
 

        // Corrected the SQL query, added proper quotation marks
        $query = "UPDATE category SET category_name='$category_name' WHERE category_id = '$id'";
        $query_run = mysqli_query($conn, $query);

        if($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Category has been updated successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-categories.php";
            });</script>';
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to update Category!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    } 
?>

<?php
if (isset($_POST['add_category'])) {
    // Collect form data
    $category_name = $_POST['category_name'];

    // Define the directory path to save the image
    $targetDirectory = '../libraryimages/';
    
    // Get the uploaded file information
    $image = $_FILES['image'];

    // Extract the file extension
    $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION);

    // Generate a unique filename
    $uniqueFilename = '../libraryimages/' . uniqid('category_') . '.' . $imageExtension;  // Include 'image/' in the path

    // Set the full path to save the image
    $targetFile = $targetDirectory . $uniqueFilename;

    // Database connection (include your database connection file)
    include('dbcon.php');

    // SQL query to insert data into the category table
    $insertQuery = "INSERT INTO category (category_name, image) VALUES ('$category_name', '$uniqueFilename')";

    // Execute the query and move the uploaded file to the directory
    if (mysqli_query($conn, $insertQuery) && move_uploaded_file($image['tmp_name'], $targetFile)) {
        // Data inserted and file uploaded successfully
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Category added successfully!",
                }).then(function(){
                    window.location.href = "manage-categories.php"; // Redirect to your desired page
                });
              </script>';
    } else {
        // Error occurred while inserting data or uploading the file
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Error: ' . mysqli_error($conn) . '",
                });
              </script>';
    }

    // Close the database connection
    mysqli_close($conn);
}
?>





</body>
</html>