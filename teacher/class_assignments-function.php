<?php 
include('teacher_session.php');
?>
<?php
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
include('dbcon.php');
include('initialize.php');


?>



<?php
if(isset($_POST['add_assignment'])) {


// Include database connection details
require("opener_db.php");

$conn = $connector->DbConnector();
$id_class = $_POST['id_class'];
$name = $_POST['name'];
$filedesc = $_POST['desc'];
$max_score = intval($_POST['max_score']); // Ensure max_score is an integer
$deadline = $_POST['deadline'];
$get_id = $_GET['id'];
$learning_objectives = $_POST['learning_objectives'];

// Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
    global $conn;
    $str = trim($str);
    if (get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysqli_real_escape_string($conn, $str);
}

// Initialize an array to store file locations
$fileLocations = [];

// Process each uploaded file
$uploadDirectory = "../uploads/"; // Directory where files will be uploaded
$atLeastOneFileUploaded = false; // Flag to track whether any file was uploaded successfully

if (!empty($_FILES['uploaded_files']['name'][0])) {
    foreach ($_FILES['uploaded_files']['name'] as $key => $value) {
        $input_name = $_FILES['uploaded_files']['name'][$key];
        $rd2 = mt_rand(1000, 9999) . "_File";
        $filename = basename($input_name);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        $newname = $uploadDirectory . $rd2 . "_" . $filename;

        // Attempt to move the uploaded file to its new place
        if (move_uploaded_file($_FILES['uploaded_files']['tmp_name'][$key], $newname)) {
            $fileLocations[] = $newname;
            $atLeastOneFileUploaded = true;
        }
    }
}

// If no files were uploaded, set an empty array for file locations
if (!$atLeastOneFileUploaded) {
    $fileLocations[] = ''; // You can also set it as null or any other suitable value

}

// Insert the assignment into the database with file locations as a JSON array
$fileLocationsJson = json_encode($fileLocations);
$name_notification = 'Add Assignment file name titled:' . ' <b>' . $name . '</b>';
$date_of_notification = date('Y-m-d H:i:s'); // Get the current date and time
$link = 'class_assignments.php';

// Prepare the SQL statement
$query = "INSERT INTO notification (notification, date_of_notification, teacher_class_id, link) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);

// Bind parameters and execute the statement
mysqli_stmt_bind_param($stmt, 'ssis', $name_notification, $date_of_notification, $id_class, $link);
mysqli_stmt_execute($stmt);

$qry = "INSERT INTO assignment (fdesc, fdatein, teacher_id, class_id, fname, max_score, deadline,learning_objectives, floc, status) VALUES ('$filedesc', NOW(), '$teacher_id', '$id_class', '$name', '$max_score', '$deadline', '$learning_objectives', '$fileLocationsJson', 'Available')";
$query = mysqli_query($conn, $qry);

if ($query) {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Assignment Created!',
            text: 'The assignment has been successfully created.',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'class_assignments.php<?php echo '?id=' . $get_id; ?>';
            }
        });
    </script>
    <?php
} else {
}}
?>


<?php 


//require("opener_db.php");

// Edit Assignment
if(isset($_POST['edit_assignment'])) { // Button Name
    // Retrieve assignment details from the form
    $assignment_id = $_POST['assignment_id'];
    $name = $_POST['name'];
    $filedesc = $_POST['desc'];
    $max_score = intval($_POST['max_score']); // Ensure max_score is an integer
    $deadline = $_POST['deadline'];
    $learning_objectives = $_POST['learning_objectives'];
    $post_id = $_POST['post_id'];
    $get_id = $_POST['id_class'];


    // Handle file uploads (if needed)
    if (!empty($_FILES['uploaded_files']) && is_array($_FILES['uploaded_files'])) {
        // Process and update the file locations
        $fileLocations = [];
        $uploadDirectory = "../uploads/";
    
        foreach ($_FILES['uploaded_files']['name'] as $key => $value) {
            $input_name = $_FILES['uploaded_files']['name'][$key];
            $rd2 = mt_rand(1000, 9999) . "_File";
            $filename = basename($input_name);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            $newname = $uploadDirectory . $rd2 . "_" . $filename;

            // Attempt to move the uploaded file to its new place
            if (move_uploaded_file($_FILES['uploaded_files']['tmp_name'][$key], $newname)) {
                $fileLocations[] = $newname;
            }
        }

        // Convert the file locations to JSON format
        $fileLocationsJson = json_encode($fileLocations);
    } else {
        // If no files were uploaded, set to an empty JSON array
        $fileLocationsJson = json_encode([]); // Empty JSON array
    }
    // Update the assignment in the database
    $query = "UPDATE assignment SET fname='$name', fdesc='$filedesc', max_score='$max_score', deadline='$deadline', learning_objectives='$learning_objectives', floc='$fileLocationsJson' WHERE assignment_id = '$assignment_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        // Success message
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Success",
            text: "Assignment has been updated successfully!",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "view_class_assignment.php?id=' . $get_id . '&post_id=' . $post_id . '";
            // Redirect to the assignment management page
        });</script>';
    } else {
        // Error message
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Error",
            text: "Failed to update Assignment!",
            icon: "error",
            confirmButtonText: "OK"
        });</script>';
    }
}
?>



<?php
if(isset($_POST['add_assignment2'])) {




$conn = $connector->DbConnector();
$id_class = $_POST['id_class'];
$max_score = intval($_POST['max_score']); // Ensure max_score is an integer
$get_id = $_GET['id'];
$name = $_POST['name'];
$learning_objectives = $_POST['learning_objectives'];

// Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
    global $conn;
    $str = trim($str);
    if (get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysqli_real_escape_string($conn, $str);
}


// // Insert the assignment into the database with file locations as a JSON array
// $fileLocationsJson = json_encode($fileLocations);
// $name_notification = 'Add Assignment file name titled:' . ' <b>' . $name . '</b>';
// $date_of_notification = date('Y-m-d H:i:s'); // Get the current date and time
// $link = 'class_assignments.php';

// // Prepare the SQL statement
// $query = "INSERT INTO notification (notification, date_of_notification, teacher_class_id, link) VALUES (?, ?, ?, ?)";
// $stmt = mysqli_prepare($conn, $query);

// // Bind parameters and execute the statement
// mysqli_stmt_bind_param($stmt, 'ssis', $name_notification, $date_of_notification, $id_class, $link);
// mysqli_stmt_execute($stmt);

$qry = "INSERT INTO assignment (fname, fdatein, teacher_id, class_id, max_score, learning_objectives, status, type) VALUES ('$name', NOW(), '$teacher_id', '$id_class',  '$max_score', '$learning_objectives',  'Available', '1')";
$query = mysqli_query($conn, $qry);

if ($query) {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Assignment Created!',
            text: 'The assignment has been successfully created.',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'class_assignments.php<?php echo '?id=' . $get_id; ?>';
            }
        });
    </script>
    <?php
} else {
}

}
?>


<!-- For updating score assignment -->
<?php
// Include your database connection file if not already included

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_scoreAssignmentf2f"])) {
    // Get the values from the form
    $get_id = $_POST["get_id"];
    $assignment_id = $_POST["assignment_id"];
    $grades = $_POST["grades"];

    // Flag to check if any update or insertion fails
    $isError = false;

    // Loop through the grades and insert or update in the task_result table
    foreach ($grades as $student_id => $grade) {
        // Check if the task_id already exists for the student in task_result
        $check_query = "SELECT * FROM student_assignment WHERE student_id = '$student_id' AND assignment_id = '$assignment_id'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // If the record already exists, update the grade
            $update_query = "UPDATE student_assignment SET grade = '$grade' WHERE student_id = '$student_id' AND assignment_id = '$assignment_id'";
            $update_result = mysqli_query($conn, $update_query);

            if (!$update_result) {
                $isError = true;
                break;
            }
        } else {
            // If the record doesn't exist, insert a new record
            $insert_query = "INSERT INTO student_assignment (student_id, assignment_id, grade) VALUES ('$student_id', '$assignment_id', '$grade')";
            $insert_result = mysqli_query($conn, $insert_query);

            if (!$insert_result) {
                $isError = true;
                break;
            }
        }
    }

    
    // Check if there was an error during update or insertion
    if (!$isError) {
        // Success notification
        echo '<script>
            Swal.fire({
                title: "Scores Updated",
                icon: "success",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "view_class_assignment_f2f.php?id=' . $get_id . ' &post_id=' . $assignment_id . '";
            });
        </script>';
    } else {
        // Error notification
        echo '<script>
            Swal.fire({
                title: "Update Failed",
                text: "An error occurred while updating records.",
                icon: "error",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            });
        </script>';
    }
}
?>


<?php
// Assuming database connection and session handling are already present

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && isset($_GET['id'])  && isset($_GET['get_id']) && $_GET['action'] === 'archive') {
    $assignmentId = $_GET['id'];
    $get_id = $_GET['get_id'];

    // Update the assignment status to "Archived"
    $updateQuery = "UPDATE assignment SET status = 'Archived' WHERE assignment_id = '$assignmentId'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Display success message using SweetAlert
        echo '<script>
            Swal.fire({
                title: "Assignment archived successfully!",
                icon: "success",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "class_assignments.php?id=' . $get_id . '";
            });
        </script>';
       
        exit();
    } else {
        // Handle the case where the update fails, maybe show an error message
        // Error notification
        echo '<script>
            Swal.fire({
                title: "Update Failed",
                text: "An error occurred.",
                icon: "error",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            });
        </script>';
    }
}
?>

<?php
// Assuming database connection and session handling are already present

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && isset($_GET['id']) && isset($_GET['get_id']) && $_GET['action'] === 'available') {
    $assignmentId = $_GET['id'];
    $get_id = $_GET['get_id'];

    // Update the assignment status to "Available"
    $updateQuery = "UPDATE assignment SET status = 'Available' WHERE assignment_id = '$assignmentId'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Display success message using SweetAlert
        echo '<script>
            Swal.fire({
                title: "Assignment restored successfully!",
                icon: "success",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "class_assignments.php?id=' . $get_id . '";
            });
        </script>';
       
        exit();
    } else {
        // Handle the case where the update fails, maybe show an error message
        // Error notification
        echo '<script>
            Swal.fire({
                title: "Update Failed",
                text: "An error occurred.",
                icon: "error",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            });
        </script>';
    }
}
?>