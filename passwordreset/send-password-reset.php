<?php
// Include your database connection code here.
$mysqli = require("dbconn.php");

$email = $_POST["email"];

// Check if the email exists in the "teacher" table.
$sqlCheckTeacherEmail = "SELECT * FROM teacher WHERE email = ?";
$stmtCheckTeacherEmail = $mysqli->prepare($sqlCheckTeacherEmail);
$stmtCheckTeacherEmail->bind_param("s", $email);
$stmtCheckTeacherEmail->execute();
$resultTeacher = $stmtCheckTeacherEmail->get_result();

// Check if the email exists in the "student" table.
$sqlCheckStudentEmail = "SELECT * FROM student WHERE email = ?";
$stmtCheckStudentEmail = $mysqli->prepare($sqlCheckStudentEmail);
$stmtCheckStudentEmail->bind_param("s", $email);
$stmtCheckStudentEmail->execute();
$resultStudent = $stmtCheckStudentEmail->get_result();

// Check if the email exists in the "student" table.
$sqlCheckCoordinatorEmail = "SELECT * FROM coordinators WHERE email = ?";
$stmtCheckCoordinatorEmail = $mysqli->prepare($sqlCheckCoordinatorEmail);
$stmtCheckCoordinatorEmail->bind_param("s", $email);
$stmtCheckCoordinatorEmail->execute();
$resultCoordinator = $stmtCheckCoordinatorEmail->get_result();

if ($resultTeacher->num_rows > 0 || $resultStudent->num_rows > 0 || $resultCoordinator->num_rows > 0) {
    // Email exists in either teacher or student table.

    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    // Update teacher table
    $sqlTeacher = "UPDATE teacher
            SET reset_token_hash = ?,
                reset_token_expires_at = ?
            WHERE email = ?";

    $stmtTeacher = $mysqli->prepare($sqlTeacher);
    $stmtTeacher->bind_param("sss", $token_hash, $expiry, $email);
    $stmtTeacher->execute();

    // Update student table
    $sqlStudent = "UPDATE student
            SET reset_token_hash = ?,
                reset_token_expires_at = ?
            WHERE email = ?";

    $stmtStudent = $mysqli->prepare($sqlStudent);
    $stmtStudent->bind_param("sss", $token_hash, $expiry, $email);
    $stmtStudent->execute();

        // Update coordinators table
        $sqlCoordinator = "UPDATE coordinators
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

        $stmtCoordinator = $mysqli->prepare($sqlCoordinator);
        $stmtCoordinator->bind_param("sss", $token_hash, $expiry, $email);
        $stmtCoordinator->execute();


        if ($stmtTeacher->affected_rows > 0 || $stmtStudent->affected_rows > 0 || $stmtCoordinator->affected_rows > 0) {
        $email_body = "We have received a password reset request with the account associated with this email. <br><br>";
        $email_body .= "Please proceed with the link for your password reset.<br>";
        $email_body .= "Click <a href='http://localhost/gmlms/passwordreset/reset-password.php?token=$token'>here</a> to reset your password.";

        $mail = require __DIR__ . "/mailer.php";

        $mail->setFrom("//Your Email", "GMC Management Information System"); // Change "Your Email" to your name or desired sender name
        $mail->addAddress($email);
        $mail->Subject = "Password Reset for MIS Account";
        $mail->Body = $email_body;

        try {
            $mail->send();
            echo "<script>
            alert('Password Request sent, please check your Email.');
            window.location.href = '../login.php';
            </script>";
        } catch (Exception $e) {
            echo "<script>alert('Message could not be sent. Mailer error: {$mail->ErrorInfo}')</script>";
        }
    }
    } else {
        // Email does not exist in either teacher or student table.
        echo "<script>
        alert('Invalid Email Address. Please check your email and try again.');
        window.location.href = 'forgotpassword.php';
        </script>";
    }

$stmtCheckTeacherEmail->close();
$stmtCheckStudentEmail->close();
$mysqli->close();

