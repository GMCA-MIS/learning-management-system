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
$examDetails = $exam_description = $examResults = [];

// Validate exam_id and id parameters
if (isset($_GET['exam_id']) && isset($_GET['id']) &&
    isValidInteger($_GET['exam_id']) && isValidInteger($_GET['id'])) {

    $exam_id = $_GET['exam_id'];
    $student_id = $_GET['id'];

    // Check if the student has access to the specified exam
    $accessCheck = mysqli_query($conn, "SELECT * FROM student_class_exam scq
                                         JOIN class_exam cq ON scq.class_exam_id = cq.class_exam_id
                                         WHERE scq.student_id = $student_id AND cq.exam_id = $exam_id");

    if (mysqli_num_rows($accessCheck) == 0) {
        // Redirect to deny.php if access is not granted
        echo '<script>window.location.href = "../deny.php"; </script>';
        exit();
    }

    // Fetch exam details
    $examDetails = mysqli_query($conn, "
    SELECT 
        q.*,
        qq.*,
        scq.*
    FROM exam q
    JOIN exam_question qq ON q.exam_id = qq.exam_id
    LEFT JOIN student_class_exam scq ON q.exam_id = scq.exam_id
    WHERE q.exam_id = $exam_id
");

    
    $exam = mysqli_fetch_assoc($examDetails);
    $exam_description = $exam['exam_description'];
    $question_text = $exam['question_text'];
    $image = $exam['image'];
    $exam_title = $exam['exam_title'];
    $grade = $exam['grade'];
    $max_score = $exam['max_score'];

    // Fetch student's exam results
    $examResults = mysqli_query($conn, "SELECT qr.*, qq.*
    FROM exam_results qr
    JOIN exam_question qq ON qr.exam_question_id = qq.exam_question_id
    WHERE qr.student_id = $student_id AND qr.exam_id = $exam_id");
    
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
        background-color: #f8f8fd; /* Set your desired background color */
    }

    .card {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Update box shadow for a smoother effect */
    }
</style>

<div class="container pt-2" style="padding-bottom: 20px; background-color: white;">
    <?php if ($examDetails) : ?>
        <div class="container pt-4 text-center">
        <h2 class="mb-4 col-5" ><button onclick="history.back()" class="btn btn-primary" style="background-color:#361E12">Back</button></h2>

        <h2><?php echo $exam_title; ?></h2>
        <p class="mb-4 text-muted"><?php echo $exam_description; ?></p>
        <p class="mb-4 text-success" style="font-size: 24px; ">Total Score: <?php echo $grade; ?> / <?php echo $max_score; ?></p>
    </div>
        <?php if ($examResults) : ?>
            <div class="container">
                <?php
                $questionNumber = 1; // Initialize the question number
                while ($result = mysqli_fetch_assoc($examResults)) :
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

            
        <?php else : ?>
            <div class="alert alert-warning" role="alert">
                No results found for this exam.
            </div>
        <?php endif; ?>
    <?php else : ?>
        <div class="alert alert-warning" role="alert">
            exam details not found.
        </div>
    <?php endif; ?>
</div>
</div>
<?php 
include ('includes/footer.php');
include ('includes/scripts.php');
?>

</body>

</html>
