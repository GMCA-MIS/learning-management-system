<?php
include('teacher_session.php'); ?>
<?php $get_id = $_GET['id']; ?>
<?php
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
include('dbcon.php');
include('initialize.php');
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
                <div class="d-sm-flex align-items-center justify-content-between mb-4"
                    style="margin-top: 27px; margin-left: 10px;">
                    <h3 class="h4 mb-0 text-gray-800">
                        <span style="font-weight: lighter;">
                            <?php echo $class_row['class_name']; ?>
                        </span> > Assignments
                    </h3>

                </div>


            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <td>
                    <!--Add Pop Up Modal -->
                    <div class="modal fade" id="add_assignmentModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Assignment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form class="" action="class_assignments-function.php<?php echo '?id=' . $get_id; ?>"
                                    method="post" enctype="multipart/form-data" name="upload">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name">Assignment Title</label>
                                            <input type="text" class="form-control" id="name" name="name" required
                                                placeholder="Enter Assignment Title">
                                        </div>

                                        <div class="form-group">
                                            <input name="uploaded_files[]" class="input-file uniform_on" id="fileInput"
                                                type="file" multiple>
                                            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                                            <input type="hidden" name="id" value="<?php echo $session_id ?>" />
                                            <input type="hidden" name="id_class" value="<?php echo $get_id; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="desc">Description</label>
                                            <textarea class="form-control" id="description" name="desc" rows="4"
                                                max-length="5000" required placeholder="Enter Description"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="learning_objectives">Learning Objective(s)</label>
                                            <textarea class="form-control" id="editor1" name="learning_objectives" rows="4"
                                                max-length="5000" required
                                                placeholder="Enter Learning Objective(s)"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="max_score">Maximum Score:</label>
                                            <input type="number" id="max_score" name="max_score"
                                                placeholder="Enter Max Score" min="1" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="deadline">Deadline:</label>
                                            <input type="datetime-local" class="form-control flatpickr" id="deadline"
                                                name="deadline" placeholder="Enter Deadline" required>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" name="add_assignment" class="btn btn-success">Create</button>
                                    </div>
                                </form>
                            </div> <!--modal content -->
                        </div> <!--modal dialog -->
                    </div> <!--modal fade -->

                    <!--Add Pop Up Modal -->
                    <div class="modal fade" id="add_assignmentModal2" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Assignment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form class="" action="class_assignments-function.php<?php echo '?id=' . $get_id; ?>"
                                    method="post" enctype="multipart/form-data" name="upload">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name">Assignment Title</label>
                                            <input type="text" class="form-control" id="name" name="name" required
                                                placeholder="Enter Assignment Title">
                                        </div>
                                            <input type="hidden" name="id" value="<?php echo $session_id ?>" />
                                            <input type="hidden" name="id_class" value="<?php echo $get_id; ?>">
                                        <div class="form-group">
                                            <label for="desc">Description</label>
                                            <textarea class="form-control" id="description" name="desc" rows="4"
                                                max-length="5000" required placeholder="Enter Description"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="learning_objectives">Learning Objective(s)</label>
                                            <textarea class="form-control" id="editor1" name="learning_objectives" rows="4"
                                                max-length="5000" required
                                                placeholder="Enter Learning Objective(s)"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="max_score">Maximum Score:</label>
                                            <input type="number" id="max_score" name="max_score"
                                                placeholder="Enter Max Score" required>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" name="add_assignment2" class="btn btn-success">Add</button>
                                    </div>
                                </form>
                            </div> <!--modal content -->
                        </div> <!--modal dialog -->
                    </div> <!--modal fade -->


              
                </td>

                </head>

                <body>

                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <!-- Content Row -->
                        <div class="card-body">
                            <div class="modal-body">
                                <ul class="nav nav-tabs" id="assignmentTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active"  style = "color:black;" id="uploadTab" data-toggle="tab" href="#assignments"
                                            role="tab" aria-controls="assignments" aria-selected="false">Assignments</a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link " style = "color:black" id="createTab" data-toggle="tab" href="#archived"
                                            role="tab" aria-controls="f2f" aria-selected="true"> <i class="fa fa-archive" aria-hidden="true"></i> Archived</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content" id="assignmentTabsContent">
                                <div class="tab-pane fade show active" id="assignments" role="tabpanel"
                                    aria-labelledby="uploadTab">
                                    <button type="button" class="btn btn-success add_btn" data-toggle="modal"
                                    data-target="#add_assignmentModal">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Create Assignment</button>
                                    <!-- Custom Container with Title -->
                                    <div class="custom-container">
                                        
                                        <div class="header  pb-2 pt-2 pl-4" style="background-color: white;">
                                            <h5>Assignment List</h5>
                                        </div>
                                        <hr>
                                        <?php
                                        // Assuming you have already started the session
                                        // Get the teacher ID from the session
                                        $teacher_id = $_SESSION['teacher_id'];

                                        // Query to retrieve assignments
                                        $query = "SELECT * FROM assignment WHERE class_id = '$get_id' AND teacher_id = '$teacher_id' AND status = 'Available' AND type = '0' ORDER BY fdatein DESC";
                                        $result = mysqli_query($conn, $query);

                                        if (mysqli_num_rows($result) === 0) {
                                            echo '<center> <div class="alert alert-warning text-center">You have not posted an assignment yet.</div></center>';
                                        } else {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $id = $row['assignment_id'];
                                                $floc = $row['floc'];

                                                // Format the deadline
                                                $deadline = date("l, F d, Y  h:i A", strtotime($row['deadline']));
                                                $fdatein = date("l, F d, Y  h:i A", strtotime($row['fdatein']));
                                                ?>
                                                <!-- Assignment Card -->
                                                <a
                                                    href="view_class_assignment.php?id=<?php echo $get_id ?>&post_id=<?php echo $id ?>">
                                                    <div class="card mt-3 position-relative">
                                                        <div class="card-body">
                                                            <h6 class="card-title" style="color:black;">
                                                                <?php echo $row['fname']; ?>
                                                            </h6>
                                                            <div class="d-flex justify-content-end">
                                                                <!-- Delete Icon -->
                                                                <a href="class_assignments-function.php?action=archive&id=<?php echo $id; ?>&get_id=<?php echo $get_id ?>" class="btn btn-danger btn-sm position-absolute top-0 end-100">
                                                                    <i class="fa fa-times-circle" aria-hidden="true"></i> Archive
                                                                </a>

                                                            </div>
                                                            <p class="card-text rem"><strong>Due:</strong>
                                                                <?php echo $deadline; ?>
                                                            </p>
                                                            <p class="card-text rem"><strong>Created at:</strong>
                                                                <?php echo $fdatein; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>


                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="tab-pane fade " id="f2f" role="tabpanel" aria-labelledby="createTab">
                                    <!-- Custom Container with Title -->
                                    <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_assignmentModal2">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Add Assignment
                                    </button>
                                    <div class="custom-container">
                                        <div class="header  pb-2 pt-2 pl-4" style="background-color: white;">
                                            <h5>Assignment List (F2F)</h5>
                                        </div>
                                        <hr>
                                        <?php
                                        // Assuming you have already started the session
                                        // Get the teacher ID from the session
                                        $teacher_id = $_SESSION['teacher_id'];

                                        // Query to retrieve assignments
                                        $query = "SELECT * FROM assignment WHERE class_id = '$get_id' AND teacher_id = '$teacher_id' AND status = 'Available' AND type = '1' ORDER BY fdatein DESC";
                                        $result = mysqli_query($conn, $query);

                                        if (mysqli_num_rows($result) === 0) {
                                            echo '<center> <div class="alert alert-warning text-center">You have not posted an assignment yet.</div></center>';
                                        } else {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $id = $row['assignment_id'];
                                                $floc = $row['floc'];
                                                $learning_objectives = $row['learning_objectives'];


                                                // Format the deadline
                                                $fdatein = date("l, F d, Y  h:i A", strtotime($row['fdatein']));
                                                ?>
                                                <!-- Assignment Card -->
                                                <a
                                                    href="view_class_assignment_f2f.php?id=<?php echo $get_id ?>&post_id=<?php echo $id ?>">
                                                    <div class="card mt-3 position-relative">
                                                        <div class="card-body">
                                                            <h6 class="card-title" style="color:black;">
                                                                <?php echo $row['fname']; ?>
                                                            </h6>
                                                            <div class="d-flex justify-content-end">
                                                                <!-- Delete Icon -->
                                                                <a href="class_assignments-function.php?action=archive&id=<?php echo $id; ?>&get_id=<?php echo $get_id; ?>" class="btn btn-danger btn-sm position-absolute top-0 end-100">
                                                                    <i class="fa fa-times-circle" aria-hidden="true"></i> Archive
                                                                </a>
                                                            </div>
                                                            <p class="card-text rem"><strong>Created at:</strong>
                                                                <?php echo $fdatein; ?>
                                                            </p>
                                                            <p class="card-text rem"><strong>Learning Objectives:</strong>
                                                                <?php echo $learning_objectives; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>


                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    </div>
                                    <div class="tab-pane fade " id="archived" role="tabpanel" aria-labelledby="createTab">
                                    <!-- Custom Container with Title -->
                                    <!-- <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_assignmentModal2">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Archive Assignment
                                    </button> -->
                                    <div class="custom-container">
                                        <div class="header  pb-2 pt-2 pl-4" style="background-color: white;">
                                            <h5>Archived Assignments</h5>
                                        </div>
                                        <hr>
                                        <?php
                                        // Assuming you have already started the session
                                        // Get the teacher ID from the session
                                        $teacher_id = $_SESSION['teacher_id'];

                                        // Query to retrieve assignments
                                        $query = "SELECT * FROM assignment WHERE class_id = '$get_id' AND teacher_id = '$teacher_id' AND status = 'Archived'  ORDER BY fdatein DESC";
                                        $result = mysqli_query($conn, $query);

                                        if (mysqli_num_rows($result) === 0) {
                                            echo '<center> <div class="alert alert-warning text-center">No Archived Assignments yet.</div></center>';
                                        } else {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $id = $row['assignment_id'];
                                                $floc = $row['floc'];
                                                $learning_objectives = $row['learning_objectives'];


                                                // Format the deadline
                                                $fdatein = date("l, F d, Y  h:i A", strtotime($row['fdatein']));
                                                ?>
                                                <!-- Assignment Card -->
                                               
                                                    <div class="card mt-3 position-relative">
                                                        <div class="card-body">
                                                            <h6 class="card-title" style="color:black;">
                                                                <?php echo $row['fname']; ?>
                                                            </h6>
                                                            <div class="d-flex justify-content-end">
                                                                <!-- Delete Icon -->
                                                                <a href="class_assignments-function.php?action=available&id=<?php echo $id; ?>&get_id=<?php echo $get_id; ?>" class="btn btn-success btn-sm position-absolute top-0 end-100">
                                                                    <i class="fa fa-check-circle" aria-hidden="true"></i> Restore
                                                                </a>
                                                            </div>
                                                            <p class="card-text rem"><strong>Created at:</strong>
                                                                <?php echo $fdatein; ?>
                                                            </p>
                                                            <p class="card-text rem"><strong>Learning Objectives:</strong>
                                                                <?php echo $learning_objectives; ?>
                                                            </p>
                                                        </div>
                                                    </div>


                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>



                                <!-- Content Row -->

                            </div>
                            <!-- /.container-fluid -->

                        <?php } else {
                                // The teacher does not have access to this class
                                echo '<script>window.location.href = "../deny.php?reason=access_denied";</script>';
                                exit; // Make sure to exit the script after the JavaScript redirect
                            }
                            ?>


                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->



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