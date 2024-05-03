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

// Manage Department Delete Function
if (isset($_POST['deletedepartment'])) {
    $id = $_POST['delete_ID'];

    // Check if there are teachers associated with the department_id
    $check_teachers_query = "SELECT COUNT(*) AS teacher_count FROM teacher WHERE department_id = '$id'";
    $check_teachers_result = mysqli_query($conn, $check_teachers_query);
    $teacher_count_row = mysqli_fetch_assoc($check_teachers_result);
    $teacher_count = $teacher_count_row['teacher_count'];

    if ($teacher_count > 0) {
        // Teachers are associated, show an alert
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Warning",
            text: "Cannot delete department. There are teachers associated with this department.",
            icon: "warning",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "manage-departments.php";
        });</script>';
    } else {
        // No teachers associated, proceed with deletion
        $query = "DELETE FROM department WHERE department_id = '$id'";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Department has been deleted successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-departments.php";
            });</script>';
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to delete department!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    }
}
?>

<?php 
    // Manage-Users Edit Function 
    if(isset($_POST['update_departments'])) // Button Name
    {       
        // Name attributes are used here, make sure they match your form fields
        $id = $_POST['edit_ID'];

        $department_name = $_POST['department_name'];
        $dean = "";

        // Corrected the SQL query, added proper quotation marks
        $query = "UPDATE department SET department_name='$department_name' WHERE department_id = '$id'";
        $query_run = mysqli_query($conn, $query);

        if($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Department has been updated successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-departments.php";
            });</script>';
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to update department!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    } 
?>

<?php
if(isset($_POST['add_department']))
{
    // Collect form data
    $department_name = $_POST['department_name'];

    // Database connection (include your database connection file)
    include('dbcon.php');

    // SQL query to insert data into the department table
    $insertQuery = "INSERT INTO department (department_name) VALUES ('$department_name')";

    // Execute the query
    if(mysqli_query($conn, $insertQuery)){
        // Data inserted successfully
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Department added successfully!",
                }).then(function(){
                    window.location.href = "manage-departments.php"; // Redirect to your desired page
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