
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
if (isset($_POST['Import'])) {
    include('dbcon.php');

    $file = $_FILES['file']['tmp_name'];
    $handle = fopen($file, "r");

    $addedTeachersCount = 0; // Variable to keep track of added teachers

    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        $firstname = mysqli_real_escape_string($conn, $data[0]);
        $lastname = mysqli_real_escape_string($conn, $data[1]);
        $department = mysqli_real_escape_string($conn, $data[2]);
        $email = mysqli_real_escape_string($conn, $data[3]);
        $dob = mysqli_real_escape_string($conn, $data[4]);
        $specialization = mysqli_real_escape_string($conn, $data[5]);
        $user_type = 'teacher'; // Assuming user type is constant for all entries

        // Check if username or email already exist
        $usernameExistQuery = "SELECT COUNT(*) as count FROM teacher WHERE email = '$email'";
        $emailExistQuery = "SELECT COUNT(*) as count FROM coordinators WHERE email = '$email' 
                            UNION SELECT COUNT(*) FROM teacher WHERE email = '$email' 
                            UNION SELECT COUNT(*) FROM student WHERE email = '$email'";
        
        $usernameExistResult = mysqli_query($conn, $usernameExistQuery);
        $emailExistResult = mysqli_query($conn, $emailExistQuery);

        $usernameExist = mysqli_fetch_assoc($usernameExistResult)['count'];
        $emailExist = 0;
        while ($row = mysqli_fetch_assoc($emailExistResult)) {
            $emailExist += $row['count'];
        }

        if ($usernameExist > 0 || $emailExist > 0) {
            continue; // Skip adding if username or email already exists
        }

        // Generate a random password
        $length = 10;
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insert_query = "INSERT INTO teacher (username, firstname, lastname, department_id, email, dob, teacher_stat, specialization, location, password, user_type)
                        VALUES ('Teacher', '$firstname', '$lastname', '$department', '$email',  '$dob', 'activated', '$specialization', '../uploads/no-profile-picture-template.png', '$hashed_password', '$user_type')";

        if (mysqli_query($conn, $insert_query)) {
            // Increment added teachers count
            $addedTeachersCount++;

            // Send email with login credentials
            $email_body = "Dear $firstname $lastname,\n\n";
            $email_body .= "Your account has been created successfully.\n";
            $email_body .= "Here are your login credentials:\n";
            $email_body .= "Username: $email\n";
            $email_body .= "Password: $password\n"; // Note: You should consider a more secure way to send passwords.

            require_once 'includes/PHPMailer.php';
            require_once 'includes/SMTP.php';
            require_once 'includes/Exception.php';

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;
            $mail->Username = "crustandrolls@gmail.com"; // your email address
            $mail->Password = "dqriavmkaochvtod"; // your email password
            $mail->setFrom("crustandrolls@gmail.com", "Sta. Lucia Senior High School Learning Management System");
            $mail->addAddress($email);
            $mail->Subject = "LMS Credentials";
            $mail->Body = $email_body;

            if ($mail->send()) {
                echo "
                <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Teacher added successfully. Login credentials sent to $email.',
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
                    text: 'Failed to send email with login credentials. Please try again.',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = 'manage-teachers.php';
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
                text: 'Failed to add teachers. Please try again.',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'manage-teachers.php';
                }
            });
            </script>";
            echo "Failed to add teachers: " . mysqli_error($conn);
        }
    }

    fclose($handle);
    mysqli_close($conn);

    // Display success message with the number of Teachers added
    echo "
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Added $addedTeachersCount teacher(s) successfully.',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = 'manage-teachers.php';
        }
    });
    </script>";
}
?>
