<?php 
include('teacher_session.php');  ?>

<?php
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
include('dbcon.php');
include('initialize.php');
?>
             
             <?php
// class_grades-function.php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_task"])) {

    // Get values from the form
    $task_title = $_POST["title"];
    $max_score = $_POST["max_score"];
    $get_id = $_POST["get_id"];
    $task_objective = $_POST["task_objective"];
    $fdesc = $_POST["desc"];
    $deadline = $_POST['deadline'];


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





    // Validate inputs (you can add more validation)
    if (empty($task_title) || empty($max_score)) {
        // Use SweetAlert for an error message
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'All fields are required!',
                });
              </script>";
    } else {
        // Insert data into the task table
        $sql = "INSERT INTO task (task_title, max_score, teacher_class_id, status, task_objective, date_added,floc,fdesc,deadline) VALUES (?, ?, ?, 'Available', ?, NOW(),?,?,'$deadline')";
        $stmt = $conn->prepare($sql);

       
        
        if ($stmt) {
            $stmt->bind_param("siisss", $task_title,  $max_score, $get_id, $task_objective, $fileLocationsJson,$fdesc );
            $stmt->execute();
            $last_id12 = $conn->insert_id;

            // Prepare the SQL statement FOR NOTIFICATION to student
            $queryz = "INSERT INTO notification (notification, date_of_notification, teacher_class_id, link) VALUES (?, NOW(), ?, ?)";
            $stmt = mysqli_prepare($conn, $queryz);
            
            $link = 'view_class_performancetask.php?id=' . $get_id . '&task_id=' . $last_id12;
            $name_notification = 'Add Performance TASK titled:' . ' <b>' . $task_title . '</b>';

            mysqli_stmt_bind_param($stmt, 'sis', $name_notification, $get_id, $link);
            mysqli_stmt_execute($stmt);

            // Check if the insertion was successful
            if ($stmt->affected_rows > 0) {
                // Use SweetAlert for success message
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Task created successfully!',
                }).then(function() {
                    window.location.href = 'class_peta.php?id=$get_id';
                });
              </script>";
            } else {
                // Use SweetAlert for an error message
                echo "<script>
                    Swal.fire({
                        icon: 'Oops...',
                        title: 'Task creation unsuccessful!',
                    }).then(function() {
                        window.location.href = 'class_peta.php?id=$get_id';
                    });
                </script>";
            }

            // Close the statement
            $stmt->close();
        } else {
            // Use SweetAlert for an error message
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error preparing statement: " . $conn->error . "',
                    });
                  </script>";
        }

        // Close the database connection
        $conn->close();
    }
}
?>


    <!-- edit Announcement-->

    <?php
if (isset($_POST['edit_announcement'])) {
    // Ensure you have a database connection established

    // Sanitize and validate the input
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $teacher_class_announcements_id = $_POST['teacher_class_announcements_id'];
    $get_id = $_GET['teacher_class_id'];
    $modalID = "edit_announcementModal_$teacher_class_announcements_id";

    // Get the teacher_id from a session variable, assuming you have it stored
    $teacher_id = $_SESSION['teacher_id'];

    // Initialize an array to store attachment paths
    $attachment_paths = [];

    // Handle file uploads
    if (isset($_FILES['attachment']) && count($_FILES['attachment']['name']) > 0) {
        $uploadDir = "../uploads/"; // Update with your directory path

        for ($i = 0; $i < count($_FILES['attachment']['name']); $i++) {
            $uploadedFile = $uploadDir . basename($_FILES['attachment']['name'][$i]);

            // Check if the uploaded file is an image
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['attachment']['type'][$i], $allowedTypes)) {
                if (move_uploaded_file($_FILES['attachment']['tmp_name'][$i], $uploadedFile)) {
                    $attachment_paths[] = $uploadedFile;
                }
            }
        }
    }

    // Convert the array of attachment paths to a string
    $attachment_path_str = implode(', ', $attachment_paths);

    // Update the announcement in the teacher_class_announcements table, including the attachment paths
    $update_announcement_query = "UPDATE teacher_class_announcements SET content = '$content', attachment_path = '$attachment_path_str' WHERE teacher_class_announcements_id = $teacher_class_announcements_id";

    if (mysqli_query($conn, $update_announcement_query)) {
        // Success: Display SweetAlert and then redirect
        echo '<script>
            Swal.fire({
                title: "Announcement Updated",
                icon: "success",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "class_grades.php?id=' . $get_id . '";
            });
        </script>';
    } else {
        // Error: Display SweetAlert with a window location for error
        echo '<script>
            Swal.fire({
                title: "Error updating announcement",
                text: "An error occurred while updating the announcement.",
                icon: "error",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "class_announcements.php?id=' . $get_id . '";
            });
        </script>';
    }
}
?>


<?php
// Include your database connection file if not already included
include("dbcon.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_score"])) {
    // Get the values from the form
    $get_id = $_POST["get_id"];
    $task_id = $_POST["task"];
    $scores = $_POST["scores"];

    // Flag to check if any update or insertion fails
    $isError = false;

    // Loop through the scores and insert or update in the task_result table
    foreach ($scores as $student_id => $score) {
        // Check if the task_id already exists for the student in task_result
        $check_query = "SELECT * FROM task_result WHERE student_id = '$student_id' AND task_id = '$task_id'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // If the record already exists, update the score
            $update_query = "UPDATE task_result SET score = '$score' WHERE student_id = '$student_id' AND task_id = '$task_id'";
            $update_result = mysqli_query($conn, $update_query);

            if (!$update_result) {
                $isError = true;
                break;
            }
        } else {
            // If the record doesn't exist, insert a new record
            $insert_query = "INSERT INTO task_result (student_id, task_id, score) VALUES ('$student_id', '$task_id', '$score')";
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
                window.location.href = "view_class_peta.php?id=' . $get_id . '&task_id=' . $task_id . '";
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


<!-- For updating score assignment -->
<?php
// Include your database connection file if not already included
include("dbcon.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_scoreAssignment"])) {
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
                window.location.href = "class_grades.php?id=' . $get_id . '";
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

<!-- For updating score Quiz -->
<?php
// Include your database connection file if not already included
include("dbcon.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_scoreQuiz"])) {
    // Get the values from the form
    $get_id = $_POST["get_id"];
    $quiz_id = $_POST["quiz_id"];
    $grades = $_POST["grades"];

    // Flag to check if any update or insertion fails
    $isError = false;

    // Loop through the grades and insert or update in the task_result table
    foreach ($grades as $student_id => $grade) {
        // Check if the task_id already exists for the student in task_result
        $check_query = "SELECT * FROM student_class_quiz WHERE student_id = '$student_id' AND quiz_id = '$quiz_id'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // If the record already exists, update the grade
            $update_query = "UPDATE student_class_quiz SET grade = '$grade' WHERE student_id = '$student_id' AND quiz_id = '$quiz_id'";
            $update_result = mysqli_query($conn, $update_query);

            if (!$update_result) {
                $isError = true;
                break;
            }
        } else {
            // If the record doesn't exist, insert a new record
            $insert_query = "INSERT INTO student_class_quiz (student_id, quiz_id, grade) VALUES ('$student_id', '$quiz_id', '$grade')";
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
                window.location.href = "class_grades.php?id=' . $get_id . '";
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

<!-- For updating score Exam -->
<?php
// Include your database connection file if not already included
include("dbcon.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_scoreExam"])) {
    // Get the values from the form
    $get_id = $_POST["get_id"];
    $exam_id = $_POST["exam_id"];
    $grades = $_POST["grades"];

    // Flag to check if any update or insertion fails
    $isError = false;

    // Loop through the grades and insert or update in the task_result table
    foreach ($grades as $student_id => $grade) {
        // Check if the task_id already exists for the student in task_result
        $check_query = "SELECT * FROM student_class_exam WHERE student_id = '$student_id' AND exam_id = '$exam_id'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // If the record already exists, update the grade
            $update_query = "UPDATE student_class_exam SET grade = '$grade' WHERE student_id = '$student_id' AND exam_id = '$exam_id'";
            $update_result = mysqli_query($conn, $update_query);

            if (!$update_result) {
                $isError = true;
                break;
            }
        } else {
            // If the record doesn't exist, insert a new record
            $insert_query = "INSERT INTO student_class_exam (student_id, exam_id, grade) VALUES ('$student_id', '$exam_id', '$grade')";
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
                window.location.href = "class_grades.php?id=' . $get_id . '";
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
include("dbcon.php"); // Include your database connection file

if (isset($_POST['add_assignment'])) {
    $get_id = $_POST['get_id'];
    $assignment_title = mysqli_real_escape_string($conn, $_POST['fname']);
    $max_score = $_POST['max_score'];
    $teacher_id = $_POST['teacher_id'];

    // Insert data into the assignment table
    $insert_assignment_query = "INSERT INTO assignment (class_id, fname,  teacher_id, max_score, status)
                                VALUES ('$get_id', '$assignment_title',  '$teacher_id' ,'$max_score', 'Available')";
    mysqli_query($conn, $insert_assignment_query) or die("Error inserting assignment: " . mysqli_error($conn));

    // Get the assignment_id of the newly inserted assignment
    $assignment_id = mysqli_insert_id($conn);

    // Loop through student scores and update student_assignment table
    if (isset($_POST['scores']) && is_array($_POST['scores'])) {
        foreach ($_POST['scores'] as $student_id => $score) {
            $update_student_assignment_query = "INSERT INTO student_assignment (student_id, assignment_id, grade, status)
                                                VALUES ('$student_id', '$assignment_id', '$score', 'Available')
                                                ON DUPLICATE KEY UPDATE grade = '$score'";
            mysqli_query($conn, $update_student_assignment_query) or die("Error updating student assignment: " . mysqli_error($conn));
        }
    }

    // Close the database connection
    mysqli_close($conn);

    // Use SweetAlert for a confirmation message
    echo '<script>
            Swal.fire({
                title: "Assignment Scores submitted!",
                icon: "success",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "class_grades.php?id=' . $get_id . '";
            });
        </script>';
    exit();
}
?>




<?php
include("dbcon.php"); // Include your database connection file

if (isset($_POST['add_quiz'])) {
    $get_id = $_POST['get_id'];
    $quiz_title = mysqli_real_escape_string($conn, $_POST['title']);
    $max_score = $_POST['max_score'];
    $teacher_id = $_POST['teacher_id'];

    // Insert data into the quiz table
    $insert_quiz_query = "INSERT INTO quiz (teacher_id, quiz_title, status)
                                VALUES ('$teacher_id', '$quiz_title', 'Available')";
    mysqli_query($conn, $insert_quiz_query) or die("Error inserting quiz: " . mysqli_error($conn));

    // Get the quiz_id of the newly inserted quiz
    $quiz_id = mysqli_insert_id($conn);

// Insert data into the class_quiz table
$insert_class_quiz_query = "INSERT INTO class_quiz (teacher_class_id, quiz_id)
                            VALUES ('$get_id', '$quiz_id')";
mysqli_query($conn, $insert_class_quiz_query) or die("Error inserting class quiz: " . mysqli_error($conn));

// Get the auto-incremented ID from the last insert query
$class_quiz_id = mysqli_insert_id($conn);

// Loop through student scores and update student_quiz table
if (isset($_POST['scores']) && is_array($_POST['scores'])) {
    foreach ($_POST['scores'] as $student_id => $score) {
        // Insert data into the student_quiz table
        $insert_student_quiz_query = "INSERT INTO student_class_quiz (class_quiz_id, student_id, quiz_id, grade, max_score, status)
                                        VALUES ('$class_quiz_id', '$student_id', '$quiz_id', '$score', '$max_score', 'Available')
                                        ON DUPLICATE KEY UPDATE grade = '$score', max_score = '$max_score'";
        mysqli_query($conn, $insert_student_quiz_query) or die("Error updating student quiz: " . mysqli_error($conn));
    }
}
    // Close the database connection
    mysqli_close($conn);

    // Use SweetAlert for a confirmation message
    echo '<script>
            Swal.fire({
                title: "Quiz Scores submitted!",
                icon: "success",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "class_grades.php?id=' . $get_id . '";
            });
        </script>';
    exit();
}
?>


<?php
include("dbcon.php"); // Include your database connection file

if (isset($_POST['add_exam'])) {
    $get_id = $_POST['get_id'];
    $exam_title = mysqli_real_escape_string($conn, $_POST['title']);
    $max_score = $_POST['max_score'];
    $teacher_id = $_POST['teacher_id'];

    // Insert data into the exam table
    $insert_exam_query = "INSERT INTO exam (teacher_id, exam_title, status)
                                VALUES ('$teacher_id', '$exam_title', 'Available')";
    mysqli_query($conn, $insert_exam_query) or die("Error inserting exam: " . mysqli_error($conn));

    // Get the exam_id of the newly inserted exam
    $exam_id = mysqli_insert_id($conn);

// Insert data into the class_exam table
$insert_class_exam_query = "INSERT INTO class_exam (teacher_class_id, exam_id)
                            VALUES ('$get_id', '$exam_id')";
mysqli_query($conn, $insert_class_exam_query) or die("Error inserting class exam: " . mysqli_error($conn));

// Get the auto-incremented ID from the last insert query
$class_exam_id = mysqli_insert_id($conn);

// Loop through student scores and update student_exam table
if (isset($_POST['scores']) && is_array($_POST['scores'])) {
    foreach ($_POST['scores'] as $student_id => $score) {
        // Insert data into the student_exam table
        $insert_student_exam_query = "INSERT INTO student_class_exam (class_exam_id, student_id, exam_id, grade, max_score, status)
                                        VALUES ('$class_exam_id', '$student_id', '$exam_id', '$score', '$max_score', 'Available')
                                        ON DUPLICATE KEY UPDATE grade = '$score', max_score = '$max_score'";
        mysqli_query($conn, $insert_student_exam_query) or die("Error updating student exam: " . mysqli_error($conn));
    }
}
    // Close the database connection
    mysqli_close($conn);

    // Use SweetAlert for a confirmation message
    echo '<script>
            Swal.fire({
                title: "Exam Scores submitted!",
                icon: "success",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "class_grades.php?id=' . $get_id . '";
            });
        </script>';
    exit();
}
?>


<?php
// Include your database connection file or establish a connection here
// Include any necessary functions or configurations

// Check if the form is submitted
if (isset($_POST['archive_assignment'])) {
    // Retrieve assignment ID from the form
    $assignment_id = $_POST['assignment_id'];
    $get_id = $_POST['get_id'];

    // Add any validation or sanitation as needed

    // Perform the deletion operation on assignment table
    $delete_assignment_query = "UPDATE assignment SET status = 'Archived' WHERE assignment_id = $assignment_id";

    // Perform the deletion operation on student_assignment table
    $delete_student_assignment_query = "UPDATE student_assignment SET status = 'Archived' WHERE assignment_id = $assignment_id";

    // Start a transaction for atomicity
    mysqli_autocommit($conn, FALSE);
    
    $success = true;

    // Execute the queries
    $result_assignment = mysqli_query($conn, $delete_assignment_query);
    $result_student_assignment = mysqli_query($conn, $delete_student_assignment_query);

    // Check if both queries were successful
    if (!$result_assignment || !$result_student_assignment) {
        $success = false;
    }

    // Check if the deletion was successful
    if ($success) {
        // Commit the transaction
        mysqli_commit($conn);

        // Redirect or display a success message as needed
        echo'<script>
        Swal.fire({
            title: "Assignment archived successfully!",
            icon: "success",
            confirmButtonColor: "rgba(23, 24, 32, 0.95)",
            showCancelButton: false,
            allowOutsideClick: false,
        }).then(() => {
            window.location.href = "class_grades.php?id=' . $get_id . '";
        });
    </script>';
        exit();
    } else {
        // Rollback the transaction in case of an error
        mysqli_rollback($conn);

        // Handle the error, redirect, or display an error message
        echo "Error deleting assignment: " . mysqli_error($conn);
    }
}
?>

<?php
// Include your database connection file or establish a connection here
// Include any necessary functions or configurations

// Check if the form is submitted
if (isset($_POST['archive_quiz'])) {
    // Retrieve quiz ID from the form
    $quiz_id = $_POST['quiz_id'];
    $get_id = $_POST['get_id'];

    // Add any validation or sanitation as needed

    // Perform the deletion operation on assignment table
    $delete_quiz_query = "UPDATE quiz SET status = 'Archived' WHERE quiz_id = $quiz_id";

    // Perform the deletion operation on student_quiz table
    $delete_student_quiz_query = "UPDATE student_class_quiz SET status = 'Archived' WHERE quiz_id = $quiz_id";

    // Start a transaction for atomicity
    mysqli_autocommit($conn, FALSE);
    
    $success = true;

    // Execute the queries
    $result_quiz = mysqli_query($conn, $delete_quiz_query);
    $result_student_quiz = mysqli_query($conn, $delete_student_quiz_query);

    // Check if both queries were successful
    if (!$result_quiz || !$result_student_quiz) {
        $success = false;
    }

    // Check if the deletion was successful
    if ($success) {
        // Commit the transaction
        mysqli_commit($conn);

        // Redirect or display a success message as needed
        echo'<script>
        Swal.fire({
            title: "Quiz archived successfully!",
            icon: "success",
            confirmButtonColor: "rgba(23, 24, 32, 0.95)",
            showCancelButton: false,
            allowOutsideClick: false,
        }).then(() => {
            window.location.href = "class_grades.php?id=' . $get_id . '";
        });
    </script>';
        exit();
    } else {
        // Rollback the transaction in case of an error
        mysqli_rollback($conn);

        // Handle the error, redirect, or display an error message
        echo "Error deleting Quiz: " . mysqli_error($conn);
    }
}
?>


<?php
// Include your database connection file or establish a connection here
// Include any necessary functions or configurations

// Check if the form is submitted
if (isset($_POST['archive_exam'])) {
    // Retrieve exam ID from the form
    $exam_id = $_POST['exam_id'];
    $get_id = $_POST['get_id'];

    // Add any validation or sanitation as needed

    // Perform the deletion operation on assignment table
    $delete_exam_query = "UPDATE exam SET status = 'Archived' WHERE exam_id = $exam_id";

    // Perform the deletion operation on student_exam table
    $delete_student_exam_query = "UPDATE student_class_exam SET status = 'Archived' WHERE exam_id = $exam_id";

    // Start a transaction for atomicity
    mysqli_autocommit($conn, FALSE);
    
    $success = true;

    // Execute the queries
    $result_exam = mysqli_query($conn, $delete_exam_query);
    $result_student_exam = mysqli_query($conn, $delete_student_exam_query);

    // Check if both queries were successful
    if (!$result_exam || !$result_student_exam) {
        $success = false;
    }

    // Check if the deletion was successful
    if ($success) {
        // Commit the transaction
        mysqli_commit($conn);

        // Redirect or display a success message as needed
        echo'<script>
        Swal.fire({
            title: "Exam archived successfully!",
            icon: "success",
            confirmButtonColor: "rgba(23, 24, 32, 0.95)",
            showCancelButton: false,
            allowOutsideClick: false,
        }).then(() => {
            window.location.href = "class_grades.php?id=' . $get_id . '";
        });
    </script>';
        exit();
    } else {
        // Rollback the transaction in case of an error
        mysqli_rollback($conn);

        // Handle the error, redirect, or display an error message
        echo "Error Archiving Exam: " . mysqli_error($conn);
    }
}
?>



<?php
// Include your database connection file or establish a connection here
// Include any necessary functions or configurations

// Check if the form is submitted
if (isset($_POST['archive_task'])) {
    // Retrieve task ID from the form
    $task_id = $_POST['task_id'];
    $get_id = $_POST['get_id'];
   // Add this line for debugging

    // Perform the deletion operation on assignment table
    $delete_task_query = "UPDATE task SET status = 'Archived' WHERE task_id = $task_id";

    // Perform the deletion operation on student_task table
    $delete_student_task_query = "UPDATE task_result SET status = 'Archived' WHERE task_id = $task_id";

    // Start a transaction for atomicity
    mysqli_autocommit($conn, FALSE);
    
    $success = true;

    // Execute the queries
    $result_task = mysqli_query($conn, $delete_task_query);
    $result_student_task = mysqli_query($conn, $delete_student_task_query);

    // Check if both queries were successful
    if (!$result_task || !$result_student_task) {
        $success = false;
    }

    // Check if the deletion was successful
    if ($success) {
        // Commit the transaction
        mysqli_commit($conn);

        // Redirect or display a success message as needed
        echo'<script>
        Swal.fire({
            title: "Task archived successfully!",
            icon: "success",
            confirmButtonColor: "rgba(23, 24, 32, 0.95)",
            showCancelButton: false,
            allowOutsideClick: false,
        }).then(() => {
            window.location.href = "class_grades.php?id=' . $get_id . '";
        });
    </script>';
        exit();
    } else {
        // Rollback the transaction in case of an error
        mysqli_rollback($conn);

        // Handle the error, redirect, or display an error message
        echo "Error Archiving Task: " . mysqli_error($conn);
    }
}
?>


<?php
include("dbcon.php");
// Assuming database connection and session handling are already present

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && isset($_GET['id'])  && isset($_GET['get_id']) && $_GET['action'] === 'archive') {
    $task_id = $_GET['id'];
    $get_id = $_GET['get_id'];

    // Update the assignment status to "Archived"
    $updateQuery = "UPDATE task SET status = 'Archived' WHERE task_id = '$task_id'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Display success message using SweetAlert
        echo '<script>
            Swal.fire({
                title: "Task archived successfully!",
                icon: "success",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "class_peta.php?id=' . $get_id . '";
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
include("dbcon.php");
// Assuming database connection and session handling are already present

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && isset($_GET['id']) && isset($_GET['get_id']) && $_GET['action'] === 'available') {
    $task_id = $_GET['id'];
    $get_id = $_GET['get_id'];

    // Update the assignment status to "Available"
    $updateQuery = "UPDATE task SET status = 'Available' WHERE task_id = '$task_id'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo 'MySQL Error: ' . mysqli_error($conn);
        // Display success message using SweetAlert
        echo '<script>
            Swal.fire({
                title: "Task restored successfully!",
                icon: "success",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "class_peta.php?id=' . $get_id . '";
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