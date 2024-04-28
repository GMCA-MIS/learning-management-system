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

    // Manage User Archive Function
    if (isset($_POST['archivestudent'])) {
        $id = $_POST['delete_ID'];

        // Archive from students table
        $student_query = "UPDATE student SET status=0 WHERE student_id = '$id' ";
        $student_query_run = mysqli_query($conn, $student_query);

        if ($student_query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
            title: "Success",
            text: "User has been archive successfully!",
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

    if (isset($_POST['rearchivestudent'])) {
        $id = $_POST['delete_ID1'];

        // Delete from students table
        $student_query = "UPDATE student SET status=1 WHERE student_id = '$id' ";
        $student_query_run = mysqli_query($conn, $student_query);

        if ($student_query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
            title: "Success",
            text: "User has been rearchive successfully!",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "manage-archive-students.php";
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
    if (isset($_POST['edit_student'])) //Button Name
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

        if ($query_run) {
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
                            $mail->Username = "goldenmindcollege@gmail.com"; // your email address
                            $mail->Password = "teom csjx dlat gsqc"; // your email password
                            $mail->setFrom("goldenmindcollege@gmail.com", "Golden Minds Colleges"); // Change "Your Name" to your name or desired sender name
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
    <?php
    require 'includes/PHPMailer.php';
    require 'includes/SMTP.php';
    require 'includes/Exception.php';
    if (isset($_POST['approve_student'])) {
        $id = $_POST['approvedinputid'];
        $check_query = "SELECT * FROM student WHERE student_id = '$id'";
        $check_result = mysqli_query($conn, $check_query);
        if (mysqli_num_rows($check_result) > 0) {
            // Fetch the result row
            $row = mysqli_fetch_assoc($check_result);

            // Access the specific column
            $lrn = $row['username'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $email = $row['email'];
            $strand_id = $row['strand_id'];
            $gradelevel = $row['grade_level'];
            $regular_irregular = $row['is_regular'];
            //check strand
            $check_query_strand = "SELECT * FROM strand WHERE id = '$strand_id'";
            $check_result_strand = mysqli_query($conn, $check_query_strand);
            if (mysqli_num_rows($check_result_strand) > 0) {
                // Fetch the result row
                $row_strand = mysqli_fetch_assoc($check_result_strand);
                $strand_name = $row_strand['name'];
                $strand_fname = $row_strand['full_name_strand'];
                
                    // Check if there are any existing classes with less than 2 regular students
                    $existing_classes_not_full = false;

                    //select active school year 
                    $check_query_school_year = "SELECT * FROM school_year where status = 1 ORDER BY school_year_id DESC LIMIT 1 ";
                    $check_result_school_year = mysqli_query($conn,  $check_query_school_year);
                    $row_school_year = mysqli_fetch_assoc($check_result_school_year);
                    $current_school_year = $row_school_year['school_year_id'];
                    // echo $current_school_year;
                    //check strand that has a same school year
                    $check_query_strand_student = "SELECT * FROM class WHERE strand = '$strand_fname' and school_year_id = '$current_school_year' and SUBSTRING_INDEX(SUBSTRING_INDEX(class_name, '-', 2), ' ', -1) = '$strand_name-$gradelevel'";
                    $check_result_strand_student = mysqli_query($conn, $check_query_strand_student);
                    $class_ids = [];

                    if (mysqli_num_rows($check_result_strand_student) > 0) {
                        while ($row_strand_student = mysqli_fetch_assoc($check_result_strand_student)) {
                            $class_id = $row_strand_student['class_id'];
                            $class_ids[] = $class_id;

                            $check_query_strand_student_st = "SELECT COUNT(*) as id FROM student WHERE class_id = '$class_id' AND is_regular = 1";
                            $check_result_strand_student_st = mysqli_query($conn, $check_query_strand_student_st);

                            if ($check_result_strand_student_st && mysqli_num_rows($check_result_strand_student_st) > 0) {
                                $row_strand_sta = mysqli_fetch_assoc($check_result_strand_student_st);
                                $counts_of_students = $row_strand_sta['id'];

                                if ($counts_of_students < 50 && $existing_classes_not_full == false ) {


                                    $password = bin2hex(random_bytes(8));

                                    $hashed_password = md5($password);
                                    
                                    $queryaw1 = "INSERT student_class SET student_id='$id', class_id ='$class_id'";
                                    mysqli_query($conn, $queryaw1);

                                    $query = "UPDATE student SET picture='../uploads/student.jpg', class_id ='$class_id', password='$hashed_password' WHERE student_id='$id'";
                                    mysqli_query($conn, $query);

                                    // GET Subjects & Teachers assigned UNDER THIS CLASS
                                    $querygetteachers = "SELECT * FROM teacher_class WHERE class_id = '$class_id' ";
                                    $resultteachers = mysqli_query($conn, $querygetteachers);
                                    if (mysqli_num_rows($resultteachers) > 0) {
                                        while ($rowgetteachers = mysqli_fetch_assoc($resultteachers)) {
                                            $teacher_class_id_get = $rowgetteachers['teacher_class_id'];
                                            $teacher_id_get = $rowgetteachers['teacher_id'];
                                            
                                            $queryteacherclasstudent = "INSERT INTO teacher_class_student  (teacher_class_id,student_id,teacher_id) VALUES ($teacher_class_id_get,$id,$teacher_id_get)";
                                            mysqli_query($conn, $queryteacherclasstudent);
                                        }
                                    }

                                
                                    // Email content
                                    $email_body = "Dear $firstname $lastname,\n\n";
                                    $email_body .= "Your account has been created successfully.\n";
                                    $email_body .= "Here are your login credentials:\n";
                                    $email_body .= "Username: $lrn\n";
                                    $email_body .= "Password: $password\n"; 
                                
                                    $mail = new PHPMailer();
                                    $mail->isSMTP();
                                    $mail->Host = "smtp.gmail.com";
                                    $mail->SMTPAuth = true;
                                    $mail->SMTPSecure = "tls";
                                    $mail->Port = 587;
                                    $mail->Username = "crustandrolls@gmail.com";
                                    $mail->Password = "dqriavmkaochvtod";
                                    $mail->setFrom("crustandrolls@gmail.com", "Golden Minds Colleges");
                                    $mail->addAddress($email);
                                    $mail->Subject = "LMS Credentials";
                                    $mail->Body = $email_body;
                                
                                    // Check if mail sent successfully
                                    if (!$mail->send()) {
                                        echo '<script>alert("Error sending email: ' . $mail->ErrorInfo . '");</script>';
                                    } else {
                                        $existing_classes_not_full = true; // Set flag to indicate existing class not full
                                        echo '<script>Swal.fire({
                                            title: "Success",
                                            text: "Student has been approved successfully!",
                                            icon: "success",
                                            confirmButtonText: "OK"
                                        }).then(function() {
                                            window.location.href = "manage-students.php";
                                        });</script>';
                                        break;
                                    }
                                }     
                            }                           
                        }
                    } else {
                        $newsection = $strand_name . '-' . $gradelevel . '-A';
                        $query_class_name = "INSERT INTO class (class_name,strand,school_year_id) VALUES ('$newsection','$strand_fname','$current_school_year')";
                        mysqli_query($conn, $query_class_name);
                        // Retrieve the ID of the inserted data
                        $inserted_class_id = mysqli_insert_id($conn);
                        
                        $password = bin2hex(random_bytes(8));

                        $hashed_password = md5($password);

                        $queryaw1 = "INSERT student_class SET student_id='$id', class_id ='$inserted_class_id'";
                        mysqli_query($conn, $queryaw1);

                        $queryaw = "UPDATE student SET picture='../uploads/student.jpg', class_id ='$inserted_class_id', password='$hashed_password' WHERE student_id='$id'";
                        mysqli_query($conn, $queryaw);
                        
                        $email_body = "Dear $firstname $lastname,\n\n";
                        $email_body .= "Your account has been created successfully.\n";
                        $email_body .= "Here are your login credentials:\n";
                        $email_body .= "Username: $lrn\n";
                        $email_body .= "Password: $password\n"; 
                        
                        $mail = new PHPMailer();
                        $mail->isSMTP();
                        $mail->Host = "smtp.gmail.com";
                        $mail->SMTPAuth = true;
                        $mail->SMTPSecure = "tls";
                        $mail->Port = 587;
                        $mail->Username = "crustandrolls@gmail.com";
                        $mail->Password = "dqriavmkaochvtod";
                        $mail->setFrom("crustandrolls@gmail.com", "Golden Minds Colleges");
                        $mail->addAddress($email);
                        $mail->Subject = "LMS Credentials";
                        $mail->Body = $email_body;
                        
                        // Check if mail sent successfully
                        if ($mail->send()) {
                            echo '<script>
                            Swal.fire({
                                title: "Success",
                                text: "Student has been approved successfully!",
                                icon: "success",
                                confirmButtonText: "OK",
                                timer: 3000
                            }).then(function() {
                                Swal.fire({
                                    title: "Warning",
                                    text: "Generated a New Class Please Assigned Teacher immediately!",
                                    icon: "warning",
                                    confirmButtonText: "OK",
                                    timer: 3000,
                                    allowOutsideClick: false
                                }).then(function() {
                                    window.location.href = "manage-students.php";
                                });
                            });
                           
                            
                            </script>';
                            exit;
                        } else {
                            echo '<script>alert("Error sending email: ' . $mail->ErrorInfo . '");</script>';
                        }                        
                    }
                    // If all existing classes have 2 regular students, create a new class
                    if (!$existing_classes_not_full) {

                        $check_query_strand_studentqwe = "SELECT * FROM class WHERE strand = '$strand_fname' AND SUBSTRING_INDEX(SUBSTRING_INDEX(class_name, '-', 2), ' ', -1) = '$strand_name-$gradelevel' ORDER BY class_id DESC LIMIT 1";
                        $check_result_strand_studentqwe = mysqli_query($conn, $check_query_strand_studentqwe);

                        if (mysqli_num_rows($check_result_strand_studentqwe) > 0) {

                            $row_row = mysqli_fetch_assoc($check_result_strand_studentqwe);
                            $class_name = $row_row['class_name'];

                            // Extract the middle part of the class name
                            $parts = explode('-', $class_name);
                            $middle_part = $parts[1]; // Extract the middle part

                            // Replace the middle part with the new grade level
                            $new_class_name = $parts[0] . "-" . $gradelevel . "-" . $parts[2];

                            // Increment the last character to get the next section
                            $last_character = substr($new_class_name, -1); // Get the last character
                            $next_section = chr(ord($last_character) + 1); // Increment the last character

                            $class_nameu = substr($new_class_name, 0, -1) . $next_section;

                            $query_class_name = "INSERT INTO class (class_name,strand,school_year_id) VALUES ('$class_nameu','$strand_fname','$current_school_year')";
                            mysqli_query($conn, $query_class_name);

                            // Retrieve the ID of the inserted data
                            $inserted_class_id = mysqli_insert_id($conn);

                            $password = bin2hex(random_bytes(8));

                            $hashed_password = md5($password);

                            $queryaw1 = "INSERT student_class SET student_id='$id', class_id ='$inserted_class_id'";
                            mysqli_query($conn, $queryaw1);
                            
                            $queryaw = "UPDATE student SET picture='../uploads/student.jpg', class_id ='$inserted_class_id', password='$hashed_password' WHERE student_id='$id'";
                            mysqli_query($conn, $queryaw);
                             
                            $email_body = "Dear $firstname $lastname,\n\n";
                            $email_body .= "Your account has been created successfully.\n";
                            $email_body .= "Here are your login credentials:\n";
                            $email_body .= "Username: $lrn\n";
                            $email_body .= "Password: $password\n"; 
                            
                            $mail = new PHPMailer();
                            $mail->isSMTP();
                            $mail->Host = "smtp.gmail.com";
                            $mail->SMTPAuth = true;
                            $mail->SMTPSecure = "tls";
                            $mail->Port = 587;
                            $mail->Username = "crustandrolls@gmail.com";
                            $mail->Password = "dqriavmkaochvtod";
                            $mail->setFrom("crustandrolls@gmail.com", "Golden Minds Colleges");
                            $mail->addAddress($email);
                            $mail->Subject = "LMS Credentials";
                            $mail->Body = $email_body;
                            
                            // Check if mail sent successfully
                            if ($mail->send()) {
                                echo '<script>
                                
                                Swal.fire({
                                    title: "Success",
                                    text: "Student has been approved successfully!",
                                    icon: "success",
                                    confirmButtonText: "OK",
                                    timer: 3000
                                }).then(function() {
                                    Swal.fire({
                                        title: "Warning",
                                        text: "Generated a New Class Please Assigned Teacher immediately!",
                                        icon: "warning",
                                        confirmButtonText: "OK",
                                        timer: 3000,
                                        allowOutsideClick: false
                                    }).then(function() {
                                        window.location.href = "manage-students.php";
                                    });
                                });
                               
                                
                                </script>';
                                exit;
                            } else {
                                echo '<script>alert("Error sending email: ' . $mail->ErrorInfo . '");</script>';
                            }     
                        }
                    }

                    //search if the strand is exist
                    // $check_query_class = "SELECT * FROM class WHERE class_name = '$strand_name'";
                    // $check_result_class = mysqli_query($conn, $check_query_class);
                    // if (mysqli_num_rows($check_result_class) < 1) {
                    //     $strandnewsection =   $strand_name;
                    //     $query_class = "INSERT INTO class (class_name,strand) VALUES ('$prodname','$strand_fname')";

                    //     $query_run_class = mysqli_query($conn, $query_class);
                    //     if ($query_run_class) {
                    //     }
                    // }
                 
            }
        }
    }
    ?>
<?php
    //PROMOTE / MOVE to GRADE 12
    if (isset($_POST['movetograde12'])) //Button Name
    {   
        //declare parameters
        $student_id = $_POST['student_id'];
        $class_id = "";
        $class_name  = "";
        $strand = "";

        // get active school year
        $query = "SELECT school_year_id FROM school_year WHERE status = 1";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) != 0) {
            while ($rowsclass = mysqli_fetch_array($result)) {
                $school_year_id = $rowsclass['school_year_id'];
            }
        }

        // get student information and class info
        $query = "SELECT student_id,s.class_id,grade_level,class_name,strand 
                    FROM student s 
                    INNER JOIN class c 
                    ON s.class_id = c.class_id 
                    WHERE student_id = $student_id ";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) != 0)
        {
            while ($rowstudent = mysqli_fetch_array($result)) {
                $student_id = $rowstudent['student_id'];
                $class_id = $rowstudent['class_id'];
                $grade_level = $rowstudent['grade_level'];
                $class_name = $rowstudent['class_name'];
                $strand = $rowstudent['strand'];
            }
        }
        
        // divide the section
        $classname_exploded = explode("-",$class_name);
        $class_shortname = $classname_exploded[0];
        $class_grade = $classname_exploded[1];
        $class_section = $classname_exploded[2];

        // check if student section is still grade 11
        if($class_grade == "11" ){
            $query = "SELECT class_id FROM class WHERE class_name = '$class_shortname-12-$class_section' ";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) != 0) {
                // found existing class
                while ($rowsclass12 = mysqli_fetch_array($result)) {
                   
                   echo $class_id12 = $rowsclass12['class_id'];

                    // Check if the class_id exists in teacher_class table
                    $check_class_query = "SELECT teacher_class_id, teacher_id FROM teacher_class WHERE class_id = '$class_id12'";
                    $result = mysqli_query($conn, $check_class_query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        // If the class_id exists in teacher_class table
                        $row = mysqli_fetch_assoc($result);
                        $teacher_class_id = $row['teacher_class_id'];
                        $teacher_id = $row['teacher_id'];

                        // Insert data into teacher_class_student table
                        $insert_student_class_query = "INSERT INTO teacher_class_student (teacher_class_id, student_id, teacher_id)   VALUES ('$teacher_class_id', '$student_id', '$teacher_id')";
                        $insert_student_class_result = mysqli_query($conn, $insert_student_class_query);
                    }
                    // insert student to class
                    $queryaw1 = "INSERT student_class SET student_id='$student_id', class_id ='$class_id12'";
                    mysqli_query($conn, $queryaw1);
                    // insert student
                    $queryaw = "UPDATE student SET class_id = '$class_id12' , grade_level = '12' WHERE student_id='$student_id' ";
                    if(mysqli_query($conn, $queryaw)){
                        echo '<script>Swal.fire({
                            title: "Success",
                            text: "Student has been promoted successfully!",
                            icon: "success",
                            confirmButtonText: "OK",
                            timer: 3000,
                            allowOutsideClick: false
                        }).then(function() {
                            window.location.href = "manage-students.php";
                        });</script>';
                    }

                }
            }else{ 
                // no existing class NEED TO generate new class
                $query = "INSERT INTO  class (class_name,strand,school_year_id,status) VALUES('$class_shortname-12-$class_section','$strand',$school_year_id,1) ";
                $result = mysqli_query($conn, $query);
                $class_id12 = $conn->insert_id;

                $queryaw1 = "INSERT student_class SET student_id='$student_id', class_id ='$class_id12'";
                mysqli_query($conn, $queryaw1);
                    
                $queryaw = "UPDATE student SET class_id ='$class_id12' WHERE student_id='$student_id'";
                if(mysqli_query($conn, $queryaw)){
                    echo '<script>
                    
                    Swal.fire({
                        title: "Success",
                        text: "Student has been promoted successfully!",
                        icon: "success",
                        confirmButtonText: "OK",
                        timer: 3000,
                        allowOutsideClick: false
                    }).then(function() {
                        Swal.fire({
                            title: "Warning",
                            text: "New Class is generated, Please assigned Teachers!",
                            icon: "success",
                            confirmButtonText: "OK",
                            timer: 3000,
                            allowOutsideClick: false
                        }).then(function() {
                            window.location.href = "manage-students.php";
                        });

                    });
                    
                    </script>';
                }

                

            }
        }

        
        


        //$query = "UPDATE student SET username='$lrn', firstname='$firstname', lastname='$lastname', email='$email', class_id='$class_id', dob ='$dob' WHERE student_id='$id'  ";
       // $query_run = mysqli_query($conn, $query);
        /*
        if ($query_run) {
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
        } */
    }
    ?>
</body>

</html>