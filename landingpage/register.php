<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include('dbcon.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file uploads for grade_slip
    $grade_slip_target_dir = "../attachment/";
    $grade_slip_target_file = $grade_slip_target_dir . basename($_FILES["grade_slip"]["name"]);
    $grade_slip_uploadOk = 1;
    $grade_slip_imageFileType = strtolower(pathinfo($grade_slip_target_file, PATHINFO_EXTENSION));
    // Handle file uploads for cor
    $cor_target_dir = "../attachment/";
    $cor_target_file = $cor_target_dir . basename($_FILES["cor"]["name"]);
    $cor_uploadOk = 1;
    $cor_imageFileType = strtolower(pathinfo($cor_target_file, PATHINFO_EXTENSION));
    // Handle file uploads for good_moral
    $good_moral_target_dir = "../attachment/";
    $good_moral_target_file = $good_moral_target_dir . basename($_FILES["good_moral"]["name"]);
    $good_moral_uploadOk = 1;
    $good_moral_imageFileType = strtolower(pathinfo($good_moral_target_file, PATHINFO_EXTENSION));

    $tor_target_dir = "../attachment/";
    $tor_target_file = $tor_target_dir . basename($_FILES["tor"]["name"]);
    $tor_uploadOk = 1;
    $tor_imageFileType = strtolower(pathinfo($tor_target_file, PATHINFO_EXTENSION));

    $others_target_dir = "../attachment/";
    $others_target_file = $others_target_dir . basename($_FILES["others"]["name"]);
    $others_uploadOk = 1;
    $others_imageFileType = strtolower(pathinfo($others_target_file, PATHINFO_EXTENSION));

    // Function to generate a unique filename
    function generateUniqueFilename($file_name, $type)
    {
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $basename = pathinfo($file_name, PATHINFO_FILENAME);
        $unique_suffix = "_" . uniqid() . "." . $extension;
        return $type . $unique_suffix;
    }

    function handleFileUpload($file, &$uploadOk, $imageFileType, $type)
    {
        if (empty($file["name"])) {
            // echo "File name is empty. Skipping file upload for this file.";
        }

        if ($uploadOk == 0) {
            // echo "Sorry, your file was not uploaded.";
        } elseif ($file["size"] > 14 * 1024 * 1024) {
            // echo "Sorry, your file is too large.";
        } elseif (!in_array($imageFileType, array("pdf", "jpg", "jpeg"))) {
            // echo "Sorry, only PDF, JPG, JPEG files are allowed.";
        }

        // Generate unique filename
        $unique_file_name = generateUniqueFilename($file["name"], $type); // Use $type to customize filename
        $target_file = "../attachment/" . $unique_file_name;

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $unique_file_name;
        } else {
            // echo "Sorry, there was an error uploading your file.";
        }
    }
    
    $grade_slip_uploaded = handleFileUpload($_FILES["grade_slip"], $grade_slip_uploadOk, $grade_slip_imageFileType, "grade_slip");
    $cor_uploaded = handleFileUpload($_FILES["cor"], $cor_uploadOk, $cor_imageFileType, "cor");
    $good_moral_uploaded = handleFileUpload($_FILES["good_moral"], $good_moral_uploadOk, $good_moral_imageFileType, "good_moral");
    $tor_uploaded = handleFileUpload($_FILES["tor"], $tor_uploadOk, $tor_imageFileType, "tor");
    $others_uploaded = handleFileUpload($_FILES["others"], $others_uploadOk, $others_imageFileType, "others");

    //if ($grade_slip_uploaded && $cor_uploaded && $good_moral_uploaded) {
    if ($grade_slip_uploaded) {

        // Extract POST data
        $lastname = $_POST["lastname"];
        $firstname = $_POST["firstname"];
        $middle_initial = $_POST["middle_initial"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $course = $_POST["course"];
        $dob = $_POST["dob"];
        $pob = $_POST["pob"];
        $highschool = $_POST["highschool"];
        $other_colleges = $_POST["other_colleges"];
        $highschool_address = $_POST["highschool_address"];
        $lrn = $_POST["username"];
        $grade_level = $_POST["grade_level"];
        $is_regular = $_POST["is_regular"];
        $datesubmmited = date_default_timezone_set('Asia/Manila');

        // Insert student data into the database
        $sql = "INSERT INTO student ( 	enrollment_date , username, lastname, firstname, middle_initial, email, location, strand_id, dob, pob, highschool, other_colleges, highschool_address, grade_level, is_regular) 
                VALUES ( '$datesubmmited', '$lrn','$lastname', '$firstname', '$middle_initial', '$email', '$address', '$course', '$dob', '$pob', '$highschool', '$other_colleges', '$highschool_address','$grade_level','$is_regular')";
        if (mysqli_query($conn, $sql)) {
            // Get the ID of the inserted student record
            $inserted_id = mysqli_insert_id($conn);
            
            // Insert attachment data into the database
            $data = [
                $grade_slip_uploaded, $cor_uploaded, $good_moral_uploaded, $tor_uploaded, $others_uploaded
            ];
            foreach ($data as $uploaded_file) {
                if (!empty($uploaded_file)) {
                    // Determine the description based on the uploaded file
                    $description = "";
                    if ($uploaded_file == $grade_slip_uploaded) {
                        $description = "Grade Slip";
                    } elseif ($uploaded_file == $cor_uploaded) {
                        $description = "Certificate of Recognition";
                    } elseif ($uploaded_file == $good_moral_uploaded) {
                        $description = "Good Moral";
                    } elseif ($uploaded_file == $tor_uploaded) {
                        $description = "TOR";
                    } else {
                        $description = "Others";
                    }
                    // Insert attachment data into the database
                    $document_sql = "INSERT INTO attachment (student_id, description, filename) 
                                     VALUES ('$inserted_id', '$description', '$uploaded_file')";
                    mysqli_query($conn, $document_sql);
                }
            }

            // Send email to the student
            require 'includes/PHPMailer.php';
            require 'includes/SMTP.php';
            require 'includes/Exception.php';

            $email_body = "Hi, $firstname $lastname,<br><br>";
            $email_body .= "Your commitment to furthering your education with us is truly commendable, and we are thrilled to have you join our community of passionate learners. At Golden Minds Colleges And Academy we strive to provide an enriching and supportive environment where every student can thrive academically, socially, and personally.<br>";
            $email_body .= "By choosing to embark on this journey with us, you have placed your trust in our faculty, staff, and resources, and we are fully dedicated to helping you achieve your goals and aspirations. Whether you're pursuing your academic interests, developing new skills, or preparing for your future career, we are here to support you every step of the way.<br>";
            $email_body .= "To complete the enrollment process, we kindly ask you to upload your payment confirmation using the following link: <br>";
            $email_body .= '<a href="https://gmca.online/landingpage/uploadpayment.php?uppstdid=' . $inserted_id . '">Upload Payment Confirmation</a><br>';
            $email_body .= "You can check your enrollment form by following the link: <br>";
            $email_body .= '<a href="https://gmca.online/landingpage/enrollment_form.php?id=' . $inserted_id . '">Enrollment Form</a>';

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
            $mail->Subject = "LMS Enrollment";
            $mail->isHTML(true);
            $mail->Body = $email_body;

            try {
                $mail->send();
                // Display success message
                echo "<div></div>";
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                        Swal.fire({
                            title: 'Success',
                            text: 'Proof of payment sent successfully. We will email your credentials once we have verified all your requirements.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'index.html';
                            }
                        });
                    </script>";
                exit();
            } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error in submission";
    }
}
} else {
    // Redirect back to the form if accessed directly
    header("Location: index.html");
    exit();
}
