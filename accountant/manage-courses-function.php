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
if (isset($_POST['delete_course'])) {
    $id = $_POST['delete_ID'];
    $get_id = $_POST['get_id'];

    // Check if there are related records in teacher_class table
    $check_query = "SELECT * FROM teacher_class WHERE subject_id = '$id' AND school_year_id = $get_id";
    $check_query_run = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_query_run) > 0) {
        // There are related records, handle accordingly (e.g., show an error message)
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Error",
            text: "Cannot delete the subject. Related records found in assigned subjects.",
            icon: "error",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "manage-courses.php?id=' . $get_id . '";
        });</script>';
    } else {
        // No related records, proceed with deletion
        $query = "DELETE FROM subject WHERE subject_id = '$id'";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Subject has been deleted successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-courses.php?id=' . $get_id . '";
            });</script>';
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to delete user!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    }
}
?>


<?php 
    // Manage-Users Edit Function 
    if(isset($_POST['edit_course'])) // Button Name
    {       
        // Name attributes are used here, make sure they match your form fields
        $id = $_POST['edit_ID'];
        $get_id = $_POST['get_id'];
        $course_code = $_POST['course_code'];
        $course_title = $_POST['course_title'];
        $description = $_POST['description'];
        $course_type = $_POST['course_type'];
        $track = $_POST['track'];


        
        if($_FILES["images"]["error"] != 0) {
            //stands for any kind of errors happen during the uploading
            
            $query = "UPDATE subject SET subject_code='$course_code', subject_title='$course_title', description='$description', subject_type ='$course_type', track = '$track' WHERE subject_id = '$id'";

        } else{
            // Image upload 
            $uploaddir  = '../uploads/';
            $uploadfile = $uploaddir . time() . basename($_FILES['images']['name']);

            if (move_uploaded_file($_FILES['images']['tmp_name'], $uploadfile)) {

                
            } 
            $query = "UPDATE subject SET photo = '$uploadfile', subject_code='$course_code', subject_title='$course_title', description='$description', subject_type ='$course_type', track = '$track' WHERE subject_id = '$id'";
        }

        
        // Corrected the SQL query, added proper quotation marks
        $query_run = mysqli_query($conn, $query);

        if($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Course has been updated successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-courses.php?id=' . $get_id . '";
            });</script>';
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to update Course!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    } 
?>

<?php
if(isset($_POST['add_course']))
{
    // Collect form data
    $course_code = $_POST['course_code'];
    $course_title = $_POST['course_title'];
    $description = $_POST['description'];
    $course_type = $_POST['course_type'];
    $track = $_POST['track'];
    $get_id = $_POST['get_id'];


 
    if($_FILES["images"]["error"] != 0) {
        //stands for any kind of errors happen during the uploading
        $uploadfile = "../uploads/1713538808pngwing.png";

    } else{
        // Image upload 
        $uploaddir  = '../uploads/';
        $uploadfile = $uploaddir . time() . basename($_FILES['images']['name']);

        if (move_uploaded_file($_FILES['images']['tmp_name'], $uploadfile)) {

            
        } 

    }



    // Database connection (include your database connection file)
    include('dbcon.php');

    // SQL query to insert data into the Subject table
    $insertQuery = "INSERT INTO subject (subject_code, subject_title, description, subject_type, track , photo) VALUES ('$course_code', '$course_title', '$description', '$course_type', '$track', '$uploadfile' )";

    // Execute the query
    if(mysqli_query($conn, $insertQuery)){
        // Data inserted successfully
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Subject added successfully!",
                }).then(function(){
                    window.location.href = "manage-courses.php?id=' . $get_id . '";
                });
              </script>';
    } else {
        // Error occurred while inserting data
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