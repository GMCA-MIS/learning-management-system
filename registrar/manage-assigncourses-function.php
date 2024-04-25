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

    $query = "DELETE FROM teacher_class WHERE teacher_class_id = '$id' ";
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
    $check_query = "SELECT * FROM teacher_class WHERE subject_id = '$subject_id' AND class_id = '$class_id' AND teacher_id = '$teacher_id' AND school_year = '$school_year'";
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
        $query = "UPDATE teacher_class SET teacher_id='$teacher_id', subject_id='$subject_id', class_id='$class_id' WHERE teacher_class_id = '$id'";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            // Check class_quiz table
            $check_class_quiz_query = "SELECT * FROM class_quiz WHERE teacher_class_id = '$id'";
            $check_class_quiz_result = mysqli_query($conn, $check_class_quiz_query);
    
            // Update quiz table
            while ($class_quiz_row = mysqli_fetch_assoc($check_class_quiz_result)) {
                $quiz_id = $class_quiz_row['quiz_id'];
    
                // Assuming there's a connection between quiz and class_quiz using quiz_id
                $update_quiz_query = "UPDATE quiz SET teacher_id='$teacher_id' WHERE quiz_id = '$quiz_id'";
                mysqli_query($conn, $update_quiz_query);
            }
    
            // Update exam table
            $check_class_exam_query = "SELECT * FROM class_exam WHERE teacher_class_id = '$id'";
            $check_class_exam_result = mysqli_query($conn, $check_class_exam_query);
    
            // Update exam table
            while ($class_exam_row = mysqli_fetch_assoc($check_class_exam_result)) {
                $exam_id = $class_exam_row['exam_id'];
    
                // Assuming there's a connection between exam and class_exam using exam_id
                $update_exam_query = "UPDATE exam SET teacher_id='$teacher_id' WHERE exam_id = '$exam_id'";
                mysqli_query($conn, $update_exam_query);
            }


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
    $school_year_id = $_POST['school_year_id'];
    $school_year = $_POST['school_year'];
    $schedule_day = $_POST['schedule_day']; // Array of days
    $schedule_time = $_POST['schedule_time']; // Array of times

    // Check if the course is already assigned

    //    $query = mysqli_query($conn, "SELECT * FROM teacher_class WHERE subject_id = '$subject_id' AND class_id = '$class_id' AND teacher_id = '$teacher_id' AND school_year_id = '$school_year_id'") or die(mysqli_error());

    
    $query = mysqli_query($conn, "SELECT * FROM teacher_class WHERE subject_id = '$subject_id' AND class_id = '$class_id'  AND school_year_id = '$school_year_id'") or die(mysqli_error());
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        // Course is already assigned, show an error message with SweetAlert
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'A Teacher is already assigned to this Class and Subject.'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to manage-assigncourses.php
                    window.location.href = 'manage-assigncourses.php';
                }
            });
        </script>";
    } else {
        // Insert course assignment
        mysqli_query($conn, "INSERT INTO teacher_class (teacher_id, subject_id, school_year_id, class_id, thumbnails, school_year, schedule_day, schedule_time) VALUES ('$teacher_id', '$subject_id', '$school_year_id', '$class_id', 'admin/uploads/ground.jpg', '$school_year', '" . implode(",", $schedule_day) . "', '" . implode(",", $schedule_time) . "')") or die(mysqli_error());

        // Get the teacher_class_id of the newly inserted record
        $teacher_class = mysqli_query($conn, "SELECT * FROM teacher_class ORDER BY teacher_class_id DESC") or die(mysqli_error());
        $teacher_row = mysqli_fetch_array($teacher_class);
        $teacher_class_id = $teacher_row['teacher_class_id'];

        // Assign the course to students in the class
        $insert_query = mysqli_query($conn, "SELECT * FROM student WHERE class_id = '$class_id'") or die(mysqli_error());
        while ($row = mysqli_fetch_array($insert_query)) {
            $student_id = $row['student_id'];
            mysqli_query($conn, "INSERT INTO teacher_class_student (teacher_id, student_id, teacher_class_id) VALUES ('$teacher_id', '$student_id', '$teacher_class_id')") or die(mysqli_error());
        }

        // Course assigned successfully, show a success message with SweetAlert
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Course assigned successfully to teacher!'
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