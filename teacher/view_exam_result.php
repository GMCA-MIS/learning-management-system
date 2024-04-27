<?php 
include('teacher_session.php');  
include('includes/topbar.php');
include('includes/header.php'); 
?>
<?php
$get_id = $_GET['exam_id']; // Get the exam_id from the URL
$id = $_GET['id'];
$post_id = $_GET['post_id'];
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" style = "background-color: #white !important; ">
        <!-- Topbar -->
        <!-- <nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow"> -->

            <!-- Sidebar Toggle (Topbar) -->
            <!-- <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button> -->

            <!-- Page Heading -->
            <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4"
                style="margin-top: 27px; margin-left: 10px;">
                <h1 class="h3 mb-0 text-gray-800">Exam Info: </h1>
            </div>

        </nav> -->
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

if (isset($_GET['comment']) && isset($_GET['id']) && isset($_GET['exam_id']) ){

    $updateQuery = "UPDATE exam_results SET comment ='". $_GET['comment']."' WHERE exam_id = " . $_GET['exam_id'];
    
    // Execute the query
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Comment Updated',
            showConfirmButton: false
        }).then(function() {
            window.location = 'view_exam_result.php?exam_id=". $get_id. "&id=".$id."&post_id=".$post_id."'; // Redirect to profile.php
    
        });
        </script>";
    }
    

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</head>

<body>



    <style>
    body {
        background-color: white; /* Set your desired background color */
    }

    .card {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Update box shadow for a smoother effect */
    }
</style>

<div class="container pt-2 pd-4 mb-4" style= " background-color: white;">
    <?php if ($examDetails) : ?>
        <div class="clickable-div">
            <a href="view_class_exam.php?id=<?php echo $get_id?>&exam_id=<?php echo $exam_id?>">Back</a>
        </div>

        <div class="container pt-4 text-center">
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
                                    echo '<button class="btn btn-' . ($result['is_correct'] == 1 ? 'success' : 'danger') . ' btn-sm float-right">' . ($result['is_correct'] == 1 ? 'Correct' : 'Incorrect') . '</button>';

                                    // Add a clickable badge to open the modal
                                    $changeLabel = $result['is_correct'] == 1 ? 'Mark as Wrong' : 'Mark as Correct';
                                    $modalTitle = $result['is_correct'] == 1 ? 'Change Result to Wrong' : 'Change Result to Correct';

                                    echo '<button class="btn btn-primary btn-sm float-right update-result" data-toggle="modal" data-target="#confirmationModal" data-exam-result-id="' . $result['exam_result_id'] . '" data-modal-title="' . $modalTitle . '">';
                                    echo 'Change Result';
                                    echo '</button>';
                                    

                                    echo '<h6 class="card-title mb-2">Question ' . $questionNumber . '</h5>';
                                    echo '<p class="card-text">';
                                    echo '<p class="mb-4">' . $result['question_text'] . '</p>';
                                    // Conditionally include image-related code
                                    if (!empty($result['image'])) {
                                        echo '<a href="' . $result['image'] . '" target="_blank" class="d-flex justify-content-center">';
                                        echo '<img src="' . $result['image'] . '" alt="Question Image" class="img-thumbnail" style="max-width: 250px;">';
                                        echo '</a><br>';
                                    }

                                    echo '<p class="rem"> Your Answer: ' . $result['user_answer'] . '</p>';
                                    echo '<p class="rem"> Correct Answer: ' . $result['correct_answer'] . '</p>';
                                    echo '<p class="rem"> Points: ' . $result['points'] . '</p>';
                                    echo $comments = $result['comment'];
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
                    <h5 class="modal-title" id="confirmationModalLabel"> Change Result?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="confirmationForm" action="view_quiz_result-function.php" method="post">
                        <input type="hidden" id="studentIdInput" name="student_id" value="<?php echo $id ?>">
                        <input type="hidden" id="examIdInput" name="exam_id" value="<?php echo $exam_id ?>">
                        <input type="hidden" id="examResultIdInput" name="exam_result_id" value="">
                        <!-- Uncomment the above line to include exam_result_id in the form -->
                        Are you sure you want to change the result?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="change_result_exam" id="confirmChangeBtn">Confirm</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
$(document).ready(function () {
    // Use a class instead of an ID for the modal-triggering button
    $(".update-result").click(function () {
        // Get the exam_result_id dynamically
        var examResultId = $(this).data("exam-result-id");

        // Set the value of the hidden input field in the modal
        $("#examResultIdInput").val(examResultId);

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
                No results found for this exam.
            </div>
        <?php endif; ?>
    <?php else : ?>
        <div class="alert alert-warning" role="alert">
            exam details not found.
        </div>
    <?php endif; 
            
    ?>
    
    <form class="col-md-8 mx-auto " action="" method="get">
            <div class="d-flex justify-content-end mb-1 mt-2">        
                    <button type="submit" name="commentsubmit"  class="btn btn-primary">Comment</button>
                </div>
                <input type="hidden" value="<?php echo $_GET['exam_id']; ?>" name="exam_id"/>
                <input type="hidden" value="<?php echo $_GET['id']; ?>" name="id"/>
                <input type="hidden" id="post_id" name="post_id" value="<?php echo $post_id ?>">

                <textarea class="form-control " name="comment" style=""><?php echo $comments;?></textarea>
    </form>
</div>
<?php 
include ('includes/footer.php');
include ('includes/scripts.php');
?>
</div>
</div>
</div>
</body>
</html>


