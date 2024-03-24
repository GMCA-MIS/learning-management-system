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

    .custom-image-size {
        width: 120px;
        /* Adjust the width to your desired size */
        height: 120px;
        /* Automatically adjust the height based on the width */

    }

    .hover-image img {
        transition: transform 0.3s ease;
    }

    .hover-image:hover img {
        transform: scale(1.1);
    }
</style>
<!-- breadcrumb -->
<?php $class_query = mysqli_query($conn, "select * from teacher_class
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
            <div class="d-sm-flex align-items-center justify-content-between mb-4"
                style="margin-top: 27px; margin-left: 10px;">
                <h3 class="h4 mb-0 text-gray-800">
                    <span style="font-weight: lighter;">
                        <?php echo $class_row['class_name']; ?>
                        <?php echo $class_row['subject_title']; ?>
                    </span> > Announcements
                </h3>
            </div>
        </nav>
        <!-- End of Topbar -->

        <!-- Content Row -->
        <div class="row">
            <div class="container mt-4">
                <!-- Custom Container with Title -->
                <div class="custom-container">
                    <h4>Announcement List</h4>
                    <?php
                    // Query to retrieve announcements
                    $query = "SELECT * FROM teacher_class_announcements WHERE teacher_class_id = '$get_id' ORDER BY date DESC";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) === 0) {
                        echo '<center> <div class="alert alert-warning"> There are no announcements yet.</div></center>';
                    } else {
                        while ($row = mysqli_fetch_array($result)) {
                            $content = $row['content'];
                            $date = $row['date'];
                            $teacher_class_announcements_id = $row['teacher_class_announcements_id'];
                            $attachment_path = $row['attachment_path'];
                            $attachment_paths = explode(',', $attachment_path); // Assuming file paths are stored as comma-separated values in the database
                    
                            // Generate unique modal ID and button attributes for each announcement
                            $modalID = "edit_announcementModal_$teacher_class_announcements_id";
                            $modalTarget = "#$modalID";
                            $editButtonID = "editButton_$teacher_class_announcements_id";
                            ?>
                            <!-- Announcement Card -->
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <?php echo $content; ?>
                                    </h6>
                                    <p class="posted-info" style="font-size: 0.8rem; color: #888;">Posted:
                                        <?php echo date('F j, Y @ g:i A', strtotime($date)); ?>
                                    </p>
                                    <?php
                                    if (!empty($attachment_paths)) {
                                        echo '<div class="image-container">';

                                        foreach ($attachment_paths as $attachment_path) {
                                            // Check if the file is an image based on its extension
                                            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
                                            $extension = pathinfo($attachment_path, PATHINFO_EXTENSION);

                                            if (in_array(strtolower($extension), $allowed_extensions)) {
                                                echo '<a href="' . $attachment_path . '" target="_blank" class="hover-image"><img src="' . $attachment_path . '" class="img-thumbnail custom-image-size" alt="Attachment"></a>';
                                            }
                                        }

                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>
</div>
<!-- Content Row -->
</div>
</div>
</div>