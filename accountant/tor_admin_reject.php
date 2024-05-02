<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include('includes/admin_session.php');
include('dbcon.php');

// Check if the request_id and reason are set 
if (isset($_GET["id"], $_GET["reason"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];
    $reason = $_GET["reason"];

    // Update status field to "rejected" and the reason field with the provided reason
    $sql = "UPDATE tor SET status = 'rejected', reason = ? WHERE or_number = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $reason, $id);

    // Execute the statement
    if ($stmt->execute()) {
        // Select email from tor table where or_number matches
        $email_sql = "SELECT email FROM tor WHERE or_number = ?";
        $stmt_email = $conn->prepare($email_sql);
        $stmt_email->bind_param("i", $id);

        // Execute the email statement
        $stmt_email->execute();

        // Bind the result variable
        $stmt_email->bind_result($to);

        // Fetch the result
        $stmt_email->fetch();

        // Close the email statement
        $stmt_email->close();

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
        $mail->setFrom("crustandrolls@gmail.com", "Golden Minds Colleges and Academy"); // Change "Your Name" to your name or desired sender name
        $mail->addAddress($to);
        $mail->Subject = "TOR Request Rejected";
        $mail->Body = "Dear $to,\n\nYour TOR request with OR Number $id has been rejected with the following reason:\n\nApplication did not meet the specified $reason\n\nPlease review your application and make necessary adjustments.\n\nThank you.";

        if ($mail->send()) {
            echo "
            <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'TOR request status update sent to the email.',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'tor_admin.php';
                }
            });
            </script>";
        } else {
            echo "
            <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'TOR request status update email sending failed.',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'tor_admin.php';
                }
            });
            </script>";
        }

        // Close the statement and the connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Error executing statement.";
    }
} else {
    // If request_id or reason is not set or not a valid integer, redirect back to tor_admin.php with an error message
    header("Location: tor_admin.php?delete_error=true");
    exit();
}
?>
