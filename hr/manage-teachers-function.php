<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers</title>
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
if(isset($_POST['delete_instructors']))
{
    $id = $_POST['delete_ID'];

    $query = "DELETE FROM teacher WHERE teacher_id = '$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Success",
            text: "User has been deleted successfully!",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "manage-teachers.php";
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
include('dbcon.php');
    //Manage-instructors Edit Function 
    if(isset($_POST['edit_instructors'])) //Button Name
    {       
        //Name attributes ang kinukuha dito pero dapat kapangalan ng nasa database
        $id = $_POST['edit_ID'];
        $department_id = $_POST['department_id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $user_type = $_POST['user_type'];

        
        $specialization = "";
        
        foreach ($_POST['specialization'] as $a){
            $specialization .=  $a . ",";
        }
      
        $query = "UPDATE teacher SET department_id='$department_id', firstname='$firstname', lastname='$lastname', email='$email', dob ='$dob', user_type='teacher', specialization='$specialization' WHERE teacher_id='$id'";
        $query_run = mysqli_query($conn, $query);

        if($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "User has been updated successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-teachers.php";
            });</script>';
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to update user!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    } 
?>

<?php
include('dbcon.php');

if (isset($_POST['add_instructor'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $department_id = $_POST['department'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $user_type = $_POST['user_type'];

    $objarray1 = array();
    $objarray1 = $_POST['specialization'];
    $specialization = "" ; 
    foreach ($objarray1 as $a){
        $specialization .=  $a . ",";
    }

    // Define the characters to use in the random password
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+';

    // Shuffle the characters and select the first 10 to create the password
    $password = substr(str_shuffle($characters), 0, 10);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate username
    $year = date('y', strtotime($dob));
    $username = substr($firstname, 0, 2) . $lastname . $year;

    $query = mysqli_query($conn, "SELECT * FROM teacher WHERE username = '$username'") or die(mysqli_error($conn));
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        echo "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Username Already Exists.',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'manage-teachers.php';
            }
        });
        </script>";
    } else {
        // Insert teacher data
       // mysqli_query($conn, "INSERT INTO teacher (username, firstname, lastname, department_id, teacher_stat, dob, location, email, password, user_type, specialization)
            //VALUES ('$username', '$firstname', '$lastname', '$department_id', 'Activated', '$dob', '../uploads/teacher.png', '$email', '$hashed_password', 'teacher', '$specialization')") or die(mysqli_error());
       
       mysqli_query($conn, "INSERT INTO teacher (username, firstname, lastname, department_id, teacher_stat, dob, location, email, password, user_type, specialization)
        VALUES ('$username', '$firstname', '$lastname', '$department_id', 'Activated', '$dob', '../uploads/teacher.png', '$email', '', 'teacher', '$specialization')") or die(mysqli_error());
        $last_id = $conn->insert_id;
        $query ="CALL fillattendance( $last_id , DATE(CONCAT(YEAR(CURDATE()),'-1-1')),DATE(CONCAT(YEAR(CURDATE()),'-12-31'))); ";
        $query_run=mysqli_query($conn, $query);

if (mysqli_affected_rows($conn) > 0) {

    /*
    // Create the email body
    $email_body = "Dear $firstname $lastname,\n\n";
    $email_body .= "Your account has been created successfully.\n";
    $email_body .= "Here are your login credentials:\n";
    $email_body .= "Username: $email\n";
    $email_body .= "Password: $password\n"; // Note: You should consider a more secure way to send passwords.

    // Send the email
    require 'includes/PHPMailer.php';
    require 'includes/SMTP.php';
    require 'includes/Exception.php';
    
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->Username = "crustandrolls@gmail.com"; // your email address
    $mail->Password = "dqriavmkaochvtod"; // your email password
    $mail->setFrom("crustandrolls@gmail.com", "Golden Minds colleges and Academy"); // Change "Your Name" to your name or desired sender name
    $mail->addAddress($email);
    $mail->Subject = "LMS Credentials";
    $mail->Body = $email_body;
    
    
    
    if ($mail->send()) {
        echo "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            //text: 'Teacher added successfully. Login credentials sent to the email.',
            //text: 'Teacher added successfully.',

        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'manage-teachers.php';
            }
        });
        </script>";
    } else {
        echo "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Teacher added successfully, but email sending failed.',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'manage-teachers.php';
            }
        });
        </script>";
    }
    */

    echo "
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        //text: 'Teacher added successfully. Login credentials sent to the email.',
        //text: 'Teacher added successfully.',

    }).then((result) => {
        if (result.isConfirmed) {
            window.location = 'manage-teachers.php';
        }
    });
    </script>";
} else {
    echo "
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Teacher creation failed.',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = 'manage-teachers.php';
        }
    });
    </script>";
}
        echo "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Teacher added successfully.',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'manage-teachers.php';
            }
        });
        </script>";
    }
}
    
?>




</body>
</html>