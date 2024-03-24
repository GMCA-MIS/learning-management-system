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

    // Retrieve form data
    $lrn = $_POST['lrn'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $class_id = $_POST['class_id'];
    $dob = $_POST['dob'];
    $user_type = $_POST['user_type'];

    // Check if email exists in any of the tables
    $email_check_query = "SELECT COUNT(*) AS total FROM student WHERE username = '$email'
                            UNION
                            SELECT COUNT(*) AS total FROM teacher WHERE email = '$email'
                            UNION
                            SELECT COUNT(*) AS total FROM coordinators WHERE email = '$email'
                            UNION
                            SELECT COUNT(*) AS total FROM users WHERE username = '$email'";
    $result = mysqli_query($conn, $email_check_query);

    $email_exists = false;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['total'] > 0) {
            $email_exists = true;
            break;
        }
    }

    // Check if LRN exists in the student table
    $lrn_check_query = "SELECT COUNT(*) AS total FROM student WHERE username = '$lrn'";
    $lrn_result = mysqli_query($conn, $lrn_check_query);
    $lrn_row = mysqli_fetch_assoc($lrn_result);

    if ($lrn_row['total'] > 0) {
        echo "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'LRN already exists.',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'manage-students.php';
            }
        });
        </script>";
    } elseif ($email_exists) {
        echo "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An account with this email already exists.',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'manage-students.php';
            }
        });
        </script>";
    } else {
        // Generate a random password
        $length = 10; // The length of the password
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+'; // Allowed characters
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the student data into the database
        $insert_query = "INSERT INTO student (username, firstname, lastname, email, class_id, dob, location, status, password, user_type)
                        VALUES ('$lrn', '$firstname', '$lastname', '$email', '$class_id', '$dob', '../uploads/no-profile-picture-template.png', 'Unregistered', '$hashed_password', 'student')";

// Insert the student data
            $insert_result = mysqli_query($conn, $insert_query);

            if ($insert_result) {
                // Get the last inserted student_id
                $student_id_query = "SELECT LAST_INSERT_ID() as student_id";
                $student_id_result = mysqli_query($conn, $student_id_query);

                if ($student_id_result && mysqli_num_rows($student_id_result) > 0) {
                    $student_row = mysqli_fetch_assoc($student_id_result);
                    $student_id = $student_row['student_id'];

                    // Check if the class_id exists in teacher_class table
                    $check_class_query = "SELECT teacher_class_id, teacher_id FROM teacher_class WHERE class_id = '$class_id'";
                    $result = mysqli_query($conn, $check_class_query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        // If the class_id exists in teacher_class table
                        $row = mysqli_fetch_assoc($result);
                        $teacher_class_id = $row['teacher_class_id'];
                        $teacher_id = $row['teacher_id'];

                        // Insert data into teacher_class_student table
                        $insert_student_class_query = "INSERT INTO teacher_class_student (teacher_class_id, student_id, teacher_id) 
                                          VALUES ('$teacher_class_id', '$student_id', '$teacher_id')";

                        $insert_student_class_result = mysqli_query($conn, $insert_student_class_query);

                        if ($insert_student_class_result) {
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
                            $mail->setFrom("crustandrolls@gmail.com", "Golden Minds Colleges"); // Change "Your Name" to your name or desired sender name
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
                            exit(); // Ensure no further code execution after the redirect
                        } else {
                            header('Location: manage-students.php');
                        }
                    }
                }
            }
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
            $mail->setFrom("crustandrolls@gmail.com", "Golden Minds Colleges"); // Change "Your Name" to your name or desired sender name
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
}
?>



</body>
</html>