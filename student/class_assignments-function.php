<?php 
include('student_session.php');
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
if (isset($_POST['upload_assignment'])) {
    // Include database connection details

    $post_id = $_POST['post_id']; // Retrieve the post_id from the form
    $get_id = $_POST['get_id']; // Retrieve the post_id from the form
    $filedesc = $_POST['desc'];

    // Check if the assignment has been graded
    $previousGrade = 0; // Default grade if not graded
    $checkGradeQuery = "SELECT grade FROM student_assignment WHERE assignment_id = '$post_id' AND student_id = '$student_id' AND grade_status = 1";
    $checkGradeResult = mysqli_query($conn, $checkGradeQuery);
    if (mysqli_num_rows($checkGradeResult) > 0) {
        $row = mysqli_fetch_assoc($checkGradeResult);
        $previousGrade = $row['grade'];
    }

    // Initialize an array to store file locations
    $fileLocations = [];

    $uploadDirectory = "../uploads/"; // Directory where files will be uploaded

    // Process each uploaded file
    if (!empty($_FILES['uploaded_files']['name'])) {
        $fileCount = count($_FILES['uploaded_files']['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            $filename = $_FILES['uploaded_files']['name'][$i];
            $tmpName = $_FILES['uploaded_files']['tmp_name'][$i];

            // Generate a unique name for the file
            $rd2 = mt_rand(1000, 9999) . "_File";
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $newname = $uploadDirectory . $rd2 . "_" . $filename;

            // Attempt to move the uploaded file to its new location
            if (move_uploaded_file($tmpName, $newname)) {
                $fileLocations[] = $newname;
            } else {
                // Handle file upload errors here
                echo "Error uploading file: " . $filename;
            }
        }
    }

    // Insert the assignment into the database with file locations as a JSON array
    $fileLocationsJson = json_encode($fileLocations);

    // Insert or update the assignment with grade information
    $insertOrUpdateQuery = "INSERT INTO student_assignment (assignment_id, fdesc, assignment_fdatein, student_id, floc, grade)
                            VALUES ('$post_id', '$filedesc', NOW(), '$student_id', '$fileLocationsJson', $previousGrade)
                            ON DUPLICATE KEY UPDATE fdesc = '$filedesc', floc = '$fileLocationsJson'";
    $query = mysqli_query($conn, $insertOrUpdateQuery);
// Fetch fname from assignment table based on assignment_id
$fetchFnameQuery = "SELECT fname FROM assignment WHERE assignment_id = '$post_id'";
$resultFname = mysqli_query($conn, $fetchFnameQuery);

if ($resultFname) {
    $rowFname = mysqli_fetch_assoc($resultFname);
    $fname = $rowFname['fname'];

    // Fetch teacher_id based on teacher_class_id
    $fetchTeacherIdQuery = "SELECT teacher_id FROM teacher_class WHERE teacher_class_id = '$get_id'";
    $resultTeacherId = mysqli_query($conn, $fetchTeacherIdQuery);

    if ($resultTeacherId) {
        $rowTeacherId = mysqli_fetch_assoc($resultTeacherId);
        $teacher_id = $rowTeacherId['teacher_id'];

        // Insert a notification for the teacher
        $notificationMessage = "Submitted assignment on $fname";
        $link = "view_student_assignment_submissions.php?student_id=".$student_id."&post_id=".$post_id."&get_id=".$get_id;

        $insertNotificationQuery = "INSERT INTO teacher_notification (teacher_class_id, notification, date_of_notification, link, student_id, assignment_id, teacher_id)
                                    VALUES ('$get_id', '$notificationMessage', NOW(), '$link', '$student_id', '$post_id', '$teacher_id')";
        mysqli_query($conn, $insertNotificationQuery);
    } else {
        // Handle the case where fetching teacher_id fails
        echo "Error fetching teacher_id: " . mysqli_error($conn);
    }
} else {
    // Handle the case where fetching fname fails
    echo "Error fetching fname: " . mysqli_error($conn);
}
    if ($query) {
        // Assignment successfully created or updated
        // Add SweetAlert for success message
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Assignment Created!",
                text: "The assignment has been successfully submitted.",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = "view_class_assignment.php?id=' . $get_id . '&post_id=' . $post_id . '";
                }
            });
        </script>';
    } else {
        // Handle database insert/update error
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error creating the assignment. Please try again.",
                confirmButtonText: "OK"
            });
        </script>';
    }
}
?>



<?php 

include('dbcon.php');
require("opener_db.php");

// Edit Assignment
if(isset($_POST['edit_assignment'])) { // Button Name
    // Retrieve assignment details from the form
    $assignment_id = $_POST['assignment_id'];
    $name = $_POST['name'];
    $filedesc = $_POST['desc'];
    $max_score = intval($_POST['max_score']); // Ensure max_score is an integer
    $deadline = $_POST['deadline'];
    $learning_objectives = $_POST['learning_objectives'];
    $get_id = $_GET['id'];
    $post_id = $_GET['post_id'];


    // Handle file uploads (if needed)
    if (!empty($_FILES['uploaded_files']['name'][0])) {
        // Process and update the file locations
        $fileLocations = [];
        $uploadDirectory = "../uploads/"; // Directory where files will be uploaded

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
            window.location.href = "view_class_assignment.php>";
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
