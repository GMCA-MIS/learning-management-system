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
                    <span style="font-weight: lighter;"><?php echo $class_row['class_name']; ?></span> > Learning Materials
                </h3>
            </div>
        </nav>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <td>
               
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
                    <h4>Learning Material Details</h4>
                </div>
            </div>
            <hr>
            <?php
// Include database connection details
require("opener_db.php");
$conn = $connector->DbConnector();
$get_id = $_GET['id']; // Retrieves the value of 'id' from the URL
// Function to retrieve file details by file_id
function getFileDetails($file_id, $conn) {
    global $get_id;
    $query = "SELECT * FROM files WHERE file_id = $file_id and teacher_class_id = $get_id ";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

$get_id = $_GET['id']; // Retrieves the value of 'id' from the URL
$file_id = $_GET['post_id'];
$fileDetails = getFileDetails($file_id, $conn);

if ($fileDetails) {
    // Check if the current teacher has access to the file
    if ($fileDetails['teacher_class_id']) {
        $fileLocationWithNames = $fileDetails['floc'];
        $fileLocations = json_decode($fileLocationWithNames, true);

        if (is_array($fileLocations)) {
            $filename = $fileDetails['fname'];
            $fileDescription = $fileDetails['fdesc'];

            // Display fname and fdesc
            echo '<h5 class="card-title">' . $filename . '</h5>';
            echo '<p class="card-text">' . $fileDescription . '</p>';
            echo '<hr>';
            // Display the list of downloadable files
            foreach ($fileLocations as $file) {
                $filename = basename($file);
                ?>
                <!-- Downloadable File -->
                <div class="mt-3 position-relative">
                    <div class="card-body">
                    <a href="<?php echo $file; ?>" download="<?php echo $filename; ?>" class="pdf-link">Downloadable File: <?php echo $filename; ?></a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<center> <div class="no-assignments-message">File not found.</div></center>';
        }
    } else {
        echo '<center> <div class="no-assignments-message">You do not have access to this file.</div></center>';
    }
} else {
    echo '<center> <div class="no-assignments-message">File not found.</div></center>';
}
?>


        </div>
    </div>
</div>
                <!-- Right Column for Submission Details -->
                <div class="col-md-6">
    <div class="custom-container">
        <div class="header">
            <h6>Preview</h6>
            <hr>
            <iframe id="pdfViewer" style="width: 100%; height: 90vh;" frameborder="0"></iframe> <hr>
            <iframe src="http://docs.google.com/gview?url=https://gmca.online/uploads/662df611dfcf0_SAM101-Week-2-SYSTEM-ADMINISTRATION-OPERATING-SYSTEM.pptx&embedded=true" style="width:550px; height:450px;" frameborder="0"></iframe>
                        <button id="closePdfViewer" class="btn btn-success" style="display: none;">Close</button>
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
