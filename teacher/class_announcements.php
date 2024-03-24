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
                            <?php echo $class_row['subject_title']; ?>
                        </span> > Announcements
                    </h3>
                </div>
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Add Pop Up Modal -->
                <div class="modal fade" id="add_announcementModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Post Announcement</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form class="" action="class_announcements-function.php?id=<?php echo $get_id; ?>" method="POST"
                                enctype="multipart/form-data">
                                <input type="hidden" name="teacher_class_id" value="<?php echo $get_id; ?>">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="desc">Announcement</label>
                                        <textarea class="form-control" id="description" name="content" rows="4"
                                            maxlength="5000" required placeholder="Enter Announcement"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="attachment">Add Photo</label>
                                        <input type="file" class="form-control-file" id="attachment" name="attachment[]"
                                            accept="image/*" multiple>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="submit" name="add_announcement" class="btn btn-success">Post</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-success add_btn" data-toggle="modal"
                    data-target="#add_announcementModal"><i class="fa fa-plus" aria-hidden="true"></i> Post
                    Announcement</button>

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

            </div>

            <!-- Content Row -->
            <div class="row">
                <div class="container mt-4">
                    <!-- Custom Container with Title -->
                    <div class="custom-container">
                        <h5>Announcement List</h5>
                        <hr>
                        <?php
                        // Assuming you have already started the session
                        // Get the teacher ID from the session
                        $teacher_id = $_SESSION['teacher_id'];

                        // Query to retrieve announcements
                        $query = "SELECT * FROM teacher_class_announcements WHERE teacher_class_id = '$get_id' AND teacher_id = '$teacher_id' ORDER BY date DESC";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) === 0) {
                            echo '<center> <div class="alert alert-warning">You have not posted an announcement yet.</div></center>';
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

                                        <div class="d-flex justify-content-end">
                                            <!-- Edit Icon with unique data-target attribute -->
                                            <button data-toggle="modal" data-target="<?php echo $modalTarget; ?>"
                                                class="btn btn-success btn-sm position-absolute top-0 end-0 mx-5"
                                                id="<?php echo $editButtonID; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <!-- Delete Icon -->
                                            <button data-toggle="modal" data-target="#<?php echo $modalID; ?>-delete"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-100">
                                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <p class="card-text rem"><strong>Posted:</strong>
                                            <?php echo date('F j, Y \a\t g:i A', strtotime($date)); ?>
                                        </p>
                                    </div>
                                </div>


                                <!-- Edit Pop Up Modal with unique ID -->
                                <div class="modal fade" id="<?php echo $modalID; ?>" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Announcement</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form class=""
                                                action="class_announcements-function.php?teacher_class_id=<?php echo $get_id; ?>"
                                                method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="teacher_class_id" value="<?php echo $get_id; ?>">
                                                <input type="hidden" name="teacher_class_announcements_id"
                                                    value="<?php echo $teacher_class_announcements_id; ?>">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="desc">Announcement</label>
                                                        <textarea class="form-control" id="description1" name="content" rows="4"
                                                            max-length="5000" required
                                                            placeholder="Enter Announcement"><?php echo $content; ?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for "attachment">Upload Photo</label>
                                                        <input type="file" class="form-control-file" id="attachment"
                                                            name="attachment[]" accept="image/*" multiple>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="edit_announcement" class="btn btn-success">Save
                                                        Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Delete Pop Up Modal with unique ID -->
                                <div class="modal fade" id="<?php echo $modalID; ?>-delete" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Remove Announcement</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form class=""
                                                action="class_announcements-function.php?teacher_class_id=<?php echo $get_id; ?>"
                                                method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="teacher_class_announcements_id"
                                                    value="<?php echo $teacher_class_announcements_id; ?>">
                                                <input type="hidden" name="teacher_class_id" value="<?php echo $get_id; ?>">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="submit" name="delete_announcement"
                                                    class="btn btn-success">Remove</button>
                                        </div>
                                        </form>
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
    </div>

    <script>
        // Initialize CKEditor
        CKEDITOR.replace('description1');

        // Function to check CKEditor content before form submission
        function checkEditorContent() {
            var editorContent = CKEDITOR.instances.description.getData();
            if (editorContent.trim() === '') {
                alert('Announcement content cannot be empty.');
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }

        // Attach the function to the form submission
        $(document).ready(function () {
            $('form').submit(function () {
                return checkEditorContent();
            });
        });
    </script>

<?php } else {
    // The teacher does not have access to this class
    echo '<script>window.location.href = "../deny.php?reason=access_denied";</script>';
    exit; // Make sure to exit the script after the JavaScript redirect
}
?>
<!-- Content Row -->

</div>
</div>
</div>


<?php
include('includes/scripts.php');
include('includes/footer.php');
?>