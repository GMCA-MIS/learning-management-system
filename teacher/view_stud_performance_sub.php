<?php 
include('teacher_session.php');
?>
<?php $get_id = $_GET['get_id']; ?>
<?php
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
include('dbcon.php');
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

// Check if any rows are returned
if (mysqli_num_rows($class_query) == 0) {
    // Redirect to deny.php
    echo '<script>window.location.href = "../deny.php";</script>';
    exit(); // Make sure to exit after the header redirection
}

?>
<?php
// Assuming $conn is your database connection
$query_assignment = mysqli_query($conn, "SELECT task_title FROM task WHERE task_id = '$post_id'");
$row_assignment = mysqli_fetch_assoc($query_assignment);
$assignment_title = $row_assignment['task_title'];

$get_id = mysqli_real_escape_string($conn, $get_id); // Sanitize input

$query = mysqli_query($conn, "SELECT tc.teacher_class_id, c.class_name
                              FROM teacher_class tc
                              JOIN class c ON tc.class_id = c.class_id
                              WHERE tc.teacher_class_id = '$get_id'");

$row = mysqli_fetch_assoc($query);
if ($row) {
    $class_name = $row['class_name'];

} else {
    echo "No matching record found.";
}
?>
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
                <span style="font-weight: lighter;"><?php echo $class_name ?> > <strong><?php echo htmlspecialchars($assignment_title); ?></strong></span>
                </h3>
            </div>
        </nav>
        <!-- End of Topbar -->
        <?php
// Check if the assignment has been graded by querying the database
$studentId = $_GET['student_id'];
$assignmentId = $post_id;
$gradingQuery = mysqli_query($conn, "SELECT score FROM task_result WHERE student_id = '$studentId' AND task_id = '$assignmentId'");

// Default button text
$buttonText = "Grade Assignment";

if (mysqli_num_rows($gradingQuery) > 0) {
    // Assignment has been graded, update the button text
    $buttonText = "Update Grade";
}
?>
   <!-- Begin Page Content -->
<!-- Left Column for the first card -->
<div class="col-md-6">
    <div class="container mt-4">
        <!-- Custom Container with Title (First Card) -->
        <div class="custom-container">
            <div class="header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Submission Details</h4>


<button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#grade_assignmentModal">
    <?php echo $buttonText; ?>
</button>
                </div>
            </div>
            <hr>
            <?php
if (isset($_GET['student_id'])) {
    $studentId = $_GET['student_id'];

    // Fetch and display student's submissions for the selected student, subject, and assignment
    $query = mysqli_query($conn, "SELECT sa.*, a.deadline FROM task_result sa
    JOIN task a ON sa.task_id = a.task_id
    WHERE sa.student_id = '$studentId' AND sa.task_id = '$post_id'");


    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $floc = $row['floc'];
            $fname = $row['fname'];
            $fdesc = $row['fdesc'];
            $submissionDate = strtotime($row['submitted_date']);
            $submissionStatus = ($submissionDate <= strtotime($row['deadline'])) ? 'On time' : 'Late';

            // Split file locations into an array using a delimiter (e.g., comma)
            $fileLocations = explode(',', $floc);

            ?>
            <!-- Create a new card for each submission -->
            <div class="card mt-3">
                <div class="card-body">
                <span class="submission-status <?php echo ($submissionStatus === 'On time') ? 'btn btn-ontime' : 'btn btn-danger'; ?>">
                        <?php echo $submissionStatus; ?>
                    </span>
                    <p>Name:</strong> <?php echo $fname; ?></p>
                    <p>Description:</strong> <?php echo $fdesc; ?></p>

                    <!-- Downloadable files within the card -->
                    <?php
                    foreach ($fileLocations as $fileLocation) {
                        $filename = basename($fileLocation);
                        ?>
                        <div>
                            <hr>
                            <a href="<?php echo '../' . $fileLocation; ?>" download="<?php echo basename($fileLocation); ?>">
                                Download: <?php echo basename($fileLocation); ?>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
    } else {
        // Redirect to access denied page
        echo '<script>window.location.href = "../deny.php?reason=access_denied";</script>';
        exit;
    }
} else {
    // Redirect to access denied page
    echo '<script>window.location.href = "../deny.php?reason=access_denied";</script>';
    exit;
}
?>
        </div>
    </div>
</div>


<?php
// Assuming you have a database connection established
$pos_id = $_GET['post_id'];

$query = "SELECT max_score AS max_score FROM task WHERE task_id = $pos_id";

// Execute the query and fetch the result
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Fetch the result as an associative array
    $row = mysqli_fetch_assoc($result);

    // Access the max_score value
    $maxScore = $row['max_score'];

 
} else {
    // Handle the case where the query was not successful
    echo "Error executing query: " . mysqli_error($conn);
}


?>

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
                                                <label for="grade">Score:</label>
                                                <input type="number" id="grade" name="grade" min="1" max="<?php echo $maxScore?>" placeholder="Max score is <?php echo $maxScore?>" required place>
                                            </div>
                                            <div class="form-group">
                                                <label for="comments">Comments</label>
                                                <textarea class="form-control" id="editor1" name="comments" rows="4" max-length="5000" required placeholder="Enter Learning Objective(s)"></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="submit" id="submitButton" name="grade_assignment" class="btn btn-success">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
if (isset($_POST['grade_assignment'])) {
    $studentId = $_GET['student_id'];
    $grade = $_POST['grade'];
    $comments = $_POST['comments'];

    // Add validation and sanitization for $grade and $comments if needed

    // Fetch the assignment details, including max_score
    $assignmentQuery = "SELECT max_score,task_title FROM task WHERE task_id = '$post_id'";
    $assignmentResult = mysqli_query($conn, $assignmentQuery);

    if ($assignmentResult) {
        $assignmentData = mysqli_fetch_assoc($assignmentResult);
        $maxScore = $assignmentData['max_score'];
        $fname = $assignmentData['task_title'];


 // Check if the grade exceeds the max_score
 if ($grade > $maxScore) {
    // Display an error message using SweetAlert
    echo "<script>
          Swal.fire({
            title: 'Error',
            text: 'Score cannot be higher than the maximum score.',
            icon: 'error',
            confirmButtonText: 'OK'
          }).then(function() {
            window.location.href = 'view_stud_performance_sub.php?student_id=$studentId&post_id=$post_id&get_id=$get_id';
          });
         </script>";
} else {
    // Update the grade and comments in the student_assignment table
    $updateQuery = "UPDATE task_result SET grade_status = '1', score = '$grade', comments = '$comments' WHERE student_id = '$studentId' AND task_id = '$post_id'";
    
    // Execute the query
    if (mysqli_query($conn, $updateQuery)) {
        // Display a success message using SweetAlert
        $notificationMessage = "Task : <b>$fname</b> has been Graded";
        $link = "view_class_performancetask.php?student_id=".$studentId."&task_id=".$post_id."&id=".$get_id;

        $insertNotificationQuery = "INSERT INTO `notification` (teacher_class_id, notification, date_of_notification, link)
                                    VALUES ('$get_id', '$notificationMessage', NOW(), '$link')";
        mysqli_query($conn, $insertNotificationQuery);

        echo "<script>
          Swal.fire({
            title: 'Success',
            text: 'Grade and comments updated successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
          }).then(function() {
            window.location.href = 'view_stud_performance_sub.php?student_id=$studentId&post_id=$post_id&get_id=$get_id';
          });
         </script>";
    } else {
        // Handle any errors if the query fails
        // Display an error message using SweetAlert
        echo "<script>
          Swal.fire({
            title: 'Error',
            text: 'Error updating score and comments: " . mysqli_error($conn) . "',
            icon: 'error',
            confirmButtonText: 'OK'
          }).then(function() {
            window.location.href = 'view_stud_performance_sub.php?student_id=$studentId&post_id=$post_id&get_id=$get_id';
          });
         </script>";
    }
}
} else {
// Display an error message using SweetAlert
echo "<script>
          Swal.fire({
            title: 'Error',
            text: 'Error fetching Task Performance details: " . mysqli_error($conn) . "',
            icon: 'error',
            confirmButtonText: 'OK'
          }).then(function() {
            window.location.href = 'view_stud_performance_sub.php?student_id=$studentId&post_id=$post_id&get_id=$get_id';
          });
         </script>";
}
}
                        
                        ?>


                    </div>
                </div>
          

                </div>     

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
