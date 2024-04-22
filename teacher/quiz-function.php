<html>
<?php 
include('teacher_session.php');
?>
<?php
include('includes/header.php');
include('dbcon.php');
include('initialize.php');
?>

<?php
date_default_timezone_set('Asia/Manila');
if (isset($_POST['create_quiz'])) {
    // Get the data from the form
    $teacher_id = $_POST['teacher_id'];
    $quiz_title = $_POST['quiz_title'];
    $quiz_description = $_POST['quiz_description'];
    $theme  = $_POST['theme'];
    $learning_objective  = $_POST['learning_objective'];

    // You may want to validate and sanitize the data here

    // Insert the data into the "quiz" table with the current date using NOW()
    $sql = "INSERT INTO quiz (teacher_id, quiz_title, quiz_description, date_added, theme, status, learning_objective) VALUES (?, ?, ?, NOW(), ?, 'Available', ?)";
    $stmt = mysqli_prepare($conn, $sql);

 // Check if the SQL statement is valid
 if ($stmt) {
    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "issss", $teacher_id, $quiz_title, $quiz_description, $theme, $learning_objective);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Quiz created successfully, display success message
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Success",
            text: "Quiz created successfully!",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "quiz.php";
        });</script>';
    } else {
        // Quiz creation failed, display error message
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Error",
            text: "Failed to create the quiz!",
            icon: "error",
            confirmButtonText: "OK"
        });</script>';
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // SQL statement preparation failed, display an error message
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo '<script>Swal.fire({
        title: "Error",
        text: "Failed to create the quiz. SQL statement preparation failed.",
        icon: "error",
        confirmButtonText: "OK"
    });</script>';
}

// Close the database connection
mysqli_close($conn);
}
?>

<?php
// Include your database connection code here (e.g., mysqli_connect)
include('dbcon.php');
if (isset($_POST['save_question'])) {
    $quiz_id = $_POST['quiz_id'];
    $question_type = $_POST['question_type'];
    $points = $_POST['points'];
    // Initialize the question text, question type ID, and answer based on the question type
    $question_text = "";
    $question_type_id = 0;
    $answer = "";

    // Determine the question text, question type ID, and answer based on the selected question type
    if ($question_type === 'Multiple Choice') {
        $question_text = $_POST['question_multiple_choice'];
        $question_type_id = 1; // You may need to adjust this based on your database schema

        // Get the selected answer (choice) for multiple choice questions
        $answer = $_POST['multipleChoiceAnswer'];
    } elseif ($question_type === 'True or False') {
        $question_text = $_POST['question_true_false'];
        $question_type_id = 2; // You may need to adjust this based on your database schema

        // Get the selected answer (true or false)
        $answer = $_POST['trueFalseAnswer'];
    } elseif ($question_type === 'Identification') {
        $question_text = $_POST['question_identification'];
        $question_type_id = 3; // You may need to adjust this based on your database schema

        // Get the correct identification answer
        $answer = $_POST['identificationAnswer'];
    }

    // Insert the question into the "quiz_question" table
    $insert_question_query = "INSERT INTO quiz_question (quiz_id, question_text, question_type_id, points, date_added, answer) VALUES (?, ?, ?, ?, NOW(), ?)";

    // Prepare and execute the question insert query
    $stmt = mysqli_prepare($conn, $insert_question_query);
    mysqli_stmt_bind_param($stmt, "isiss", $quiz_id, $question_text, $question_type_id, $points, $answer);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $question_id = mysqli_insert_id($conn);
    
        if ($question_type === 'Multiple Choice') {
            // Loop through the choices and insert them into the "question_choices" table
            for ($i = 1; isset($_POST['choice' . $i]); $i++) {
                $choice_text = $_POST['choice' . $i];
    
                // Check if this choice is the correct answer (you need to update this logic accordingly)
                $is_correct = ($i === (int)substr($answer, -1)) ? 1 : 0;
    
                $insert_choice_query = "INSERT INTO question_choices (quiz_question_id, choice_text, is_correct) VALUES (?, ?, ?)";
    
                // Prepare and execute the choice insert query
                $stmt = mysqli_prepare($conn, $insert_choice_query);
                mysqli_stmt_bind_param($stmt, "isi", $question_id, $choice_text, $is_correct);
                $choice_result = mysqli_stmt_execute($stmt);
    
                if (!$choice_result) {
                    // Handle the choice insertion error
                    echo "Error inserting choice: " . mysqli_error($conn);
                    // You may want to roll back the question insertion and display an error message
                    break;
                }
            }
        } elseif ($question_type === 'True or False' || $question_type === 'Identification') {
            // For True or False and Identification questions, insert appropriate choices or set is_correct
            if ($question_type === 'True or False') {
                // Insert True and False choices
                $trueFalseChoices = ['True', 'False'];
                foreach ($trueFalseChoices as $choice_text) {
                    // Determine if this choice is correct based on the $answer
                    $is_correct = ($choice_text === $answer) ? 1 : 0;
    
                    $insert_choice_query = "INSERT INTO question_choices (quiz_question_id, choice_text, is_correct) VALUES (?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $insert_choice_query);
                    mysqli_stmt_bind_param($stmt, "isi", $question_id, $choice_text, $is_correct);
                    $choice_result = mysqli_stmt_execute($stmt);
    
                    if (!$choice_result) {
                        // Handle the choice insertion error
                        echo "Error inserting choice: " . mysqli_error($conn);
                        // You may want to roll back the question insertion and display an error message
                        break;
                    }
                }
            } elseif ($question_type === 'Identification') {
                // For Identification questions, there are no choices, but you can set is_correct based on the user's answer
                $userAnswer = $_POST['identificationAnswer'];
    
                // Determine if the user's answer matches the correct answer
                $is_correct = ($userAnswer === $answer) ? 1 : 0;
    
                // Insert a single choice representing the user's answer
                $insert_choice_query = "INSERT INTO question_choices (quiz_question_id, choice_text, is_correct) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $insert_choice_query);
                mysqli_stmt_bind_param($stmt, "isi", $question_id, $userAnswer, $is_correct);
                $choice_result = mysqli_stmt_execute($stmt);
    
                if (!$choice_result) {
                    // Handle the choice insertion error
                    echo "Error inserting choice: " . mysqli_error($conn);
                    // You may want to roll back the question insertion and display an error message
                }
            }
        }
    

         // Check if a file was uploaded
         if (isset($_FILES['photo_upload']) && $_FILES['photo_upload']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            $uploadFile = $uploadDir . basename($_FILES['photo_upload']['name']);

            // Move the uploaded file to the destination directory
            if (move_uploaded_file($_FILES['photo_upload']['tmp_name'], $uploadFile)) {
                // File upload successful, store the file path in the database
                $photoPath = $uploadFile;

                // Update the "quiz_question" table to set the "image" column for a specific "quiz_question_id"
                $update_question_query = "UPDATE quiz_question SET image = ? WHERE quiz_question_id = ?";

                // Prepare and execute the question update query
                $stmt = mysqli_prepare($conn, $update_question_query);
                mysqli_stmt_bind_param($stmt, "si", $photoPath, $question_id);
                $update_result = mysqli_stmt_execute($stmt);

                // Check the result of the update
                if ($update_result) {
                    // Update successful
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo '<script>Swal.fire({
                        title: "Success",
                        text: "Question and choices have been added successfully!",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "quiz_content.php?quiz_id='.$quiz_id.'";
                        // Redirect to the assignment management page
                    });</script>';
                } else {
                    // Update failed, handle the error and display an error message using SweetAlert
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo '<script>Swal.fire({
                        title: "Error",
                        text: "Failed to update image!",
                        icon: "error",
                        confirmButtonText: "OK"
                    });</script>';
                }
            } else {
                // File upload failed
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo '<script>Swal.fire({
                    title: "Error",
                    text: "Failed to upload the photo!",
                    icon: "error",
                    confirmButtonText: "OK"
                });</script>';
                // You may want to exit the script or handle the error differently
            }
        } else {
            // No file uploaded, set $photoPath to null or an empty string
            $photoPath = null;
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Question and choices have been added successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "quiz_content.php?quiz_id='.$quiz_id.'";
                // Redirect to the assignment management page
            });</script>';
        }

    } else {
        // Insert failed, handle the error and display an error message using SweetAlert
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Error",
            text: "Failed to add question!",
            icon: "error",
            confirmButtonText: "OK"
        });</script>';
    }
}
?>


<?php
// Assigning Quiz

if (isset($_POST['assign_quiz'])) {
    // Extract data from the form
    $quiz_id = $_POST['quiz_id'];
    $class_id = $_POST['class'];
    $limit = $_POST['limit'] * 60; // Convert to seconds
    $deadline = $_POST['deadline'];

    // Check if the quiz is already assigned to the class
    $check_query = "SELECT * FROM class_quiz WHERE teacher_class_id = '$class_id' AND quiz_id = '$quiz_id'";
    $check_result = mysqli_query($conn, $check_query);

    

    if (mysqli_num_rows($check_result) > 0) {
        // Quiz is already assigned to the class, show an error alert
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>
        Swal.fire({
            title: "Error",
            text: "Quiz Already assigned!",
            icon: "error",
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "quiz.php"; // Redirect to the assignment management page
        });
    </script>';
    } else {
        // Insert data into your database
        $insert_query = "INSERT INTO class_quiz (teacher_class_id, quiz_time, quiz_id, deadline, stats) VALUES ('$class_id', '$limit', '$quiz_id', '$deadline', '0')";
        if (mysqli_query($conn, $insert_query)) {
            // Fetch quiz title associated with quiz_id
            $quiz_title_query = "SELECT quiz_title FROM quiz WHERE quiz_id = '$quiz_id'";
            $quiz_title_result = mysqli_query($conn, $quiz_title_query);
            
            if ($quiz_title_result && mysqli_num_rows($quiz_title_result) > 0) {
                $row = mysqli_fetch_assoc($quiz_title_result);
                $quiz_title = $row['quiz_title'];
                
                $name_notification = 'Uploaded a Quiz with title: <b>' . $quiz_title . '</b>';
                $notification_query = "INSERT INTO notification (teacher_class_id, notification, date_of_notification, link) VALUES ('$class_id', '$name_notification', NOW(), 'quiz_content.php?quiz_id=".$quiz_id."&id=".$class_id."')";
                
                if (mysqli_query($conn, $notification_query)) {
                    // Insertion successful, show a success alert
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo '<script>Swal.fire({
                        title: "Success",
                        text: "Quiz has been assigned successfully!",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "quiz.php"; // Redirect to the assignment management page
                    });</script>';
                } else {
                    echo "Error inserting notification: " . mysqli_error($conn);
                }
            } else {
                echo "Quiz title not found!";
            }
        } else {
            echo "Error inserting class quiz: " . mysqli_error($conn);
        }
    }
}
?>





<?php
include('dbcon.php');

// Manage User Delete Function
if (isset($_POST['delete_quiz_question'])) {
    $id = $_POST['delete_ID'];
    $quiz_id = $_POST['quiz_id'];

    // Delete question choices associated with the question
    $delete_choices_query = "DELETE FROM question_choices WHERE quiz_question_id = '$id'";
    $choices_deleted = mysqli_query($conn, $delete_choices_query);

    // Delete the question from the "quiz_question" table
    $delete_question_query = "DELETE FROM quiz_question WHERE quiz_question_id = '$id'";
    $question_deleted = mysqli_query($conn, $delete_question_query);

    if ($choices_deleted && $question_deleted) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Success",
            text: "Question has been deleted successfully!",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "quiz_content.php?quiz_id='.$quiz_id.'";
        });</script>';
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Error",
            text: "Failed to delete question!",
            icon: "error",
            confirmButtonText: "OK"
        });</script>';
    }
}

?>


<?php
date_default_timezone_set('Asia/Manila');

if (isset($_POST['add_quiz'])) {
    // Get the data from the form
    $teacher_id = $_POST['teacher_id'];
    $teacher_class_id = $_POST['teacher_class_id'];
    $quiz_title = $_POST['quiz_title'];
    $quiz_description = $_POST['quiz_description'];
    $learning_objective = $_POST['learning_objective'];
    $score_limit = $_POST['score_limit'];

    // You may want to validate and sanitize the data here

    // Insert the data into the "quiz" table with the current date using NOW()
    $sql = "INSERT INTO quiz (teacher_id, quiz_title, quiz_description, date_added, status, learning_objective, type) VALUES (?, ?, ?, NOW(),'Available', ?, '1')";
    $stmt = mysqli_prepare($conn, $sql);

    // Check if the SQL statement is valid
    if ($stmt) {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "isss", $teacher_id, $quiz_title, $quiz_description, $learning_objective);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Get the ID of the newly inserted quiz
            $newlyCreatedQuizId = mysqli_insert_id($conn);

            // Insert into class_quiz table to associate the quiz with the class
            $insertClassQuizSql = "INSERT INTO class_quiz (quiz_id, teacher_class_id, score_limit, stats) VALUES (?, ?, ?, '0')";
            $stmtClassQuiz = mysqli_prepare($conn, $insertClassQuizSql);

            // Check if the SQL statement for class_quiz is valid
            if ($stmtClassQuiz) {
                mysqli_stmt_bind_param($stmtClassQuiz, "iii", $newlyCreatedQuizId, $teacher_class_id, $score_limit);
                mysqli_stmt_execute($stmtClassQuiz);
                mysqli_stmt_close($stmtClassQuiz);
            }

            // Quiz created successfully, display success message
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "Quiz created successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "class_quiz.php";
            });</script>';
        } else {
            // Quiz creation failed, display error message
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to create the quiz!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // SQL statement preparation failed, display an error message
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Error",
            text: "Failed to create the quiz. SQL statement preparation failed.",
            icon: "error",
            confirmButtonText: "OK"
        });</script>';
    }

    // Close the database connection
    mysqli_close($conn);
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
    $class_quiz_id  = $_POST["class_quiz_id"];
    $max_score  = $_POST["max_score"];

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
            $insert_query = "INSERT INTO student_class_quiz (student_id, quiz_id, grade, class_quiz_id, max_score) VALUES ('$student_id', '$quiz_id', '$grade', '$class_quiz_id', '$max_score')";
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
                window.location.href = "view_class_quizf2f.php?id='.$get_id.'&quiz_id='.$quiz_id.'#quiz_results";
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
include("dbcon.php");
// Assuming database connection and session handling are already present

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && isset($_GET['id'])  && isset($_GET['get_id']) && $_GET['action'] === 'archivecq') {
    $quiz_id = $_GET['id'];
    $get_id = $_GET['get_id'];

    // Update the quiz status to "Available"
    $updateQuery = "UPDATE class_quiz SET stats = 'Archived' WHERE quiz_id = '$quiz_id'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Display success message using SweetAlert
        echo '<script>
            Swal.fire({
                title: "Quiz Archived Successfully!",
                icon: "success",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "class_quiz.php?id=' . $get_id . '";
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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && isset($_GET['id'])  && isset($_GET['get_id']) && $_GET['action'] === 'archive') {
    $quiz_id = $_GET['id'];
    $get_id = $_GET['get_id'];

    // Update the quiz status to "Available"
    $updateQuery = "UPDATE class_quiz SET stats = 'Archived' WHERE quiz_id = '$quiz_id'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Display success message using SweetAlert
        echo '<script>
            Swal.fire({
                title: "Quiz Archived Successfully!",
                icon: "success",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "class_quiz.php?id=' . $get_id . '";
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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] === 'available') {
    $quiz_id = $_GET['id'];
    $get_id = $_GET['get_id'];

    // Update the assignment status to "Available"
    $updateQuery = "UPDATE class_quiz SET stats = '0' WHERE quiz_id = '$quiz_id'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Display success message using SweetAlert
        echo '<script>
            Swal.fire({
                title: "Quiz restored successfully!",
                icon: "success",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "class_quiz.php?id=' . $get_id . '";
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
// quiz-function.php

// Include the database connection file
include('dbcon.php');


// Check if the form is submitted
if (isset($_POST['edit_quiz'])) {
    // Retrieve the form data
    $quiz_id = $_POST['quiz_id']; // quiz ID to be edited
    $quiz_title = $_POST['quiz_title'];
    $quiz_description = $_POST['quiz_description'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("UPDATE quiz SET quiz_title=?, quiz_description=? WHERE quiz_id=?");

    // Bind parameters
    $stmt->bind_param("ssi", $quiz_title, $quiz_description, $quiz_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Display success alert
        echo '<script>Swal.fire({
            title: "Success",
            text: "Quiz details updated successfully!",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "quiz.php";
        });</script>';
    } else {
        // Display error alert
        echo '<script>Swal.fire({
            title: "Error",
            text: "Failed to update quiz details!",
            icon: "error",
            confirmButtonText: "OK"
        });</script>';
    }

    // Close the statement
    $stmt->close();
}


?>
</html>