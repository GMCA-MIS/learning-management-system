<?php 
include('teacher_session.php');  ?>
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                    <h3 class="h4 mb-0 text-gray-800">
                        <span style="font-weight: lighter;"><?php echo $class_row['class_name']; ?></span> > Exam
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
                                        href="#Exams" role="tab" aria-controls="Exams" aria-selected="false">Exams</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " style="color:black" id="createTab" data-toggle="tab"
                                        href="#examf2f" role="tab" aria-controls="examf2f" aria-selected="true">Exams
                                        (F2F)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " style="color:black" id="createTab" data-toggle="tab"
                                        href="#archived" role="tab" aria-controls="f2f" aria-selected="true"> <i
                                            class="fa fa-archive" aria-hidden="true"></i> Archived</a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content" id="assignmentTabsContent">
                            <div class="tab-pane fade show active" id="Exams" role="tabpanel" aria-labelledby="uploadTab">
                                <!-- <button type="button" class="btn btn-success add_btn" data-toggle="modal"
                                    data-target="#add_assignmentModal">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Create exam</button> -->
                                <!-- Custom Container with Title -->
                                <div class="custom-container">

                                    <div class="header  pb-2 pt-2 pl-4" style="background-color: white;">
                                        <h5>Exam List</h5>
                                    </div>
                                    <hr>
                                    <?php
                                    // Assuming you have already started the session
                                    // Get the teacher ID from the session
                                    $teacher_id = $_SESSION['teacher_id'];

                                    // Query to retrieve Exams
                                    $query = "SELECT cq.*,q.exam_description, q.exam_title, q.date_added, q.learning_objective
                                    FROM class_exam AS cq
                                    JOIN exam AS q ON cq.exam_id = q.exam_id
                                    WHERE cq.teacher_class_id = '$get_id' 
                                    AND q.status = 'Available' 
                                    AND q.type = '0' 
                                    AND cq.stats = '0'";
                                    $result = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($result) === 0) {
                                        echo '<center> <div class="alert alert-warning">You have not posted an exam yet.</div></center>';
                                    } else {
                                        while ($row = mysqli_fetch_array($result)) {
                                            $exam_id = $row['exam_id'];
                                            $date_added = date("l, F d, Y  \a\\t h:i A", strtotime($row['date_added']));
                                            $exam_title = $row['exam_title'];
                                            $exam_description = $row['exam_description'];
                                            $class_exam_id = $row['class_exam_id'];
                                            $exam_time = $row['exam_time'];
                                            $deadline = date("l, F d, Y  \a\\t h:i A", strtotime($row['deadline']));
                                            $learning_objective = $row['learning_objective'];
                                            ?>
                                          
                                            <!-- Exam Card -->
                                            <a href="view_class_exam.php?id=<?php echo $get_id?>&exam_id=<?php echo $exam_id; ?>">
                                                    <div class="card mt-3 position-relative">
                                                        <div class="card-body">
                                                            <h6 class="card-title" style="color:black;">
                                                                <?php echo $row['exam_title']; ?>
                                                            </h6>
                                                            <h6 class="card-title" style="color:black;">
                                                                <?php echo $row['exam_description']; ?>
                                                            </h6>
                                                            <div class="d-flex justify-content-end">
                                                                <!-- Delete Icon -->
                                                                <a href="exam-function.php?action=archivecq&id=<?php echo $exam_id; ?>&get_id=<?php echo $get_id ?>" class="btn btn-danger btn-sm position-absolute top-0 end-100">
                                                                    <i class="fa fa-times-circle" aria-hidden="true"></i> Archive
                                                                </a>
                                                            </div>
                                                            <p class="card-text rem"><strong>Created at:</strong>
                                                                <?php echo $date_added; ?>
                                                            </p>
                                                            <p class="card-text rem"><strong>Learning Objectives:</strong>
                                                                <?php echo $learning_objective; ?>
                                                            </p>
                                                            <p class="card-text rem"><strong>Deadline:</strong>
                                                                <?php echo $deadline; ?>
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

                            <div class="tab-pane fade " id="examf2f" role="tabpanel" aria-labelledby="createTab">
                                <!-- Custom Container with Title -->
                                <button type="button" class="btn btn-success add_btn" data-toggle="modal"
                                    data-target="#add_examModal">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add Exam
                                </button>
                                <!-- Custom Container with Title -->
                                <div class="custom-container">

                                    <div class="header  pb-2 pt-2 pl-4" style="background-color: white;">
                                        <h5>Exam List</h5>
                                    </div>
                                    <hr>
                                    <?php
                                    // Assuming you have already started the session
                                    // Get the teacher ID from the session
                                    $teacher_id = $_SESSION['teacher_id'];

                                    // Query to retrieve Exams
                                    $query = "SELECT cq.*, q.exam_description, q.exam_title, q.date_added, q.learning_objective 
                                    FROM class_exam AS cq
                                    JOIN exam AS q ON cq.exam_id = q.exam_id
                                    WHERE cq.teacher_class_id = '$get_id' AND q.status = 'Available' AND q.type = '1' AND cq.stats = '0'";
                          

                                    $result = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($result) === 0) {
                                        echo '<center> <div class="alert alert-warning">You have not posted a exam yet.</div></center>';
                                    } else {
                                        while ($row = mysqli_fetch_array($result)) {
                                            $exam_id = $row['exam_id'];
                                            $exam_title = $row['exam_title'];
                                            $exam_description = $row['exam_description'];
                                            $class_exam_id = $row['class_exam_id'];
                                            $learning_objective = $row['learning_objective'];
                                            $date_added = date("l, F d, Y  \a\\t h:i A", strtotime($row['date_added']));
                                            ?>
                                            <!-- Assignment Card -->
                                            <!-- exam Card -->
                                            <a
                                                    href="view_class_examf2f.php?id=<?php echo $get_id ?>&exam_id=<?php echo $exam_id ?>">
                                                    <div class="card mt-3 position-relative">
                                                        <div class="card-body">
                                                            <h6 class="card-title" style="color:black;">
                                                                <?php echo $row['exam_title']; ?>
                                                            </h6>
                                                            <h6 class="card-title" style="color:black;">
                                                                <?php echo $row['exam_description']; ?>
                                                            </h6>
                                                            <div class="d-flex justify-content-end">
                                                                <!-- Delete Icon -->
                                                                <a href="exam-function.php?action=archivecq&id=<?php echo $exam_id; ?>&get_id=<?php echo $get_id ?>" class="btn btn-danger btn-sm position-absolute top-0 end-100">
                                                                    <i class="fa fa-times-circle" aria-hidden="true"></i> Archive
                                                                </a>
                                                            </div>
                                                            <p class="card-text rem"><strong>Created at:</strong>
                                                                <?php echo $date_added; ?>
                                                            </p>
                                                            <p class="card-text rem"><strong>Learning Objectives:</strong>
                                                                <?php echo $learning_objective; ?>
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
                                <!-- Custom Container with Title -->
                                <div class="custom-container">

                                    <div class="header  pb-2 pt-2 pl-4" style="background-color: white;">
                                        <h5>Archived Exams</h5>
                                    </div>
                                    <hr>
                                    <?php
                                    // Assuming you have already started the session
                                    // Get the teacher ID from the session
                                    $teacher_id = $_SESSION['teacher_id'];

                                    // Query to retrieve examzes
                                    $query = "SELECT cq.*, q.exam_description, q.exam_title, q.date_added, q.learning_objective
                                    FROM class_exam AS cq
                                    JOIN exam AS q ON cq.exam_id = q.exam_id
                                    WHERE cq.teacher_class_id = '$get_id' AND cq.stats = 'Archived'";
                          

                                    $result = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($result) === 0) {
                                        echo '<center> <div class="alert alert-warning">No archived exams yet.</div></center>';
                                    } else {
                                        while ($row = mysqli_fetch_array($result)) {
                                            $exam_id = $row['exam_id'];
                                            $date_added = $row['date_added'];
                                            $exam_title = $row['exam_title'];
                                            $exam_description = $row['exam_description'];
                                            $class_exam_id = $row['class_exam_id'];
                                            $exam_time = $row['exam_time'];
                                            $deadline = $row['deadline'];
                                            $learning_objective = $row['learning_objective'];
                                            ?>

                                            <!-- exam Card -->
                                            <div class="card mt-3 position-relative">
                                                        <div class="card-body">
                                                            <h6 class="card-title" style="color:black;">
                                                                <?php echo $row['exam_title']; ?>
                                                            </h6>
                                                            <h6 class="card-title">
                                                                <?php echo $exam_description; ?>
                                                            </h6>
                                                            <div class="d-flex justify-content-end">
                                                                <!-- Delete Icon -->
                                                                <a href="exam-function.php?action=available&id=<?php echo $exam_id; ?>&get_id=<?php echo $get_id ?>" class="btn btn-success btn-sm position-absolute top-0 end-100">
                                                                    <i class="fa fa-check-circle" aria-hidden="true"></i> Restore
                                                                </a>
                                                            </div>
                                                            <p class="card-text rem"><strong>Created at:</strong>
                                                                <?php echo $date_added; ?>
                                                            </p>
                                                            <p class="card-text rem"><strong>Learning Objectives:</strong>
                                                                <?php echo $learning_objective; ?>
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

               
      <?php      } else {
    // The teacher does not have access to this class
    echo '<script>window.location.href = "../deny.php?reason=access_denied";</script>';
    exit; // Make sure to exit the script after the JavaScript redirect
}
?>
                                        

                                    </div>
                                    <!-- /.container-fluid -->

                                </div>
                                <!-- End of Main Content -->
 <!-- Add exam Pop Up Modal with unique ID -->
 <div class="modal fade" id="add_examModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Exam</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="" action="exam-function.php" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="teacher_id" value="<?php echo $teacher_id; ?>">
                            <input type="hidden" name="teacher_class_id" value="<?php echo $get_id; ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exam_title">Exam Title</label>
                                    <input type="text" class="form-control" id="exam_title" name="exam_title" required
                                        placeholder="Enter exam Title">
                                </div>

                                <div class="form-group">
                                    <label for="exam_description">Exam Description</label>
                                    <textarea type="text" class="form-control" id="description" name="exam_description"
                                        required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="learning_objective">Learning Objective</label>
                                    <textarea class="form-control" id="editor1" name="learning_objective" required
                                        placeholder="Enter Task Objective(s)"> </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="score_limit">Maximum Score:</label>
                                    <input type="number" id="score_limit" name="score_limit"
                                        placeholder="Enter Max Score" required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" name="add_exam" class="btn btn-success">Create</button>
                            </div>
                        </form>
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