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
include('includes/lr_session.php');  ?>

<?php
include('dbcon.php');
include('initialize.php');
?>
             
             <?php
if (isset($_POST['add_book'])) {
    // Handle the form submission
    
    // Establish a database connection (assuming you have already done this)
    include("dbcon.php");

    $title = $_POST['title'];
    $description = $_POST['desc'];
    $author = $_POST['author'];
    $category_id = $_POST['category'];
    $publication_year = $_POST['publication_year'];
    $call_number = $_POST['call_number'];
    $book_status = $_POST['book_status'];

    // Handle the uploaded photo
    if (isset($_FILES['book_cover']) && isset($_FILES['file_path'])) {
        $coverFile = $_FILES['book_cover'];
        $fileFile = $_FILES['file_path'];

        // Check for errors
        if ($coverFile['error'] === UPLOAD_ERR_OK && $fileFile['error'] === UPLOAD_ERR_OK) {
            $uploadPath = '../libraryimages/';  // Specify the directory where you want to store uploaded images
            $fileUploadPath = '../libraryfiles/';  // Specify the directory where you want to store uploaded files

            // Generate unique file names
            $newCoverFileName = 'book_cover_' . uniqid() . '_' . $coverFile['name'];
            $newFileFileName = uniqid() . '_' . $fileFile['name'];

            // Set the destination paths
            $coverDestination = $uploadPath . $newCoverFileName;
            $fileDestination = $fileUploadPath . $newFileFileName;

            // Move the uploaded files to their respective directories
            if (move_uploaded_file($coverFile['tmp_name'], $coverDestination) && move_uploaded_file($fileFile['tmp_name'], $fileDestination)) {
                // File uploads were successful, set book_status to 2
           

                // Insert the book data into the database
                $insertQuery = "INSERT INTO booklist (book_title, book_description, author, category_id, publication_year, call_number, book_cover, file_path, book_status) 
                                VALUES ('$title', '$description', '$author', $category_id, $publication_year, $call_number, '$coverDestination', '$fileDestination', '$book_status')";

                if (mysqli_query($conn, $insertQuery)) {
                    // Book added successfully
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo '<script>Swal.fire({
                        title: "Success",
                        text: "Book added successfully!",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "manage-books.php";
                    });</script>';
                } else {
                    echo 'Error adding the book: ' . mysqli_error($conn);
                }
            } else {
                echo 'Error moving the files to the destination.';
            }
        } else {
            echo 'File upload error: ' . $coverFile['error'] . ' / ' . $fileFile['error'];
        }
    }
}
?>


<?php 

include ('dbcon.php');
   //Approve book
    if(isset($_POST['approve_book'])) // Button Name
    {       
        // Name attributes are used here, make sure they match your form fields
        $book_id = $_POST['book_id'];

        // Corrected the SQL query, added proper quotation marks
        $query = "UPDATE booklist SET book_status='Available' WHERE book_id = '$book_id'";
        $query_run = mysqli_query($conn, $query);

        if($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Book has been Approved!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-book-approval.php";
            });</script>';
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to approve book!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    } 
?>

<?php
// Manage Delete Book Function
if (isset($_POST['deny_book'])) {
    // Assuming $book_id is defined somewhere in your code
    $book_id = $_POST['delete_ID'];

    // Use prepared statement to prevent SQL injection
    $query = "DELETE FROM booklist WHERE book_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $book_id);
    $query_run = mysqli_stmt_execute($stmt);

    if ($query_run) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Success",
            text: "Book approval has been denied successfully!",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "manage-book-approval.php";
        });</script>';
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Error",
            text: "Failed to deny book approval!",
            icon: "error",
            confirmButtonText: "OK"
        });</script>';
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<?php
if (isset($_POST['edit_book'])) {
    // Handle the form submission
    include("dbcon.php");
    $book_id = $_POST['edit_book_id'];
    $title = $_POST['edit_title'];
    $description = $_POST['edit_description'];
    $author = $_POST['edit_author'];
    $category_id = $_POST['edit_category'];
    $publication_year = $_POST['edit_publication_year'];
    $call_number = $_POST['edit_call_number'];
    $book_status = $_POST['edit_book_status'];

   
                $insertQuery = "UPDATE booklist SET book_title = '$title', book_description = '$description', author = '$author', category_id = '$category_id', publication_year = '$publication_year', 
                call_number = '$call_number', book_status = '$book_status' WHERE book_id = $book_id";
                              
                if (mysqli_query($conn, $insertQuery)) {
                    // Book added successfully
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo '<script>Swal.fire({
                        title: "Success",
                        text: "Book updated successfully!",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "manage-books.php";
                    });</script>';
                } else {
                    echo 'Error adding the book: ' . mysqli_error($conn);
                }
            } else {
                echo '';
            }
       
?>



<?php
include('dbcon.php');

// Manage User Delete Function
if (isset($_POST['delete_book'])) {
    $id = $_POST['delete_ID'];
        $query = "DELETE FROM booklist WHERE book_id = '$id' ";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Book has been deleted successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-books.php";
            });</script>';
        } else {
            // Delete query failed
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to delete Book!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    }
?>



<?php
include('dbcon.php');

// Manage User Delete Function
if (isset($_POST['archive_book'])) {
    $id = $_POST['archive_ID'];
        $query = "UPDATE booklist SET book_status = 'Archived' WHERE book_id = '$id' ";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Book has been archived successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-books.php";
            });</script>';
        } else {
            // Delete query failed
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to archive Book!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    }
?>



<?php
include('dbcon.php');

// Manage User Delete Function
if (isset($_POST['restore_book'])) {
    $id = $_POST['restore_ID'];
        $query = "UPDATE booklist SET book_status = 'Available' WHERE book_id = '$id' ";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Book has been restored successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-books.php";
            });</script>';
        } else {
            // Delete query failed
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to restore Book!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    }
?>