<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Coordinators</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/newheader.css">
</head>
<body>
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
 ?>

<?php
include('dbcon.php');


//Manage User Delete Function
if(isset($_POST['delete_coordinators']))
{
    $id = $_POST['delete_ID'];
    $idget = $_POST['id'];

    $query = "DELETE FROM users WHERE user_id = '$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Success",
            text: "User has been deleted successfully!",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "manage-accounts.php?id='.$idget.'";
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

?>

<?php 

    //Manage-instructors Edit Function 
    if(isset($_POST['edit_coordinators'])) //Button Name
    {       
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $password = $_POST['editpwd'];
        $id = $_POST['id'];


        // Insert teacher data
        $query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname',`password` = '$password' where username = '$username' ";
        $query_run = mysqli_query($conn, $query);

        if($query_run){
            echo '<script>Swal.fire({
                title: "Success",
                text: "Succesfully Updated the Account!",
                icon: "success",
                confirmButtonText: "OK",
                timer: 2000
            }).then(function() {
                window.location.href = "manage-accounts.php?id='.$id.'";
            });</script>';
        }
    } 
?>

<?php


if (isset($_POST['add_coordinator'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['pwd'];
    $id = $_POST['id'];


    $sql = "SELECT * FROM users WHERE username = '$username' ";

      $result = mysqli_query($conn,$sql);      
      $row = mysqli_num_rows($result);      
      $count = mysqli_num_rows($result);

      if($count >= 1) {
            echo '<script>Swal.fire({
                title: "Error",
                text: "Username Exist, Please choose another!!",
                icon: "error",
                confirmButtonText: "OK",
                timer: 2000
            }).then(function() {
                window.location.href = "manage-accounts.php?id='.$id.'";
            });</script>';
      }  else{

            // Insert teacher data
            $query = "INSERT INTO users (firstname, lastname,  location,  `password`, user_type,username)
            VALUES ('$firstname', '$lastname', '../uploads/gmc-logo.png', '$password', 'registrar','$username')";
            $query_run = mysqli_query($conn, $query);

            if($query_run){
                echo '<script>Swal.fire({
                    title: "Success",
                    text: "Succesfully Registered Account!",
                    icon: "success",
                    confirmButtonText: "OK",
                    timer: 2000
                }).then(function() {
                    window.location.href = "manage-accounts.php?id='.$id.'";
                });</script>';
            }
      }

    
    
}
?>




</body>
</html>