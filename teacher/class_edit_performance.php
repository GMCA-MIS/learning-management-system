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
<?php
if (isset($_GET['post_id'])) {
    $assignment_id = $_GET['post_id'];
    $teacher_id = $_SESSION['teacher_id'];

    // Query to retrieve assignment details and check authorization
    $query = "SELECT * FROM task WHERE task_id = $assignment_id AND teacher_id = $teacher_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 0) {
        // Handle the case where the assignment is not found or the teacher is not authorized
        echo '<center> <div class="no-assignments-message">Assignment not found or unauthorized.</div></center>';
    } else {
        $row = mysqli_fetch_array($result);

        // Assign the assignment details to variables
        $assignmentName = $row['task_title'];
        $description = $row['fdesc'];
        $max_score = $row['max_score'];
        $deadline = $row['deadline'];
        $learning_objectives = $row['task_objective'];

        // Include your edit assignment form here, pre-filling the form fields with the existing details
        // You can use the existing form you have in the modal

        // For example:
        ?>

<?php $get_id = $_GET['id']; ?>
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
                    <span style="font-weight: lighter;"><?php echo $class_row['class_name']; ?></span> > Performance Task
                </h3>
            </div>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <div class="container mt-4">
        <div class="custom-container">
            <h3>Edit Performance Task: <?php echo $assignmentName; ?></h3>
            <hr>
            <form class="" action="class-performance-task.php" method="post" enctype="multipart/form-data" name="upload">
            <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>"> <!-- Add this line -->
                <!-- Include form fields for editing the assignment details -->
                <div class="form-group">
                    <label for="name">Assignment Title:</label>
                    <input type="text" class="form-control" id="edit_name" name="name" required placeholder="Enter Assignment Title" value="<?php echo htmlspecialchars($assignmentName, ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="form-group">
                    <input name="uploaded_files[]" class="input-file uniform_on" id="fileInput" type="file" multiple>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                    <input type="hidden" name="id" value="<?php echo $session_id ?>"/>
                    <input type="hidden" name="id_class" value="<?php echo $get_id; ?>">
                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                </div>

                <div class="form-group">
                    <label for="desc">Description</label>
                    <textarea class="form-control" id="description1" name="desc" rows="4" max-length="5000" required placeholder="Enter Description"><?php echo $description; ?></textarea>
                </div>
            
                <div class="form-group">
                    <label for="learning_objectives">Learning Objective(s)</label>
                    <textarea class="form-control" id="editor1" name="learning_objectives" rows="4" max-length = "5000" required placeholder="Enter Learning Objective(s)"><?php echo $learning_objectives; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="max_score">Maximum Score:</label>
                    <input type="number" id="max_score" name="max_score" placeholder="<?php echo $max_score; ?>" required> 
                </div>

                <div class="form-group">
                    <label for="deadline">Deadline:</label>
                    <input type="datetime-local" class="" id="deadline" name="deadline" value="<?php echo $deadline ;?>" required>
                </div>



                <div class="modal-footer justify-content-center">
                    <a href="view_class_assignment.php?id=<?php echo $get_id; ?>&post_id=<?php echo $post_id; ?>" class="btn btn-danger">Back</a>
                    <button type="submit" name="edit_assignment" class="btn btn-success">Update</button>
                </div>
            </div>
            </form>
        </div>
        </div>
        
        </div>

                <!-- Add a hidden input field to store the assignment_id for reference during update -->
  

            </form>
            
        </div>
        </div>
        <?php
    }
}
?>
<?php
include('includes/scripts.php');
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