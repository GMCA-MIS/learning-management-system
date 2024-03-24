<?php
include('student_session.php');
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
            <div class="d-sm-flex align-items-center justify-content-between mb-4"
                style="margin-top: 27px; margin-left: 10px;">
                <h3 class="h4 mb-0 text-gray-800">
                    <span style="font-weight: lighter;">
                        <?php echo $class_row['class_name']; ?>
                        <?php echo $class_row['subject_title']; ?>
                    </span> > Assignments
                </h3>
            </div>
        </nav>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
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
                                        <h5>Assignment Details</h5>
                                    </div>
                                    <hr>
                                </div>
                                <?php
                                // Get the assignment ID from the URL or wherever it's stored.
                                $assignment_id = $_GET['post_id'];
                                // Include database connection details
                                require("opener_db.php");
                                $conn = $connector->DbConnector();
                                // Function to retrieve file locations for a specific assignment
                                function getAssignmentFileLocations($assignment_id, $conn)
                                {
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
                                $query = "SELECT * FROM assignment WHERE assignment_id = $assignment_id AND class_id = $get_id";
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
                                    // Function to retrieve file locations for the assignment
                                    $fileLocations = getAssignmentFileLocations($assignment_id, $conn);
                                    ?>
                                    <!-- Assignment Card -->
                                    <div class="mt-3 position-relative">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <?php echo $row['fname']; ?>
                                            </h5>
                                            <p class="card-text rem">
                                                <strong>Due:</strong>
                                                <span style="font-size: 12px; color: black;">
                                                    <?php echo $deadline; ?>
                                                </span>
                                            </p>
                                            <hr>
                                            <p class="card-text">
                                                <?php echo $fdesc; ?>
                                            </p>
                                            <?php foreach ($fileLocations as $fileLocation):
                                                $filename = basename($fileLocation); // Extract the filename from the file path
                                                ?>
                                                <div>
                                                    <hr>
                                                    <a href="<?php echo $fileLocation; ?>" download="<?php echo $filename; ?>"
                                                        class="pdf-link">Downloadable File:
                                                        <?php echo $filename; ?>
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <iframe id="pdfViewer" style="display: none;" width="100%" height="1000"></iframe>
                            <button id="closePdfViewer" class="btn btn-success" style="display: none;">Close</button>
                        </div>
                    </div>
                    <!-- Right Column for Submission Details -->

                    <div class="col-md-6">
                        <div class="custom-container">


                            <hr>
                            <div class="header d-flex justify-content-between align-items-center">
                                <h6>Submissions</h6>
                                <button type="button" class="btn btn-success add_btn" data-toggle="modal"
                                    data-target="#upload_assignmentModal">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Submit Assignment
                                </button>
                            </div>
                            <hr>

                            <?php
                            // Make sure to connect to the database before executing this code
                            // Assuming you already have a valid database connection
                            
                            $query = mysqli_query($conn, "SELECT sa.*, s.firstname, s.lastname, s.location, a.max_score, a.deadline FROM student_assignment sa
                                    LEFT JOIN student s ON s.student_id = sa.student_id
                                    LEFT JOIN assignment a ON a.assignment_id = sa.assignment_id
                                    WHERE sa.assignment_id = '$post_id' AND sa.student_id = '$student_id'
                                    ORDER BY sa.assignment_fdatein DESC") or die(mysqli_error());

                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_array($query)) {
                                    $id = $row['student_assignment_id'];
                                    $location = $row['location'];
                                    $floc = $row['floc'];
                                    $firstname = $row['firstname'];
                                    $lastname = $row['lastname'];
                                    $maxScore = $row['max_score'];
                                    $comments = $row['comments'];
                                    $grade = $row['grade'];
                                    $submissionDate = strtotime($row['assignment_fdatein']);
                                    $submissionStatus = ($submissionDate <= strtotime($row['deadline'])) ? 'On time' : 'Late';
                                    // Use retrieved data as needed
                                    ?>
                                    <div class="card mt-3">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <!-- Submit Assignment Button -->
                                                <div class="ml-2">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <img src="<?php echo $location; ?>" class="img-circle"
                                                                style="height: 30px; width: 30px; border-radius: 50%;">
                                                        </div>
                                                        <div>
                                                            <span
                                                                class="submission-status ml-2 <?php echo ($submissionStatus === 'On time') ? 'btn btn-ontime' : 'btn btn-danger'; ?>">
                                                                <?php echo $submissionStatus; ?>
                                                            </span>
                                                        </div>
                                                        <div class="ml-auto"> <!-- Add ml-auto class to push it to the right -->
                                                            <strong>Grade: </strong>
                                                            <?php echo isset($row['grade']) && isset($row['max_score']) ? ($row['grade'] . '/' . $row['max_score']) : 'N/A'; ?>
                                                        </div>
                                                    </div>

                                                    <div class="text-muted small">
                                                        <?php echo date("F d, Y h:i A", $submissionDate); ?>
                                                    </div>
                                                    <!-- Add a line (horizontal rule) here -->
                                                    <hr>
                                                    <div>
                                                        <div>
                                                            <?php echo $row['fdesc']; ?>
                                                        </div>

                                                        <!-- Downloadable files within the card -->
                                                        <?php
                                                        $fileLocations = json_decode($row['floc'], true); // Assuming it's a JSON-encoded array of file locations
                                                        foreach ($fileLocations as $fileLocation):
                                                            ?>
                                                            <div>
                                                                <a href="<?php echo $fileLocation; ?>"
                                                                    download="<?php echo basename($fileLocation); ?>"
                                                                    class="pdf-link">
                                                                    Download File:
                                                                    <?php echo basename($fileLocation); ?>
                                                                </a>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <div class="ml-auto">
                                                    <!-- Additional content on the right side if needed -->
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="ml-4">
                                            <h6> Teacher's Comment:</h6>
                                            <p class="rem">
                                                <?php echo $comments ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                // Display a message when there are no submissions
                                echo '<div class="alert alert-info mt-3">No submissions yet.</div>';
                            }
                            ?>
                        </div>
                    </div>

                </div>
                <iframe id="pdfViewer" style="width: 100%; height: 90vh;" frameborder="0"></iframe>
                <hr>
                <button id="closePdfViewer" class="btn btn-success" style="display: none;">Close</button>
                <!-- Content Row -->




                <!-- Add Pop Up Modal -->
                <div class="modal fade" id="upload_assignmentModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Submit Assignment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ul class="nav nav-tabs" id="assignmentTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="uploadTab" data-toggle="tab" href="#uploadAssignment"
                                            role="tab" aria-controls="uploadAssignment" aria-selected="false">Upload</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="createTab" data-toggle="tab"
                                            href="#createAssignment" role="tab" aria-controls="createAssignment"
                                            aria-selected="true">Create</a>
                                    </li>
                                </ul>
                                <hr>
                                <div class="tab-content" id="assignmentTabsContent">
                                    <div class="tab-pane fade" id="uploadAssignment" role="tabpanel"
                                        aria-labelledby="uploadTab">
                                        <form action="class_assignments-function.php" method="post"
                                            enctype="multipart/form-data">
                                            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                            <input type="hidden" name="get_id" value="<?php echo $get_id; ?>">
                                            <!-- <div class="form-group">
                                                <label for="uploadTitle">Assignment Title</label>
                                                <input type="text" class="form-control" id="uploadTitle" name="uploadTitle" required placeholder="Enter Assignment Title">
                                            </div> -->
                                            <div class="form-group">
                                                <input name="uploaded_files[]" class="input-file uniform_on"
                                                    id="fileInput" required type="file" multiple>
                                            </div>
                                            <div class="form-group">
                                                <label for="desc">Notes:</label>
                                                <textarea class="form-control" id="desc" name="desc" rows="4"
                                                    placeholder="Enter Notes"></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" id="submitButton" name="upload_assignment"
                                                    class="btn btn-success">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade show active" id="createAssignment" role="tabpanel"
                                        aria-labelledby="createTab">
                                        <form action="class_assignments-function.php" method="post"
                                            enctype="multipart/form-data">
                                            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                            <input type="hidden" name="get_id" value="<?php echo $get_id; ?>">
                                            <div class="form-group">
                                                <label for="description">Create:</label>
                                                <textarea class="form-control" id="desc" name="desc" rows="4"
                                                    placeholder="Enter Answer"></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Close</button>
                                                    <button type="submit" id="submitButton" name="upload_assignment"
                                                    class="btn btn-success">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
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
            text-decoration: none;
            /* Remove underline on hover */
            color: inherit;
            /* Inherit the text color from the parent element */
        }

        a {
            text-decoration: none;
            /* Remove underline */
            color: gray;
            /* Set the text color to black */
        }
    </style>
    </body>

    </html>