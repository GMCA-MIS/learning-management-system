<?php
include('student_session.php');
$get_id = $_GET['id'];
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
include('dbcon.php');
include('initialize.php');
?>

<!-- breadcrumb -->
<?php
$class_query = mysqli_query($conn, "select * from teacher_class
    LEFT JOIN class ON class.class_id = teacher_class.class_id
    LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
    where teacher_class_id = '$get_id'") or die(mysqli_error());
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
                        <span style="font-weight: lighter;"><?php echo $class_row['class_name']; ?> <?php echo $class_row['subject_title']; ?></span> > Class Schedule
                    </h3>
            </div>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div>
                <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_assignmentModal"><i class="fa fa-plus" aria-hidden="true"></i> Add Learning Material</button>
            </div>
            <!-- Add Pop Up Modal -->
            <div class="modal fade" id="add_assignmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Learning Material</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="" action="class_materials-function.php<?php echo '?id=' . $get_id; ?>" method="post" enctype="multipart/form-data" name="upload">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">Learning Material Subject</label>
                                    <input type="text" class="form-control" id="name" name="name" required placeholder="Enter Learning Material Subject">
                                </div>
                                <div class="form-group">
                                    <label for="desc">Description</label>
                                    <textarea class="form-control" id="description" name="desc" rows="4" max-length="5000" required placeholder="Enter Description"></textarea>
                                </div>
                                <div class="form-group">
                                    <input name="uploaded_files[]" class="input-file uniform_on" id="fileInput" type="file" multiple>
                                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                                    <input type="hidden" name="id" value="<?php echo $session_id ?>" />
                                    <input type="hidden" name="id_class" value="<?php echo $get_id; ?>" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" name="upload_material" class="btn btn-success">Add</button>
                            </div>
                        </form>
                    </div> <!-- modal content -->
                </div> <!-- modal dialog -->
            </div> <!-- modal fade -->
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="container mt-4">
                <!-- Custom Container with Title -->
                <div class="custom-container">
                    <h4>Learning Materials List</h4>
                    <?php
                    // Assuming you have already started the session
                    // Get the teacher ID from the session
                    $student_id = $_SESSION['student_id'];

                    // Query to retrieve assignments
                    $query = "SELECT * FROM files WHERE class_id = '$get_id' AND teacher_id = '$teacher_id' ORDER BY fdatein DESC";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) === 0) {
                        echo '<center> <div class="no-assignments-message">There are no files yet.</div></center>';
                    } else {
                        while ($row = mysqli_fetch_array($result)) {
                            $id = $row['file_id'];
                            $floc = $row['floc'];
                            $fdatein = $row['fdatein'];
                            $fdesc = $row['fdesc'];
                            $fname = $row['fname'];
                            ?>
                            <!-- Assignment Card -->
                            <a href="view_class_materials.php?id=<?php echo $get_id ?>&post_id=<?php echo $id ?>">
                                <div class="card mt-3 position-relative">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row['fname']; ?></h5>
                                        <h6 class="card-title"><?php echo $row['fdesc']; ?></h6>
                                        <div class="d-flex justify-content-end">
                                            <!-- Edit Icon -->
                                            <a href="class_assignment-delete.php" class="btn btn-success btn-sm position-absolute top-0 end-0 mx-5">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Delete Icon -->
                                            <a href="class_assignment-delete.php" class="btn btn-danger btn-sm position-absolute top-0 end-100">
                                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <p class="card-text"><strong>Files:</strong></p>
                                        <ul>
                                            <?php
                                            $fileLocations = json_decode($floc, true);
                                            if ($fileLocations) {
                                                foreach ($fileLocations as $fileLocation) {
                                                    $fileName = basename($fileLocation);
                                                    echo '<li>' . $fileName . '</li>';
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Content Row -->
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