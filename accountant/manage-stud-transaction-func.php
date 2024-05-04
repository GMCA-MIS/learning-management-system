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

include('includes/admin_session.php');
$admin_user = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id'") or die(mysqli_error());

while ($row = mysqli_fetch_array($admin_user)) {
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $location = $row['location'];
}

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
    $student_id = $_POST['student_id'];
    $ccid = $_POST['ccid'];
    $amount = $_POST['amount'];
    

    // Database connection (include your database connection file)
    include('dbcon.php');

    // SQL query to insert data into the department table
    $insertQuery = "INSERT INTO  student_charge  (chargetype_id, `student_id`, `amount`, `chargeby`, created_date) VALUES ('$ccid','$student_id', '$amount','$firstname $lastname',NOW())";

    // Execute the query
    if(mysqli_query($conn, $insertQuery)){
        // Data inserted successfully
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Included Another Fee successfully!",
                }).then(function(){
                    window.location.href = "manage-stud-transcation.php?student_id='.$student_id.'"; // Redirect to your desired page
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

if(isset($_POST['submit_payment']))
{
    // Collect form data
    $student_id = $_POST['student_id'];
    $paymenttype = $_POST['paymenttype'];
    $drpstatus = $_POST['drpstatus'];
    $referencenumber = $_POST['referencenumber'];
    $pyamount = $_POST['pyamount'];
    $txtremarks = $_POST['txtremarks'];
    

    // Database connection (include your database connection file)
    include('dbcon.php');

    // SQL query to insert data into the department table
    $insertQuery = "INSERT INTO  student_payment  (`student_id`, `payment_type`, `status`, payment_amount,referencenumber , remarks, handled_by, payment_date )
     VALUES ('$student_id','$paymenttype', '$drpstatus', '$pyamount', '$referencenumber' , '$txtremarks' , '$firstname $lastname',NOW())";

    // Execute the query
    if(mysqli_query($conn, $insertQuery)){
        // Data inserted successfully
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Payment Submitted Succesfully !",
                }).then(function(){
                    window.location.href = "manage-stud-transcation.php?student_id='.$student_id.'"; // Redirect to your desired page
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


if(isset($_POST['submit_componentsfees']))
{
    // Collect form data
    $componentchargeiddrop = $_POST['componentchargeiddrop'];
    $student_id = $_POST['student_id'];
    
    $querydept = "SELECT *
    FROM  component_charge_fees cc INNER JOIN charge_types ct ON cc.chargetype_id = ct.chargetype_id WHERE cc.component_charge_id = $componentchargeiddrop ";
    $query_rundept = mysqli_query($conn, $querydept);

    if (mysqli_num_rows($query_rundept) > 0) {
        while ($rowdept = mysqli_fetch_assoc($query_rundept)) {
            
            $insertQuery = "INSERT INTO  student_charge  (chargetype_id, `student_id`, `amount`, `chargeby`, created_date) 
            VALUES ('".$rowdept['chargetype_id']."','".$student_id."', '".$rowdept['amount']."','$firstname $lastname',NOW())";
            mysqli_query($conn, $insertQuery);

        }
    }

    


    // Execute the query
    if($query_rundept){
        // Data inserted successfully
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Fees under component are succesfully included!",
                }).then(function(){
                    window.location.href = "manage-stud-transcation.php?student_id='.$student_id.'"; // Redirect to your desired page
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

if(isset($_POST['update_paymentid']))
{
    // Collect form data
    $paymentid = $_POST['paymentid'];
    $student_id = $_POST['student_id'];
    
    $querydept = "UPDATE student_payment SET status = 'Paid' WHERE stud_payment_id = $paymentid";
    $query_rundept = mysqli_query($conn, $querydept);

    // Execute the query
    if($query_rundept){
        // Data inserted successfully
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Successfully set PAID the transaction!",
                }).then(function(){
                    window.location.href = "manage-stud-transcation.php?student_id='.$student_id.'"; // Redirect to your desired page
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