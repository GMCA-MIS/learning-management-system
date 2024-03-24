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

 <style>
    .card-title {
        color:black;
    }
    </style>
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
                    <span style="font-weight: lighter;"><?php echo $class_row['class_name']; ?></span> > Learning Materials
                </h3>
            </div>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="container mt-4">
                <!-- Custom Container with Title -->
                <div class="custom-container">
                    <div class="header mt-4" style ="backround: white;">
                        <h5 class="display-6">Learning Materials List</h5>
                    </div>
                    <hr>
                    <?php
                    // Assuming you have already started the session
                    // Get the teacher ID from the session
                    $student_id = $_SESSION['student_id'];

                    // Query to retrieve assignments
                    $query = "SELECT * FROM files WHERE teacher_class_id = '$get_id'  ORDER BY fdatein DESC";
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
                                        <p class="card-text rem"><strong>Files:</strong></p>
                                        <ul>
                                            <?php
                                            $fileLocations = json_decode($floc, true);
                                            if ($fileLocations) {
                                                foreach ($fileLocations as $fileLocation) {
                                                    $fileName = basename($fileLocation);
                                                    echo '<li class="rem">' . $fileName . '</li>';
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