<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include('includes/admin_session.php');
include('dbcon.php');

// Check if the request_id is set 
if (isset($_GET["id"]) && is_numeric($_GET["id"]) && isset($_GET["date"])) {
    $id = $_GET["id"];
    $date = $_GET["date"];
    
    // Get the session id
    $session_id = $_SESSION['username'];

    // Update status field to "approved"
    $sql = "UPDATE tor SET status = 'confirmed', receiving_staff = ?, claiming_date = ? WHERE or_number = ?";

    // Prepare and bind parameter
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $session_id, $date, $id); // Bind the admin id, date, and OR number

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
        $mail->Subject = "TOR Payment Confirmed";
        $mail->Body = "Dear $to,\n\nYour TOR request with OR Number $id payment has been confirmed by $session_id.\n\nDate to Claim Document: $date \n\n";

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
    // If request_id is not set or not a valid integer, redirect back to tor_admin.php with an error message
    header("Location: tor_admin.php?delete_error=true");
    exit();
}
?>
