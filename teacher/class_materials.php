<?php
include('teacher_session.php');
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
                        </span> > Learning Materials
                    </h3>
                </div>
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div>
                    <button type="button" class="btn btn-success add_btn" data-toggle="modal"
                        data-target="#add_materialModal"><i class="fa fa-plus" aria-hidden="true"></i> Add Learning
                        Material</button>
                </div>
                <!-- Add Pop Up Modal -->
                <div class="modal fade" id="add_materialModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Learning Material</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form class="" action="class_materials-function.php<?php echo '?id=' . $get_id; ?>"
                                method="post" enctype="multipart/form-data" name="upload">
                                <div class="modal-body">
                                    <input type="hidden" name="post_id" value="<?php echo $post_id ?>" />
                                    <input type="hidden" name="get_id" value="<?php echo $get_id ?>" />
                                    <div class="form-group">
                                        <label for="name">Learning Material Subject</label>
                                        <input type="text" class="form-control" id="name" name="name" required
                                            placeholder="Enter Learning Material Subject">
                                    </div>
                                    <div class="form-group">
                                        <label for="desc">Description</label>
                                        <textarea class="form-control" id="description" name="desc" rows="4"
                                            max-length="5000" required placeholder="Enter Description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input name="uploaded_files[]" class="input-file uniform_on" id="fileInput"
                                            type="file" multiple>
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
                        <div class="header  pb-2 pt-2 pl-4" style="background-color: white;">
                            <h5>Learning Materials List</h5>
                        </div>
                        <hr>
                        <?php
                        // Assuming you have already started the session
                        // Get the teacher ID from the session
                        $teacher_id = $_SESSION['teacher_id'];

                        // Query to retrieve Materials
                        $query = "SELECT * FROM files WHERE teacher_class_id = '$get_id' AND teacher_id = '$teacher_id' ORDER BY fdatein DESC";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) === 0) {
                            echo '<center> <div class="alert alert-warning">There are no files yet.</div></center>';
                        } else {
                            while ($row = mysqli_fetch_array($result)) {
                                $id = $row['file_id'];
                                $floc = $row['floc'];
                                $fdatein = $row['fdatein'];
                                $fdesc = $row['fdesc'];
                                $fname = $row['fname'];
                                ?>
                                <!-- Materials Card -->
                                <a href="view_class_materials.php?id=<?php echo $get_id ?>&post_id=<?php echo $id ?>">
                                    <div class="card mt-3 position-relative">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <?php echo $row['fname'];  
                                                
                                                if(empty($row['status'])){
                                                    echo " <b style='color:red'>[ For Approval ]</b>";
                                                }
                                                
                                                ?>
                                            </h6>
                                            <h6 class="card-title">
                                                <?php echo $row['fdesc']; ?>
                                            </h6>
                                            <div class="d-flex justify-content-end">
                                                <!-- Edit Icon -->
                                                <a href="#" class="btn btn-success btn-sm position-absolute top-0 end-0 mx-5"
                                                    data-toggle="modal" data-target="#editMaterialModal"
                                                    data-id="<?php echo $id; ?>" data-name="<?php echo $fname; ?>"
                                                    data-description="<?php echo $fdesc; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <!-- Delete Icon -->
                                                <a href="#" class="btn btn-danger btn-sm position-absolute top-0 end-100"
                                                data-toggle="modal" data-target="#deleteMaterialModal"
                                                data-fileid="<?php echo $id; ?>">
                                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                                                </a>


                                            </div>
                                            <p class="card-text rem"><strong>Files:</strong></p>
                                            <ul class="rem">
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
} else {
    // The teacher does not have access to this class
    echo '<script>window.location.href = "../deny.php?reason=access_denied";</script>';
    exit; // Make sure to exit the script after the JavaScript redirect
}
?>

<!-- Delete Material Confirmation Modal -->
<div class="modal fade" id="deleteMaterialModal" tabindex="-1" role="dialog" aria-labelledby="deleteMaterialModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMaterialModalLabel">Confirm Remove</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to remove this material?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                <!-- Form for confirmation -->
                <form id="deleteMaterialForm" action="class_materials-function.php" method="post">
                    <input type="hidden" name="file_id" id="fileIdInput" value="">
                    <input type="hidden" name="get_id" id="fileIdInput" value="<?php echo $get_id?>">
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Edit Material Modal -->
    <div class="modal fade" id="editMaterialModal" tabindex="-1" role="dialog" aria-labelledby="editMaterialModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMaterialModalLabel">Edit Material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editMaterialForm" method="post" action="class_materials-function.php"
                    enctype="multipart/form-data">
                    <input type="hidden" name="get_id" value="<?php echo $get_id ?>" />
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editName">Learning Material Subject</label>
                            <input type="text" class="form-control" id="editName" name="editName" required
                                placeholder="Enter Learning Material Subject">
                        </div>
                        <div class="form-group">
                            <label for="editDescription">Description</label>
                            <textarea class="form-control" id="description1" name="editDescription" rows="4"
                                max-length="5000" required placeholder="Enter Description"></textarea>
                        </div>
                        <div class="form-group">
                            <input name="editUploadedFiles[]" class="input-file uniform_on" id="editFileInput"
                                type="file" multiple>
                            <input type="hidden" name="editMaxFileSize" value="1000000" />
                            <input type="hidden" name="editId" id="editId" value="">
                            <input type="hidden" name="editIdClass" id="editIdClass" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" name="editMaterial" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#editMaterialModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('name');
                var description = button.data('description');

                var modal = $(this);
                modal.find('#editId').val(id);
                modal.find('#editName').val(name);
                modal.find('#editDescription').val(description);
                // Add more fields if needed
            });

         // Triggered when the delete modal is about to be shown
         $('#deleteMaterialModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var file_id = button.data('fileid'); // Extract data-fileid attribute from the button

            // Update the modal with the fetched data
            var modal = $(this);
            modal.find('#fileIdInput').val(file_id);
        });
    });
    </script>

    
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