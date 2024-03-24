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
// Start the session at the beginning of your PHP script if not already started.

// Assuming the teacher's ID is stored in the session variable 'teacher_id'.
$teacher_id = $_SESSION['teacher_id'];

// Ensure you have a valid database connection ($conn) before using it.

$class_query = mysqli_query($conn, "
    SELECT *
    FROM teacher_class
    LEFT JOIN class ON class.class_id = teacher_class.class_id
    LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
    LEFT JOIN teacher ON teacher.teacher_id = teacher_class.teacher_id
    WHERE teacher_class_id = '$get_id' AND teacher.teacher_id = '$teacher_id'
") or die(mysqli_error());

$class_row = mysqli_fetch_array($class_query);

// Check if the teacher has access to this class
if (mysqli_num_rows($class_query) > 0) {
    // Teacher has access to the class subject overview
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
                        <span style="font-weight: lighter;"><?php echo $class_row['class_name']; ?> <?php echo $class_row['subject_title']; ?></span> > Subject Overview
                    </h3>

                    </div>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
   
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        
                    </div>
</head>
<body>
                <!-- Content Row -->
                <div class="container mt-4">
    <div class="row">
        <!-- Subject Details (Left Column) -->
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="card-title"><?php echo $class_row['subject_title']; ?></h2>
                    <p class="card-text"><?php echo $class_row['subject_code']; ?></p>
                    <p class="card-text"><?php echo $class_row['description']; ?></p>
                </div>
            </div>
        </div>

        <!-- Instructor Details (Right Column) -->
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body">
                    <h3>Teacher:</h3>
                    <h4 class="card-title"><?php echo $class_row['firstname']; ?></h4>
                    <img class="rounded-circle" src="<?php echo $class_row['location']; ?>" style="width: 150px; height: 150px;">

                    <p class="card-text">Specialization: <?php echo $class_row['specialization']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    // The teacher does not have access to this class
    echo '<script>window.location.href = "../deny.php?reason=access_denied";</script>';
    exit; // Make sure to exit the script after the JavaScript redirect
}
?>
</div>
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
    text-decoration: none; /* Remove underline on hover */
    color: inherit; /* Inherit the text color from the parent element */
  }
  a {
    text-decoration: none; /* Remove underline */
    color: gray; /* Set the text color to black */
  }
</style>