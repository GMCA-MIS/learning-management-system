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
    $checkGradeQuery = "SELECT score FROM task_result WHERE task_id = '$post_id' AND student_id = '$student_id' AND grade_status = 1";
    $checkGradeResult = mysqli_query($conn, $checkGradeQuery);
    if (mysqli_num_rows($checkGradeResult) > 0) {
        $row = mysqli_fetch_assoc($checkGradeResult);
        $previousGrade = $row['score'];
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


    // get student name
    $nameQueryz = "SELECT firstname,lastname FROM student WHERE student_id = $student_id";
    $nameResultz = mysqli_query($conn, $nameQueryz);
    $rowz = mysqli_fetch_assoc($nameResultz);
    $fnamez = $rowz['firstname'] . " " . $rowz['lastname'];

    // Insert or update the assignment with grade information
    $insertOrUpdateQuery = "INSERT INTO task_result (task_id, fdesc, submitted_date, student_id, floc, score, fname)
                            VALUES ('$post_id', '$filedesc', NOW(), '$student_id', '$fileLocationsJson', $previousGrade, '$fnamez')
                            ON DUPLICATE KEY UPDATE fdesc = '$filedesc', floc = '$fileLocationsJson'";
    $query = mysqli_query($conn, $insertOrUpdateQuery);
// Fetch fname from assignment table based on assignment_id
$fetchFnameQuery = "SELECT task_title FROM task WHERE task_id = '$post_id'";
$resultFname = mysqli_query($conn, $fetchFnameQuery);

if ($resultFname) {
    $rowFname = mysqli_fetch_assoc($resultFname);
    $notificationtitlez = $rowFname['task_title'];

    // Fetch teacher_id based on teacher_class_id
    $fetchTeacherIdQuery = "SELECT teacher_id FROM teacher_class WHERE teacher_class_id = '$get_id'";
    $resultTeacherId = mysqli_query($conn, $fetchTeacherIdQuery);

    if ($resultTeacherId) {
        $rowTeacherId = mysqli_fetch_assoc($resultTeacherId);
        $teacher_id = $rowTeacherId['teacher_id'];
        

        // NEED
        //Insert a notification for the teacher
        $notificationMessage = "Submitted Performance Task on <b>$notificationtitlez</b>";
       $link = "view_stud_performance_sub.php?student_id=".$student_id."&post_id=".$post_id."&get_id=".$get_id."&task=1";

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
                title: "Performance Task Submitted!",
                text: "The assignment has been successfully submitted.",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = "view_class_performancetask.php?id=' . $get_id . '&task_id=' . $post_id . '";
                }
            });
        </script>';
    } else {
        // Handle database insert/update error
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error creating the Performance Task. Please try again.",
                confirmButtonText: "OK"
            });
        </script>';
    }
}
?>
