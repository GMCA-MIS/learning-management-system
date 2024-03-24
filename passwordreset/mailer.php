<?php
    require 'includes/PHPMailer.php';
    require 'includes/SMTP.php';
    require 'includes/Exception.php';
    
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



$mail = new PHPMailer(true);

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls";
$mail->Port = 587;
$mail->Username = "goldenmindcollege@gmail.com"; // your email address 
$mail->Password = "teom csjx dlat gsqc"; // your email password  
$mail->setFrom("goldenmindcollege@gmail.com", "Golden Minds Colleges Management Information System"); // Change "Your Name" to your name or desired sender name
$mail->addAddress($email);
$mail->Subject = "MIS Credentials";
$mail->Body = $email_body;



$mail->isHtml(true);

return $mail;