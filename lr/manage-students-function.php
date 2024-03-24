<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/newheader.css">
</head>
<body>


<?php
include('dbcon.php');

// Manage User Delete Function
if(isset($_POST['delete_student']))
{
    $id = $_POST['delete_ID'];

    // Delete from students table
    $student_query = "DELETE FROM student WHERE student_id = '$id' ";
    $student_query_run = mysqli_query($conn, $student_query);

    if($student_query_run) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Success",
            text: "User has been deleted successfully!",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "manage-students.php";
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
    //Manage-Users Edit Function 
    if(isset($_POST['edit_student'])) //Button Name
    {       
        //Name attributes ang kinukuha dito pero dapat kapangalan ng nasa database
        $id = $_POST['edit_ID'];

        $lrn = $_POST['lrn'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $class_id = $_POST['class_id'];
        $dob = $_POST['dob'];
      
        

        $query = "UPDATE student SET username='$lrn', firstname='$firstname', lastname='$lastname', email='$email', class_id='$class_id', dob ='$dob' WHERE student_id='$id'  ";
        $query_run = mysqli_query($conn, $query);

        if($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "User has been updated successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-students.php";
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
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    ?>
<?php
if (isset($_POST['add_student'])) {
    include('dbcon.php');


$lrn = $_POST['lrn'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$class_id = $_POST['class_id'];
$dob = $_POST['dob'];
$user_type = $_POST['user_type'];

// Generate a random password
$length = 10; // The length of the password
$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+'; // Allowed characters
$password = '';
for ($i = 0; $i < $length; $i++) {
    $password .= $characters[random_int(0, strlen($characters) - 1)];
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$insert_query = "INSERT INTO student (username, firstname, lastname, email, class_id, dob, location,  status, password, user_type)
                VALUES ('$lrn', '$firstname', '$lastname', '$email', '$class_id', '$dob',  '../uploads/no-profile-picture-template.png', 'Unregistered', '$hashed_password', 'student')";

if (mysqli_query($conn, $insert_query)) {
    // Send email with login credentials
    $email_body = "Dear $firstname $lastname,\n\n";
    $email_body .= "Your account has been created successfully.\n";
    $email_body .= "Here are your login credentials:\n";
    $email_body .= "Username: $lrn\n";
    $email_body .= "Password: $password\n"; // Note: You should consider a more secure way to send passwords.

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
    $mail->setFrom("crustandrolls@gmail.com", "Sta. Lucia Senior High School Learning Management System"); // Change "Your Name" to your name or desired sender name
    $mail->addAddress($email);
    $mail->Subject = "LMS Credentials";
    $mail->Body = $email_body;

    if ($mail->send()) {
        echo "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Student added successfully. Login credentials sent to $email.',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'manage-students.php';
            }
        });
        </script>";
    } else {
        echo "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to send email with login credentials. Please try again.',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'manage-students.php';
            }
        });
        </script>";
    }
} else {
    echo "
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Failed to add student. Please try again.',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = 'manage-students.php';
        }
    });
    </script>";
}
}
?>

</body>
</html>