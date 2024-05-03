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
if (isset($_POST['deleted_fee'])) {
    $id = $_POST['delete_ID'];

    $component_charge_id = $_POST['component_charge_id'];
    
    $query = "DELETE FROM component_charge_fees  WHERE ccharge_fees_id = '$id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Success",
            text: "Fee has been deleted successfully!",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "manage-componentfees_bundle.php?component_charge_id='.$component_charge_id.'";
        });</script>';
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Error",
            text: "Failed to delete Fee!",
            icon: "error",
            confirmButtonText: "OK"
        });</script>';
    }





}
?>
<?php 
    // Manage-Users Edit Function 
    if(isset($_POST['update_fees'])) // Button Name
    {       
        // Name attributes are used here, make sure they match your form fields
        $id = $_POST['edit_ID'];
        $intitle = $_POST['intitle'];
        $txtpurpose = $_POST['txtpurpose'];
        $amountfee = $_POST['amountfee'];

        // Corrected the SQL query, added proper quotation marks
        $query = "UPDATE charge_types SET title='$intitle', purpose='$txtpurpose' , amount='$amountfee'  WHERE chargetype_id = '$id'";
        $query_run = mysqli_query($conn, $query);

        if($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Fee\'s detail has been updated successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-typeoffees.php";
            });</script>';
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to update Fee Information!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    } 
?>
<?php
if(isset($_POST['add_fee']))
{
    // Collect form data
    $component_charge_id = $_POST['component_charge_id'];
    $ccid = $_POST['ccid'];
    

    // Database connection (include your database connection file)
    include('dbcon.php');

    // SQL query to insert data into the department table
    $insertQuery = "INSERT INTO  component_charge_fees  (component_charge_id, `chargetype_id`) VALUES ('$component_charge_id', '$ccid')";

    // Execute the query
    if(mysqli_query($conn, $insertQuery)){
        // Data inserted successfully
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Included Another Fee successfully!",
                }).then(function(){
                    window.location.href = "manage-componentfees_bundle.php?component_charge_id='.$component_charge_id.'"; // Redirect to your desired page
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