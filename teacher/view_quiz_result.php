<?php 
include('teacher_session.php');  
include('includes/topbar.php');
include('includes/header.php'); 
?>
<?php
$get_id = $_GET['quiz_id']; // Get the quiz_id from the URL
$id = $_GET['id'];
?>

<style>
    body {
        color: black;
    }
    </style>
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4"
                style="margin-top: 27px; margin-left: 10px;">
                <h1 class="h3 mb-0 text-gray-800">Quiz Info: </h1>
            </div>

        </nav>
        <!-- End of Topbar -->

<div class="container-fluid">

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
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>



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

                // Add a clickable badge to open the modal
                $changeLabel = $result['is_correct'] == 1 ? 'Mark as Wrong' : 'Mark as Correct';
                $modalTitle = $result['is_correct'] == 1 ? 'Change Result to Wrong' : 'Change Result to Correct';

                echo '<button class="btn btn-primary float-right update-result" data-toggle="modal" data-target="#confirmationModal" data-quiz-result-id="' . $result['quiz_result_id'] . '" data-modal-title="' . $modalTitle . '">';
                echo 'Change Result';
                echo '</button>';

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
                echo 'Is correct: ' . $result['is_correct'] . '<br>';
                echo 'Is correct: ' . $result['quiz_result_id'] . '<br>';
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="confirmationForm" action="view_quiz_result-function.php" method="post">
                        <input type="hidden" id="studentIdInput" name="student_id" value="<?php echo $id ?>">
                        <input type="hidden" id="quizIdInput" name="quiz_id" value="<?php echo $quiz_id ?>">
                        <input type="hidden" id="quizResultIdInput" name="quiz_result_id" value="">
                        <!-- Uncomment the above line to include quiz_result_id in the form -->
                        Are you sure you want to change the result?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="change_result" id="confirmChangeBtn">Confirm</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
$(document).ready(function () {
    // Use a class instead of an ID for the modal-triggering button
    $(".update-result").click(function () {
        // Get the quiz_result_id dynamically
        var quizResultId = $(this).data("quiz-result-id");

        // Set the value of the hidden input field in the modal
        $("#quizResultIdInput").val(quizResultId);

        // Show the modal
        $("#confirmationModal").modal("show");
    });
});

</script>

</body>

                <?php
                    $questionNumber++; // Increment the question number
                endwhile;
                ?>
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

</div>
</div>
</div>
</body>
</html>


