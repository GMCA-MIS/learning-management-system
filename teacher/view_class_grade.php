<?php 
require('teacher_session.php');
?>

<?php $get_id = $_GET['id']; ?>

<?php
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
require('dbcon.php');
include('initialize.php');
?>

<?php 
$post_id = $_GET['post_id'];
if ($post_id == '') {
    ?>
    <?php
}
?>

<!-- breadcrumb -->
<?php
$class_query = mysqli_query($conn, "SELECT * FROM teacher_class
    LEFT JOIN class ON class.class_id = teacher_class.class_id
    LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
    WHERE teacher_class_id = '$get_id' AND teacher_id = '$teacher_id'") or die(mysqli_error());

$class_row = mysqli_fetch_array($class_query);

// Check if the teacher has access to this class
if ($class_row) { ?>

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
            <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                <h3 class="h4 mb-0 text-gray-800">
                    <span style="font-weight: lighter;"><?php echo $class_row['class_name']; ?></span> > Performance Task
                </h3>
            </div>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <td>
                <!-- Add Pop-Up Modal -->
                <div class="modal fade" id="edit_assignmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Performance Task</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form class="" action="class_assignments-function.php<?php echo '?id=' . $get_id; ?>" method="post" enctype="multipart/form-data" name="upload">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Performance Task Title</label>
                                        <input type="text" class="form-control" id="edit_name" name="name" required placeholder="Enter Assignment Title">
                                    </div>

                                    <div class="form-group">
                                        <input name="uploaded_files[]" class="input-file uniform_on" id="fileInput" type="file" multiple>
                                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                                        <input type="hidden" name="id" value="<?php echo $session_id ?>"/>
                                        <input type="hidden" name="id_class" value="<?php echo $get_id; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="desc">Description</label>
                                        <textarea class="form-control" id="description" name="desc" rows="4" max-length="5000" required placeholder="Enter Description"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for "max_score">Maximum Score:</label>
                                        <input type="number" id="max_score" name="max_score" placeholder="Enter Max Score" required>
                                    </div>

                                    <div class="form-group">
                                        <label for "deadline">Deadline:</label>
                                        <input type="datetime-local" class="form-control flatpickr" id="deadline" name="deadline" placeholder="Enter Deadline" required>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="add_assignment" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div> <!-- modal content -->
                    </div> <!-- modal dialog -->
                </div> <!-- modal fade -->
            </td>
        </head>

        <body>
            <!-- Content Row -->
            <div class="row">
                <!-- Left Column for the first card -->
                <div class="col-md-6">
                    <div class="container mt-4">
                        <!-- Custom Container with Title (First Card) -->
                        <div class="custom-container">
                            <div class="header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Performance Task Details</h4>
                                    <a href="class_edit_performance.php?post_id=<?php echo $post_id; ?>&id=<?php echo $get_id; ?>" class="btn btn-success edit_btn">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <?php
$teacher_id = $_SESSION['teacher_id'];
$assignment_id = $_GET['post_id'];
require("opener_db.php");
$conn = $connector->DbConnector();

function getAssignmentFileLocations($assignment_id, $conn) {
    $query = "SELECT floc FROM task WHERE task_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $assignment_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $floc);
            mysqli_stmt_fetch($stmt);

            return json_decode($floc, true);
        }
    }

    return [];
}

$query = "SELECT task_id, floc, task_title, deadline, fdesc, task_objective FROM task WHERE task_id = ? AND teacher_id = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ii", $assignment_id, $teacher_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $id, $floc, $filename, $deadline, $fdesc, $learning_objectives);
        mysqli_stmt_fetch($stmt);

        $fileLocations = getAssignmentFileLocations($assignment_id, $conn);
    } else {
        echo '<script>window.location.href = "../deny.php?reason=access_denied";</script>';
        exit; // Make sure to exit the script after the JavaScript redirect
    }

    mysqli_stmt_close($stmt);
} else {
    echo '<script>window.location.href = "../deny.php?reason=access_denied";</script>';
    exit; // Make sure to exit the script after the JavaScript redirect
}
?>

<!-- Assignment Card -->
<div class="mt-3 position-relative">
    <div class="card-body">
        <h5 class="card-title"><?php echo $filename; ?></h5>
        <p class="card-text" style="font-size: 14px;">
            <strong>Due:</strong>
            <span style="font-size: 14px; color: #999;"><?php echo $deadline; ?></span>
        </p>
        <hr>
        <p class="card-text"><?php echo $fdesc; ?></p>
        <hr>
        <h4> Learning Objective: </h4>
        <p class="card-text"><?php echo $learning_objectives; ?></p>
        <?php foreach ($fileLocations as $fileLocation): 
            $filename = basename($fileLocation);
        ?>
        <div> <hr>
            <a href="<?php echo $fileLocation; ?>" download="<?php echo $filename; ?>"> Downloadable File: <?php echo $filename; ?></a>
        </div>
        <?php endforeach; ?>
    </div>
</div>


                        </div>
                    </div>
                </div>

                <!-- Right Column for Submission Details -->
                <div class="col-md-6">
                    <div class="custom-container"> 

                        <div class="header">
                            <h6>Submissions</h6>
                        </div>
                        <hr>
                        <?php
$query = mysqli_query($conn, "SELECT sa.*, s.*, s.location, a.max_score, a.deadline FROM task_result sa
LEFT JOIN student s ON s.student_id = sa.student_id
LEFT JOIN task a ON a.task_id = sa.task_id
WHERE sa.task_id = '$post_id' AND teacher_id = '$teacher_id'
ORDER BY sa.submitted_date DESC");

$studentSubmissions = array();

while ($row = mysqli_fetch_array($query)) {
    $studentId = $row['student_id'];
    if (!isset($studentSubmissions[$studentId])) {
        $studentSubmissions[$studentId] = array(
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'picture' => $row['picture'],
            'grade' => $row['score'],
            'max_score' => $row['max_score'],
            'submissions' => array()
        );
    }

    $submissionDate = strtotime($row['submitted_date']);
    $deadline = strtotime($row['deadline']);
    $submissionStatus = ($submissionDate <= $deadline) ? 'Submitted on time' : 'Submitted late';

    $submission = array(
        'id' => $row['task_result_id'],
        'picture' => $row['picture'],
        'maxScore' => $row['max_score'],
        'submissionDate' => $submissionDate,
        'deadline' => $deadline,
        'submissionStatus' => $submissionStatus,
        'assignmentName' => $row['fname'],
        'assignmentDescription' => $row['fdesc'],
        'floc' => $row['floc'],
    );

    $studentSubmissions[$studentId]['submissions'][] = $submission;
}
if (empty($studentSubmissions)) {
    echo '<div class="alert alert-warning">No submissions available</div>';
}
?>



<!-- Card structure outside of PHP -->
<?php foreach ($studentSubmissions as $studentId => $studentData): ?>
    <?php
    $studentName = $studentData['firstname'] . ' ' . $studentData['lastname'];
    $studentImageLocation = $studentData['picture']; // Get the image location from the data
    $grade = $studentData['grade']; // Assuming the grade is stored in the 'grade' column
    $maxScore = $studentData['max_score']; // Assuming the max score is stored in the 'maxScore' column
    ?>

    <a href="view_stud_performance_sub.php?student_id=<?= $studentId ?>&post_id=<?= $post_id ?>&get_id=<?= $get_id ?>" class="card-link">
        <div class="card mt-3">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="student-image">
                        <img src="<?= $studentImageLocation ?>" alt="<?= $studentName ?>" class="rounded-circle" style="width: 50px; height: 50px;">
                    </div>
                    <div class="ml-2">
                        <span class="font-weight-bold"><?= $studentName ?></span>
                        <span class="submission-status ml-2"><?= count($studentData['submissions']) ?> Submissions</span>
                        
                        <?php if (!empty($grade)): ?>
                            <div>
                                <span class="font-weight-bold">Grade:</span> <?= $grade ?>/<?= $maxScore ?>
                            </div>
                        <?php else: ?>
                            <div>
                                <span class="font-weight-bold">Grade:</span> N/A
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </a>
<?php endforeach; ?>






<div id="studentSubmissions"></div>
<script>
    // Function to show submissions for a specific student
    function showStudentSubmissions(studentId) {
        // Clear the previous submissions
        document.getElementById('studentSubmissions').innerHTML = '';

        // Get the student's submissions
        var student = <?php echo json_encode($studentSubmissions); ?>;
        var submissions = student[studentId].submissions;

        // Display the student's submissions
        var submissionContainer = document.getElementById('studentSubmissions');
        submissions.forEach(function(submission) {
            var card = document.createElement('div');
            card.classList.add('card', 'mt-3');

            var cardBody = document.createElement('div');
            cardBody.classList.add('card-body');

            cardBody.innerHTML = 'Submission ID: ' + submission.id + '<br>' +
                'Location: ' + submission.location + '<br>' +
                'Max Score: ' + submission.maxScore + '<br>' +
                'Submission Date: ' + new Date(submission.submissionDate).toLocaleString() + '<br>' +
                'Deadline: ' + new Date(submission.deadline).toLocaleString() + '<br>' +
                'Status: ' + submission.submissionStatus + '<br>' +
                'Assignment: ' + submission.assignmentName + '<br>' +
                'Description: ' + submission.assignmentDescription + '<br>' +
                'floc: ' + submission.floc;

            card.appendChild(cardBody);
            submissionContainer.appendChild(card);
        });
    }
</script>

            </div>
        </div>
    </div>
</div>

                        <!-- Grade Pop Up Modal -->
                        <div class="modal fade" id="grade_assignmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Grade Assignment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="POST">
                                            <div class="form-group">
                                                <label for="grade">Maximum Score:</label>
                                                <input type="number" id="grade" name="grade" placeholder="Enter Max Score" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="comments">Comments</label>
                                                <textarea class="form-control" id="editor1" name="comments" rows="4" max-length="5000" required placeholder="Enter Learning Objective(s)"></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="submit" id="submitButton" name="upload_assignment" class="btn btn-success">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>

  <?php          } else {
    // The teacher does not have access to this class
    echo '<script>window.location.href = "../deny.php?reason=access_denied";</script>';
    exit; // Make sure to exit the script after the JavaScript redirect
}
?>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>

<style>
.custom-container {
    border: 1px solid #ccc;
    padding: 20px;
    margin-top: 20px;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    color: black;
    background-color: white;
}

/* Remove the anchor hover effect */
a:hover {
    text-decoration: none; /* Remove underline on hover */
    color: inherit; /* Inherit the text color from the parent element */
}
a {
    text-decoration: none; /* Remove underline */
    color: gray; /* Set the text color to black */
}
</style>
