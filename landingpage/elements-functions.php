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



         
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


    //Manage-Users Edit Function 
    if (isset($_POST['contactus_emailer'])) //Button Name
    {



        // Retrieve form data
        
        $name = $_POST['name'];
        $email = $_POST['email'];
        $human = $_POST['human'];
        $message = $_POST['message'];


         // Send email with login credentials
         $email_body = $message . ",\n\n";
         $email_body .= "Name:  $name .\n";
         $email_body .= "Email Address:  $email .\n";
    
         require 'includes/PHPMailer.php';
         require 'includes/SMTP.php';
         require 'includes/Exception.php';


         //PHOTOCOPY
         if (isset($_POST['copy'])){

            
            $mail2 = new PHPMailer();
            $mail2->isSMTP();
            $mail2->Host = "smtp.gmail.com";
            $mail2->SMTPAuth = true;
            $mail2->SMTPSecure = "tls";
            $mail2->Port = 587;
            $mail2->Username = "crustandrolls@gmail.com"; // your email address
            $mail2->Password = "dqriavmkaochvtod"; // your email password
            $mail2->setFrom("goldenmindsbulacan@gmail.com", "Golden Minds Colleges"); // Change "Your Name" to your name or desired sender name
            $mail2->addAddress($email);
            $mail2->Subject = "Photo copy of mail sent to goldenmindsbulacan@gmail.com";
            $mail2->Body = $email_body;
            if($mail2->send()){
            }
        }  
        // INQUIRY BY CLIENTS SENT TO GMC
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = "smtp.gmail.com";
         $mail->SMTPAuth = true;
         $mail->SMTPSecure = "tls";
         $mail->Port = 587;
         $mail->Username = "crustandrolls@gmail.com"; // your email address
         $mail->Password = "dqriavmkaochvtod"; // your email password
         $mail->setFrom($email, $email); // Change "Your Name" to your name or desired sender name
         $mail->addAddress("goldenmindsbulacan@gmail.com");
         $mail->Subject = "Inquiry by " . $name ;
         $mail->Body = $email_body;

         

        

         if ($mail->send()) {
             echo "
                <script>
                Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Succesfully sent to goldenmindsbulacan@gmail.com. ',
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'elements.html';
                }
                });
                </script>";
                        } else {
                            echo "
                <script>
                Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to send email. Please try again.',
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'elements.html';
                }
                });
                </script>";
        }
    }
    ?>

</body>

</html>