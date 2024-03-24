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
                        </span> > Performance Task
                    </h3>

                </div>

                <!-- Topbar Navbar -->
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Content Row -->
                <div class="card-body">
                    <div class="modal-body">
                        <ul class="nav nav-tabs" id="assignmentTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" style="color:black;" id="uploadTab" data-toggle="tab"
                                    href="#assignments" role="tab" aria-controls="assignments"
                                    aria-selected="false">Performance Tasks</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " style="color:black" id="createTab" data-toggle="tab" href="#archived"
                                    role="tab" aria-controls="f2f" aria-selected="true"> <i class="fa fa-archive"
                                        aria-hidden="true"></i> Archived</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="assignmentTabsContent">
                        <div class="tab-pane fade show active" id="assignments" role="tabpanel" aria-labelledby="uploadTab">
                            <button type="button" class="btn btn-success add_btn" data-toggle="modal"
                                data-target="#add_assignmentModal">
                                <i class="fa fa-plus" aria-hidden="true"></i> Create Task</button>
                            <!-- Custom Container with Title -->
                            <div class="custom-container">
                                <h5>Performance Task List</h5>
                                <hr>
                                <?php
                                // Assuming you have already started the session
                                // Get the teacher ID from the session
                                $teacher_id = $_SESSION['teacher_id'];

                                // Query to retrieve Tasks
                                $query = "SELECT * FROM task WHERE teacher_class_id = $get_id AND status = 'Available' ";
                                $result = mysqli_query($conn, $query);


                                if (mysqli_num_rows($result) === 0) {
                                    echo '<center> <div class="alert alert-warning">You have not posted a task yet.</div></center>';
                                } else {
                                    while ($row = mysqli_fetch_array($result)) {
                                        $task_id = $row['task_id'];
                                        $date_added = $row['date_added'];
                                        $task_title = $row['task_title'];
                                        $task_description = $row['task_description'];
                                        $task_objective = $row['task_objective'];
                                        ?>
                                        
                                        <!-- Peta Card -->
                                             <a href="view_class_peta.php?id=<?php echo $get_id ?>&task_id=<?php echo $task_id; ?>">
                                                    <div class="card mt-3 position-relative">
                                                        <div class="card-body">
                                                            <h6 class="card-title" style="color:black;">
                                                                <?php echo $row['task_title']; ?>
                                                            </h6>
                                                            <h6 class="card-title">
                                                                <?php echo $row['task_description']; ?>
                                                            </h6>
                                                            <div class="d-flex justify-content-end">
                                                                <!-- Delete Icon -->
                                                                <a href="class_grades-function.php?action=archive&id=<?php echo $task_id; ?>&get_id=<?php echo $get_id ?>" class="btn btn-danger btn-sm position-absolute top-0 end-100">
                                                                    <i class="fa fa-times-circle" aria-hidden="true"></i> Archive
                                                                </a>

                                                            </div>
                                                            <p class="card-text rem"><strong>Created at:</strong>
                                                                <?php echo date('F j, Y \a\t g:i A', strtotime($date_added)); ?>
                                                            </p>
                                                            <p class="card-text rem"><strong>Learning Objectives:</strong>
                                                                <div class="card-text rem"> <?php echo $task_objective; ?> </div>
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
                                    <h5>Archived Performance Tasks</h5>
                                </div>
                                <hr>
                                <?php
                                // Assuming you have already started the session
                                // Get the teacher ID from the session
                                $teacher_id = $_SESSION['teacher_id'];

                                // Query to retrieve assignments
                                $query = "SELECT * FROM task WHERE teacher_class_id = '$get_id' AND status = 'Archived'  ORDER BY date_added DESC";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) === 0) {
                                    echo '<center> <div class="alert alert-warning text-center">No Archived tasks yet.</div></center>';
                                } else {
                                    while ($row = mysqli_fetch_array($result)) {
                                        $id = $row['task_id'];
                                        $task_title = $row['task_title'];
                                        $max_score = $row['max_score'];
                                        $task_objective = $row['task_objective'];


                                        // Format the deadline
                                        $date_added = date("l, F d, Y  h:i A", strtotime($row['date_added']));
                                        ?>
                                        <!-- Assignment Card -->

                                        <div class="card mt-3 position-relative">
                                            <div class="card-body">
                                                <h6 class="card-title" style="color:black;">
                                                    <?php echo $row['task_title']; ?>
                                                </h6>
                                                <div class="d-flex justify-content-end">
                                                    <!-- Delete Icon -->
                                                    <a href="class_grades-function.php?action=available&id=<?php echo $id;?>&get_id=<?php echo $get_id ?>" class="btn btn-success btn-sm position-absolute top-0 end-100">
                                                        <i class="fa fa-check-circle" aria-hidden="true"></i> Restore
                                                    </a>
                                                </div>
                                                <p class="card-text rem"><strong>Created at:</strong>
                                                    <?php echo $date_added; ?>
                                                </p>
                                                <p class="card-text rem"><strong>Learning Objectives:</strong>
                                                    <?php echo $task_objective; ?>
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

        <!--Add Pop Up Modal -->
        <div class="modal fade" id="add_assignmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form class="" action="class_grades-function.php" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="get_id" value="<?php echo $get_id ?>">
                            <div class="form-group">
                                <label for="title">Task Title</label>
                                <input type="text" class="form-control" id="title" name="title" required
                                    placeholder="Enter Task Title">
                            </div>
                            <div class="form-group">
                                <label for="task_objective">Learning Objective</label>
                                <textarea class="form-control" id="description" name="task_objective" required
                                    placeholder="Enter Task Objective(s)"> </textarea>
                            </div>
                            <div class="form-group">
                                <label for="max_score">Max Score</label>
                                <input type="number" class="form-control" id="max_score" name="max_score" required
                                    placeholder="Enter Max Score">
                            </div>
                            <hr>
                            <br>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" name="add_task" class="btn btn-success">Create</button>
                        </div>
                    </form>
                </div> <!--modal content -->
            </div> <!--modal dialog -->
        </div> <!--modal fade -->

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