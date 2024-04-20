<?php
include('teacher_session.php');
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('dbcon.php');
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

    .card-title {
        color: black;
    }
</style>

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
                <h1 class="h3 mb-0 text-gray-800">Exam</h1>
            </div>



            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">


                <?php
                // Initialize $row to an empty array to avoid undefined variable error
                $row = [];

                // Assuming you have established a database connection already (e.g., $conn)
                
                // Get the teacher_id from the session
                $teacher_id = $_SESSION['teacher_id'];

                // Use prepared statements to fetch teacher information
                $stmt = $conn->prepare("SELECT * FROM teacher WHERE teacher_id = ?");
                $stmt->bind_param("s", $teacher_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Fetch the teacher's data
                    $row = $result->fetch_assoc();
                } else {
                    // Handle the case where the teacher's record is not found
                    // You can set a default message or redirect to an error page here
                }

                $stmt->close();
                ?>



            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <?php
            $school_year_query = mysqli_query($conn, "select * from school_year order by school_year DESC") or die(mysqli_error());
            $school_year_query_row = mysqli_fetch_array($school_year_query);
            $school_year = $school_year_query_row['school_year'];
            ?>

            <?php
            // Include the session code from session.php
            // Initialize $count to 0
            $count = 0;

            // Assuming you have established a database connection already (e.g., $conn)
            
            // Get the teacher_id from the session
            $teacher_id = $_SESSION['teacher_id'];

            // SQL query to fetch teacher class information
            $query = mysqli_query($conn, "SELECT * FROM teacher_class
                    LEFT JOIN class ON class.class_id = teacher_class.class_id
                    LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                    WHERE teacher_id = '$teacher_id' AND school_year = '$school_year'") or die(mysqli_error());

            $count = mysqli_num_rows($query);
            ?>

            <!-- Page Heading -->


            <!-- Content Row -->
            <!-- Content Row -->
            <div class="row">
                <div class="container mt-4">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex justify-content-end">
                            <!-- Add justify-content-end class for right alignment -->
                            <button type="button" class="btn btn-success add_btn" data-toggle="modal"
                                data-target="#create_examModal">
                                <i class="fa fa-plus" aria-hidden="true"></i> Create Exam
                            </button>
                        </div>
                    </div>


                    <!-- Custom Container with Title -->
                    <div class="custom-container">
                        <h5>Exam List</h5>
                        <hr>
                        <?php
                        // Assuming you have already started the session
                        // Get the teacher ID from the session
                        $teacher_id = $_SESSION['teacher_id'];

                        // Query to retrieve examzes
                        $query = "SELECT * FROM exam WHERE teacher_id = '$teacher_id' ORDER BY date_added DESC";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) === 0) {
                            echo '<center> <div class="alert alert-warning">You have not posted a exam yet.</div></center>';
                        } else {
                            while ($row = mysqli_fetch_array($result)) {
                                $exam_id = $row['exam_id'];
                                $exam_title = $row['exam_title'];
                                $exam_description = $row['exam_description'];
                                $date_added = $row['date_added'];

                                // Generate unique modal ID and button attributes for each exam
                                $modalID = "edit_examModal_$exam_id";
                                $modalTarget = "#$modalID";
                                $editButtonID = "editButton_$exam_id";
                                ?>
                                <!-- exam Card -->
                                <div class="card mt-3 p-3">
                                    <h6 class="card-title">
                                        <?php echo $exam_title; ?>
                                    </h6>
                                    <h6 class="card-title">
                                        <?php echo $exam_description; ?>
                                    </h6>
                                    <p class="card-text rem"><strong>Created at:</strong>
                                        <?php echo date('F j, Y \a\t g:i A', strtotime($date_added)); ?>
                                    </p>
                                    <div class="d-flex justify-content-end">
                                        <a href="exam_content.php?exam_id=<?php echo $exam_id; ?>"
                                            class="btn btn-success btn-sm me-2 mr-2 assign-btn"
                                            data-examid="<?php echo $exam_id; ?>">
                                            <i class="fa fa-plus" aria-hidden="true"></i> View Questions
                                        </a>
                                        <button type="button" class="btn btn-success btn-sm me-2 mr-2 assign-exam-btn"
                                            data-toggle="modal" data-target="#assign_examModal"
                                            data-examid="<?php echo $exam_id; ?>">
                                            <i class="fa fa-plus" aria-hidden="true"></i> Assign Exam
                                        </button>
                                        <!-- Edit Icon with unique data-target attribute -->
                                        <button data-toggle="modal" data-target="<?php echo $modalTarget; ?>"
                                            class="btn btn-success btn-sm me-2 exam-edit-btn mr-2"
                                            id="<?php echo $editButtonID; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function () {
                                        // Capture the click event of the Assign Exam button
                                        $('.assign-exam-btn').on('click', function () {
                                            var examId = $(this).data('examid'); // Retrieve exam_id from data attribute
                                            $('#assign_examModal input[name="exam_id"]').val(examId); // Set the value of exam_id in the modal form
                                        });
                                    });
                                </script>


                                <!-- Edit Pop Up Modal with unique ID -->
                                <div class="modal fade" id="<?php echo $modalID; ?>" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Exam</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form class="" action="exam-function.php" method="POST">
                                                <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label for "exam_title">Exam Title</label>
                                                        <input type="text" class="form-control" id="exam_title"
                                                            name="exam_title" value="<?php echo $exam_title; ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exam_description">Description</label>
                                                        <textarea class="form-control ckeditor" name="exam_description" rows="4"
                                                            maxlength="5000" required
                                                            placeholder="Enter Description"><?php echo $exam_description; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" name="edit_exam" class="btn btn-success">Save
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
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Exam</h5>
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
                                                    class="btn btn-success">Delete</button>
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
            <!-- Add exam Pop Up Modal with unique ID -->
            <div class="modal fade" id="create_examModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create exam</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="" action="exam-function.php" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="teacher_id" value="<?php echo $teacher_id ?>">
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="exam_title">Exam Title</label>
                                    <input type="text" class="form-control" id="exam_title" name="exam_title" required
                                        placeholder="Enter Exam Title">
                                </div>

                                <div class="form-group">
                                    <label for="exam_description">Exam Description</label>
                                    <textarea type="text" class="form-control" id="description" name="exam_description"
                                        required> </textarea>
                                </div>
                                <div class="form-group">
                                            <label for="learning_objective">Learning Objective</label>
                                            <textarea class="form-control" id="editor1" name="learning_objective" required placeholder="Enter Task Objective(s)"> </textarea>
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" name="create_exam" class="btn btn-success">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Assign exam Pop Up Modal with unique ID -->
            <div class="modal fade" id="assign_examModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Assign Exam to Class</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="" action="exam-function.php" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="teacher_id" value="<?php echo $teacher_id ?>">
                            <input type="hidden" name="exam_id" value="<?php echo $exam_id ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for "theme">Select Class</label>
                                    <select name="class" id="class" class="form-control" required>
                                        <option value="" disabled selected>Select Class</option>
                                        <?php
                                        $query = "SELECT tc.teacher_class_id, c.class_name, s.subject_title
                                                                FROM teacher_class tc
                                                                INNER JOIN class c ON tc.class_id = c.class_id
                                                                INNER JOIN subject s ON tc.subject_id = s.subject_id
                                                                WHERE tc.teacher_id = $teacher_id
                                                                ORDER BY tc.teacher_class_id ASC";

                                        $result = mysqli_query($conn, $query);

                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $teacher_class_id = $row["teacher_class_id"];
                                                $class_name = $row["class_name"];
                                                $subject_title = $row["subject_title"];
                                                echo '<option value="' . $teacher_class_id . '">' . $class_name . ' - ' . $subject_title . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>

                                </div>

                                <div class="form-group">
                                    <label for="deadline">Deadline</label>
                                    <input type="datetime-local" id="deadline" name="deadline" required
                                        placeholder="Enter Deadline"  min="<?=date('Y-m-d\Th:i')?>">
                                </div>

                                <div class="form-group">
                                    <label for="limit">Time Limit (In Minutes)</label>
                                    <input type="number" id="limit" name="limit" required
                                        placeholder="Enter Time Limit (In Minutes)" min="1">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" name="assign_exam" class="btn btn-success">Assign</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Content Row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->


    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>