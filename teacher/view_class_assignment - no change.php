<?php 
include('teacher_session.php');
?>
<?php $get_id = $_GET['id']; ?>
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
if($post_id == '') {
    ?>

    <?php
}
?>

<!-- breadcrumb -->
<?php
$class_query = mysqli_query($conn, "SELECT * FROM teacher_class
    LEFT JOIN class ON class.class_id = teacher_class.class_id
    LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
    WHERE teacher_class_id = '$get_id'") or die(mysqli_error());
$class_row = mysqli_fetch_array($class_query);
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
                    <span style="font-weight: lighter;"><?php echo $class_row['class_name']; ?></span> > Assignments
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
                                <h5 class="modal-title" id="exampleModalLabel">Edit Assignment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form class="" action="class_assignments-function.php<?php echo '?id=' . $get_id; ?>" method="post" enctype="multipart/form-data" name="upload">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Assignment Title</label>
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
                                <h4>Assignment Details</h4>
                                <a href="class_edit_assignment.php?post_id=<?php echo $post_id; ?>&id=<?php echo $get_id; ?>" class="btn btn-success edit_btn">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                        <hr>
                            <?php
                            $teacher_id = $_SESSION['teacher_id'];
                            // Get the assignment ID from the URL or wherever it's stored.
                            $assignment_id = $_GET['post_id'];

                            // Include database connection details
                            require("opener_db.php");

                            $conn = $connector->DbConnector();

                            // Function to retrieve file locations for a specific assignment
                            function getAssignmentFileLocations($assignment_id, $conn) {
                                $query = "SELECT floc FROM assignment WHERE assignment_id = $assignment_id";
                                $result = mysqli_query($conn, $query);

                                if ($result) {
                                    $row = mysqli_fetch_assoc($result);
                                    if ($row && isset($row['floc'])) {
                                        return json_decode($row['floc'], true);
                                    }
                                }

                                return [];
                            }

                            // Query to retrieve the assignment details and check authorization
                            $query = "SELECT * FROM assignment WHERE assignment_id = $assignment_id AND teacher_id = $teacher_id";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) === 0) {
                                echo '<center> <div class="no-assignments-message">Assignment not found.</div></center>';
                            } else {
                                $row = mysqli_fetch_array($result);

                                // Now you can access the assignment details using $row.
                                $id = $row['assignment_id'];
                                $floc = $row['floc'];
                                $deadline = date("l, F d, Y  h:i A", strtotime($row['deadline']));
                                $fdesc = $row['fdesc'];
                                $learning_objectives = $row['learning_objectives'];

                                // Function to retrieve file locations for the assignment
                                $fileLocations = getAssignmentFileLocations($assignment_id, $conn);
                            ?>

                            <!-- Assignment Card -->
                            <div class="mt-3 position-relative">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['fname']; ?></h5>
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
                                        $filename = basename($fileLocation); // Extract the filename from the file path
                                    ?>
                                    <div> <hr>
                                       <a href="<?php echo $fileLocation; ?>" download="<?php echo $filename; ?>"> Downloadable File: <?php echo $filename; ?></a>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Right Column for Submission Details -->
                <div class="col-md-6">
                    <div class="custom-container"> 
                        <div class="header">
                            <h6>Submissions</h6>
                            <hr>
                <?php
$query = mysqli_query($conn, "SELECT sa.*, s.*, s.location, a.max_score, a.deadline FROM student_assignment sa
    LEFT JOIN student s ON s.student_id = sa.student_id
    LEFT JOIN assignment a ON a.assignment_id = sa.assignment_id
    WHERE sa.assignment_id = '$post_id' AND teacher_id = '$teacher_id'
    ORDER BY sa.assignment_fdatein DESC") or die(mysqli_error());



                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_array($query)) {
                        $id = $row['student_assignment_id'];
                        $location = $row['location'];
                        $firstname = $row['firstname'];
                        $lastname = $row['lastname'];
                        $maxScore = $row['max_score'];
                        $submissionDate = strtotime($row['assignment_fdatein']);
                        $deadline = strtotime($row['deadline']);
                        $submissionStatus = ($submissionDate <= $deadline) ? 'Submitted on time' : 'Submitted late';
                    ?>
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="ml-2">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="../<?php echo $location; ?>" class="img-circle" style="height: 30px; width: 30px; border-radius: 50%;">
                                    </div>
                                    <div>
                                        <span class="font-weight-bold"><?php echo $firstname . " " . $lastname; ?></span>
                                        <span class="submission-status ml-2 <?php echo ($submissionDate <= $deadline) ? 'btn btn-ontime' : 'btn btn-danger'; ?>">
                                            <?php echo $submissionStatus; ?>
                                        </span>

                                    </div>
                                </div>
                                <div class="text-muted small"><?php echo date("F d, Y h:i A", $submissionDate); ?></div>
                                <!-- Add a line (horizontal rule) here -->
                                <hr>
                                <div>
                                    <strong><?php echo $row['fname']; ?></strong>
                                    <div><?php echo $row['fdesc']; ?></div>
                                </div>
                            </div>
                            <div class="ml-auto">
                                <strong>Grade: </strong><?php echo isset($row['grade']) && isset($row['max_score']) ? ($row['grade'] . '/' . $row['max_score']) : 'N/A'; ?>
                            </div>
                        </div>
                    </div>
                </div>



    <?php
    }
} else {
    // Display a message when there are no submissions
    echo '<div class="alert alert-info mt-3">No submissions available.</div>';
}
?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Content Row -->
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
