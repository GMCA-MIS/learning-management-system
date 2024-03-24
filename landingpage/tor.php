
<?php
// Include your database connection file
include 'dbcon.php';

// Initialize variables
$lastname = "";
$firstname = "";
$middle_initial = "";
$email = "";
$address = "";
$course = "";
$dob = "";
$pob = "";
$highschool = "";
$other_colleges = "";
$highschool_address = "";
$gmc_admission_date = "";
$sem_attended = "";
$tor_purpose = "";
$doc_type = "";

// Generate a unique OR number
function generateOrNumber()
{
    // Date today
    $dateToday = date("ymd");

    // Initialize variable
    $combinedNumber = '';

    // Define the maximum number of attempts to generate a unique number
    $maxAttempts = 20;

    // For loop to generate a unique number
    for ($i = 0; $i < $maxAttempts; $i++) {
        // Generate a random 5-digit number
        $randomNumber = rand(10000, 99999);

        // Concatenate the date and the random number
        $combinedNumber = $dateToday . $randomNumber . $randomNumber;

        // Check if the combined number already exists in the database
        global $conn;
        $sql = "SELECT COUNT(*) AS count FROM tor WHERE or_number = '$combinedNumber'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        // If the combined number is unique, break out of the loop
        if ($row['count'] == 0) {
            return $combinedNumber;
        }
    }

    // If the maximum number of attempts is reached without finding a unique number, handle the error
    die("Failed to generate a unique number. Please try again later.");
}

// Assign form data to variables
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middle_initial = $_POST['middle_initial'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $course = $_POST['course'];
    $dob = $_POST['dob'];
    $pob = $_POST['pob'];
    $highschool = $_POST['highschool'];
    $other_colleges = $_POST['other_colleges'];
    $highschool_address = $_POST['highschool_address'];
    $gmc_admission_date = $_POST['gmc_admission_date'];
    $sem_attended = $_POST['sem_attended'];
    $tor_purpose = $_POST['tor_purpose'];
    $doc_type = $_POST['doc_type'];

    // Check if a file is uploaded
    if (isset($_FILES['creds_submitted'])) {
        $file = $_FILES['creds_submitted'];

        // Extract file details
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        // Check if there is no upload error
        if ($fileError === 0) {
            // Generate a unique OR number
            $orNumber = generateOrNumber();

            // Move the uploaded file to the desired location
            $fileDestination = '../admin/creds_submitted/' . $orNumber . '_' . $fileName;
            move_uploaded_file($fileTmpName, $fileDestination);

            try {
                // Insert data into the database with the generated unique number and file path
                $sql = "INSERT INTO tor (lastname, firstname, middle_initial, email, address, course, dob, pob, highschool, other_colleges, highschool_address, gmc_admission_date, creds_submitted, sem_attended, tor_purpose, or_number, doc_type) 
                VALUES ('$lastname', '$firstname', '$middle_initial', '$email', '$address', '$course', '$dob', '$pob', '$highschool', '$other_colleges', '$highschool_address', '$gmc_admission_date', '$fileDestination', '$sem_attended', '$tor_purpose', '$orNumber', '$doc_type')";

                // Execute the query
                if (mysqli_query($conn, $sql)) {
                    // Success message
                    echo "<div></div>";
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo "<script>
                            Swal.fire({
                                title: 'Success',
                                text: 'Form submission success',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = 'index.html';
                            });
                        </script>";
                } else {
                    // Error message
                    echo "<div></div>";
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo "<script>
                            Swal.fire({
                                title: 'Error',
                                text: 'Form submission failed',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = 'tor.html';
                            });
                        </script>";
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "There was an error uploading your file.";
        }
    }
}
?>
