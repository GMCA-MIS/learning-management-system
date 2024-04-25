<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Instructors</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/newheader.css">
</head>
<body>


<?php
include('dbcon.php');


//Manage User Delete Function
if(isset($_POST['delete_assigncourse']))
{
    $id = $_POST['delete_ID'];

    $query = "DELETE FROM 	assigned_subjects WHERE assigned_subjects_id = '$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Success",
            text: "Course Assignment has been removed successfully!",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "manage-assigncourses.php";
        });</script>';
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Error",
            text: "Failed to delete assigned course!",
            icon: "error",
            confirmButtonText: "OK"
        });</script>';
    }
    
    
}

?>

<?php
// Manage-AssignCourses Edit Function
if (isset($_POST['edit_assigncourse'])) // Button Name
{
    include('dbcon.php');

    // Name attributes are used here, make sure they match your form fields
    $id = $_POST['edit_ID'];
    $teacher_id = $_POST['teacher_id'];
    $subject_id = $_POST['subject_id'];
    $class_id = $_POST['class_id'];
    $school_year = $_POST['school_year'];

    // Check if the class is already assigned
    $check_query = "SELECT * FROM assigned_subjects WHERE subject_id = '$subject_id' AND class_id = '$class_id' AND teacher_id = '$teacher_id' AND school_year = '$school_year'";
    $check_result = mysqli_query($conn, $check_query);
    $count = mysqli_num_rows($check_result);

    if ($count > 0) {
        // Display an error message using SweetAlert
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Error",
            text: "Class is already assigned to this teacher!",
            icon: "error",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "manage-assigncourses.php";
        });</script>';
    } else {
        // Update the assignment
        $query = "UPDATE assigned_subjects SET teacher_id='$teacher_id', subject_id='$subject_id', class_id='$class_id' WHERE assigned_subjects_id = '$id'";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            // Display a success message and redirect
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Course Assignment has been updated successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-assigncourses.php";
            });</script>';
        } else {
            // Display an error message
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to update Course Assignment!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }
    }
}
?>


<?php
if (isset($_POST['assign_course'])) {
    include('dbcon.php');
    $teacher_id = $_POST['teacher_id'];
    $subject_id = $_POST['subject_id'];
    $class_id = $_POST['class_id'];
    $school_year = $_POST['school_year'];
    $query = mysqli_query($conn, "SELECT * FROM assigned_subjects WHERE subject_id = '$subject_id' AND class_id = '$class_id' AND teacher_id = '$teacher_id' AND school_year = '$school_year'") or die(mysqli_error());
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        // Course is already assigned, show an error message with SweetAlert
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Course is already assigned.'
            });

            // Redirect to manage-assigncourses.php after 2 seconds
            setTimeout(function() {
                window.location.href = 'manage-assigncourses.php';
            }, 2000);
        </script>";
    } else {
        mysqli_query($conn, "INSERT INTO assigned_subjects (teacher_id, subject_id, class_id, thumbnails, school_year) VALUES ('$teacher_id', '$subject_id', '$class_id', 'admin/uploads/ground.jpg', '$school_year')") or die(mysqli_error());

        $teacher_class = mysqli_query($conn, "SELECT * FROM assigned_subjects ORDER BY assigned_subjects_id DESC") or die(mysqli_error());
        $teacher_row = mysqli_fetch_array($teacher_class);
        $teacher_id = $teacher_row['assigned_subjects_id'];

        $insert_query = mysqli_query($conn, "SELECT * FROM student WHERE class_id = '$class_id'") or die(mysqli_error());
        while ($row = mysqli_fetch_array($insert_query)) {
            $id = $row['student_id'];
            mysqli_query($conn, "INSERT INTO teacher_class_student (teacher_id, student_id, teacher_class_id) VALUES ('$teacher_id', '$id', '$teacher_id')") or die(mysqli_error());
        }

        // Course assigned successfully, show a success message with SweetAlert
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Course assigned successfully to teacher firstname lastname!'
            });

            // Redirect to manage-assigncourses.php after 2 seconds
            setTimeout(function() {
                window.location.href = 'manage-assigncourses.php';
            }, 2000);
        </script>";
    }
}
?>





</body>
</html>