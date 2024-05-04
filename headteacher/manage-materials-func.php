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
    // Manage-Users Edit Function 
    if(isset($_POST['approvematerial'])) // Button Name
    {       
        // Name attributes are used here, make sure they match your form fields
        $id = $_POST['delete_ID'];


        // Corrected the SQL query, added proper quotation marks
        $query = "UPDATE  files SET status='1' WHERE file_id  = '$id'";
        $query_run = mysqli_query($conn, $query);

        if($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Material has been updated successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-materials.php";
            });</script>';
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to Approved Material!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    } 
?>




</body>
</html>