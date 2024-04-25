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
if (isset($_POST['delete_class'])) {
    $id = $_POST['delete_ID'];

    // Check if there are students associated with the class_id
    $check_students_query = "SELECT COUNT(*) AS student_count FROM student WHERE class_id = '$id'";
    $check_students_result = mysqli_query($conn, $check_students_query);
    $student_count_row = mysqli_fetch_assoc($check_students_result);
    $student_count = $student_count_row['student_count'];

    if ($student_count > 0) {
        // Students are associated, show an alert
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Warning",
            text: "Cannot delete class. There are students associated with this class.",
            icon: "warning",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "manage-strand.php";
        });</script>';
    } else {
        // No students associated, proceed with deletion
        $query = "DELETE FROM class WHERE class_id = '$id'";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Class has been deleted successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-class.php";
            });</script>';
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to delete class!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    }
}
?>


<?php 
    // Manage-Users Edit Function 
    if(isset($_POST['edit_class'])) // Button Name
    {       
        // Name attributes are used here, make sure they match your form fields
        $id = $_POST['edit_ID'];
        $strand = $_POST['strand']; // Remove the dollar sign from '$_POST['$strand']'
        $class_name = $_POST['class_name'];
 

        // Corrected the SQL query, added proper quotation marks
        $query = "UPDATE class SET class_name='$class_name', strand='$strand' WHERE class_id = '$id'";
        $query_run = mysqli_query($conn, $query);

        if($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Class has been updated successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-class.php";
            });</script>';
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to update Class!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    } 
?>

<?php
if(isset($_POST['add_class']))
{
    $class_name = $_POST['class_name'];
    $strand = $_POST['strand']; // Remove the dollar sign from '$_POST['$strand']'
    
    // Database connection (include your database connection file)
    include('dbcon.php');
    
    // SQL query to insert data into the class table
    $insertQuery = "INSERT INTO class (class_name, strand) VALUES ('$class_name', '$strand')";
    

    // Execute the query
    if(mysqli_query($conn, $insertQuery)){
        // Data inserted successfully
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Class added successfully!",
                }).then(function(){
                    window.location.href = "manage-class.php"; // Redirect to your desired page
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