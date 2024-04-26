<?php 
include('student_session.php');  
?>
<?php $get_id = $_GET['id']; ?>
<?php

include('dbcon.php');
include('initialize.php');

// Function to validate if a value is a valid integer
function isValidInteger($value) {
    return is_numeric($value) && intval($value) == $value;
}

// Initialize variables
$quizDetails = $quiz_description = $quizResults = [];

// Validate quiz_id and id parameters
if (isset($_GET['quiz_id']) && isset($_GET['id']) &&
    isValidInteger($_GET['quiz_id']) && isValidInteger($_GET['id'])) {

    $quiz_id = $_GET['quiz_id'];
    $student_id = $_GET['id'];

    // Check if the student has access to the specified quiz
    $accessCheck = mysqli_query($conn, "SELECT * FROM student_class_quiz scq
                                         JOIN class_quiz cq ON scq.class_quiz_id = cq.class_quiz_id
                                         WHERE scq.student_id = $student_id AND cq.quiz_id = $quiz_id");

    if (mysqli_num_rows($accessCheck) == 0) {
        // Redirect to deny.php if access is not granted
        echo '<script>window.location.href = "../deny.php"; </script>';
        exit();
    }

    // Fetch quiz details
    $quizDetails = mysqli_query($conn, "
    SELECT 
        q.*,
        qq.*,
        scq.*
    FROM quiz q
    JOIN quiz_question qq ON q.quiz_id = qq.quiz_id
    LEFT JOIN student_class_quiz scq ON q.quiz_id = scq.quiz_id
    WHERE q.quiz_id = $quiz_id
");

    
    $quiz = mysqli_fetch_assoc($quizDetails);
    $quiz_description = $quiz['quiz_description'];
    $question_text = $quiz['question_text'];
    $image = $quiz['image'];
    $quiz_title = $quiz['quiz_title'];
    $grade = $quiz['grade'];
    $max_score = $quiz['max_score'];

    // Fetch student's quiz results
    $quizResults = mysqli_query($conn, "SELECT qr.*, qq.*
    FROM quiz_results qr
    JOIN quiz_question qq ON qr.quiz_question_id = qq.quiz_question_id
    WHERE qr.student_id = $student_id AND qr.quiz_id = $quiz_id");
    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include your head content here -->
</head>

<body>

    <?php include('includes/topbar.php'); ?>

    <?php include('includes/header.php'); ?>

    <style>
    body {
        background-color: #f0f0f0; /* Set your desired background color */
    }

    .card {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Update box shadow for a smoother effect */
    }
</style>

<div class="container mt-4">
    <?php if ($quizDetails) : ?>
        <div class="container mt-4 text-center">
        
        <h2 class="mb-4 col-5" ><button onclick="history.back()" class="btn btn-primary" style="background-color:#361E12">Back</button></h2>

        <h2 class="mb-4">Quiz Result Details</h2>
        <h5 class="mb-3 text"><?php echo $quiz_title; ?></h5>
        <p class="mb-4 text-muted"><?php echo $quiz_description; ?></p>
        <p class="mb-4 text-success" style="font-size: 24px; ">Total Score: <?php echo $grade; ?> / <?php echo $max_score; ?></p>
    </div>
        <?php if ($quizResults) : ?>
            <div class="container">
                
                <?php
                $questionNumber = 1; // Initialize the question number
                while ($result = mysqli_fetch_assoc($quizResults)) :
                ?>
                    <div class="row mt-4">
                        <div class="col-md-8 mx-auto">
                            <div class="card <?php echo $result['is_correct'] == 1 ? 'border-success' : 'border-danger'; ?>">
                                <div class="card-body">
                                    <?php
                                    // Display a Bootstrap badge for correct or incorrect answers
                                    echo '<span class="badge badge-' . ($result['is_correct'] == 1 ? 'success' : 'danger') . ' float-right">' . ($result['is_correct'] == 1 ? 'Correct' : 'Incorrect') . '</span>';
                                    
                                    echo '<h5 class="card-title">Question ' . $questionNumber . '</h5>';
                                    echo '<p class="card-text">';
                                    echo ' ' . $result['question_text'] . '<br>'; 

                                    // Conditionally include image-related code
                                    if (!empty($result['image'])) {
                                        echo '<a href="' . $result['image'] . '" target="_blank" class="d-flex justify-content-center">';
                                        echo '<img src="' . $result['image'] . '" alt="Question Image" class="img-thumbnail" style="max-width: 250px;">';
                                        echo '</a><br>';
                                    }

                                    echo 'Your Answer: ' . $result['user_answer'] . '<br>';
                                    echo 'Correct Answer: ' . $result['correct_answer'] . '<br>';
                                    echo 'Points: ' . $result['points'] . '<br>';
                                    
                                    if(!empty($result['comment'])){
                                        $comment = $result['comment'];
                                    } 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    $questionNumber++; // Increment the question number
                endwhile;
                           
                ?>
                <div class="row mt-4">
                <div class="col-md-8 mx-auto">
                    <div class="card border-dark">
                        <div class="card-body">
                        <b>Comment:</b>
                         <?php  
                           
                            if(!empty($comment)){
                                echo $comment ;
                            } 
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        <?php else : ?>
            <div class="alert alert-warning" role="alert">
                No results found for this quiz.
            </div>
        <?php endif; ?>
    <?php else : ?>
        <div class="alert alert-warning" role="alert">
            Quiz details not found.
        </div>
    <?php endif; ?>
</div>



</body>

</html>
