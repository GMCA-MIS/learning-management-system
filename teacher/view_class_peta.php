<?php
include('teacher_session.php');
$get_id = $_GET['id']; ?>
<?php
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
include('dbcon.php');
?>

<?php
$task_id = $_GET['task_id']; // Get the task_id from the URL
$id = $_GET['id'];
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

<?php
// SQL query to fetch data from the task table
$sql = "SELECT * FROM task WHERE task_id = $task_id";

// Execute the query
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Fetch the task_title and other data
        $tasktitle = $row['task_title'];
    } else {
        echo "<script>window.location.href = '../deny.php';</script>";
    }
} else {
    echo "<script>window.location.href = '../deny.php';</script>";
}
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
                <h1 class="h3 mb-0 text-gray-800">
                    <?php echo $tasktitle ?>
                </h1>
            </div>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <?php
            $school_year_query = mysqli_query($conn, "select * from school_year order by school_year DESC") or die(mysqli_error());
            $school_year_query_row = mysqli_fetch_array($school_year_query);
            $school_year = $school_year_query_row['school_year'];
            ?>
            <!-- Content Row -->
            <div class="card-body">
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="examTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="uploadTab" data-toggle="tab" href="#task_details" role="tab"
                                aria-controls="task_details" aria-selected="false">Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="createTab" data-toggle="tab" href="#task_scores" role="tab"
                                aria-controls="task_scores" aria-selected="true">Scores</a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="examTabsContent">
                    <div class="tab-pane fade show active" id="task_details" role="tabpanel"
                        aria-labelledby="uploadTab">

                        <?php
                        // Assuming $conn is your database connection
                        $query = "SELECT * FROM task WHERE teacher_class_id = $id AND task_id = $task_id";

                        $query_run = mysqli_query($conn, $query);

                        if ($query_run) {
                            // Assuming you want to fetch all rows related to the teacher_class_id
                            while ($row = mysqli_fetch_assoc($query_run)) {
                                $task_title = $row['task_title'];
                                $task_description = $row['fdesc'];
                                $task_objective = $row['task_objective'];
                                $date_added = $row['date_added'];
                                $max_score = $row['max_score'];
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?php echo $task_title; ?>
                                            </h6>
                                            <p class="card-text rem">
                                                <?php echo $task_description; ?>
                                            </p>
                                            <p class="card-text rem"><strong>Created at:</strong>
                                                <?php echo date('F j, Y \a\t g:i A', strtotime($date_added)); ?>
                                            </p>
                                            <p class="card-text rem"><strong>Max Score:</strong>
                                                <?php echo $max_score ?>
                                            </p> <br>
                                            <h6><strong> Learning Objectives: </strong></h6>
                                            <p class="card-text rem">
                                                <?php echo $task_objective; ?>
                                            </p>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                        ?>
                    </div>

                    <div class="tab-pane fade" id="task_scores" role="tabpanel" aria-labelledby="createTab">
                        <div class="table-responsive">
                            <div class="d-sm-flex align-items-center justify-content-between mb-2"
                                style="margin-top: 10px; margin-left: 10px;">
                                <h1 class="h5 mb-0 text-gray-800">Scores</h1>
                            </div>
                            <?php
                                // SQL query to fetch data from the exam table
                                $query = "SELECT s.firstname, s.lastname, IFNULL(tr.score, '-') as score, IFNULL(t.max_score, '-') as max_score
                                FROM student s
                                LEFT JOIN task_result tr ON s.student_id = tr.student_id AND tr.task_id = '$task_id'
                                LEFT JOIN task t ON tr.task_id = t.task_id
                                WHERE t.teacher_class_id = '$get_id'";
                      

                                $query_run = mysqli_query($conn, $query);

                                if ($query_run) {
                                    ?>
                                      <button type="button" class="btn btn-success add_btn ml-auto" data-toggle="modal" data-target="#update_scoreModal">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Update Scores
                                    </button>
                                    <table style="color: black;" id="dataTableID" class="table table-bordered table table-striped" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (mysqli_num_rows($query_run) > 0) {
                                                while ($row = mysqli_fetch_assoc($query_run)) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $row['firstname'] . ' ' . $row['lastname']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['score'] . '/ ' . $row['max_score']; ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="2" style="text-align: center;">
                                                        <div class="alert alert-warning">No Results yet</div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php
                                } else {
                                    echo "Error: " . mysqli_error($conn);
                                }
                                ?>
                        </div>
                    </div>
                    <!-- Content Row -->

                </div>
                <!-- /.container-fluid -->
<!-- Update Score Pop Up Task Modal -->
<div class="modal fade" id="update_scoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Performance Task Scores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="" action="class_grades-function.php" method="post">
                <div class="modal-body">
                    <input type="hidden" name="get_id" value="<?php echo $get_id ?>">
                    <input type="hidden" name="task" value="<?php echo $task_id ?>">
                    <?php
                    // Fetch student data from the database based on teacher_class_id
                    $query_students = "SELECT s.*, tcs.*, tr.score
                                        FROM student s
                                        JOIN teacher_class_student tcs ON s.student_id = tcs.student_id
                                        LEFT JOIN task_result tr ON s.student_id = tr.student_id AND tr.task_id = '$task_id'
                                        WHERE tcs.teacher_class_id = '$get_id'";
                    // Execute the query and fetch the results
                    $result_students = mysqli_query($conn, $query_students);

                    // Loop through the results and create input fields for each student
                    while ($row_students = mysqli_fetch_assoc($result_students)) {
                        $student_id = $row_students['student_id'];
                        $full_name = $row_students['firstname'] . ' ' . $row_students['lastname'];
                        $score = ($row_students['score'] != null) ? $row_students['score'] : ''; // Check if score exists

                        ?>
                        <div class="form-group student-field">
                            <label for="score_<?php echo $student_id; ?>"><?php echo $full_name; ?></label>
                            <input type="number" class="form-control" id="score_<?php echo $student_id; ?>" name="scores[<?php echo $student_id; ?>]" required placeholder="Enter Score for <?php echo $full_name; ?>" value="<?php echo $score; ?>" max="<?php echo $max_score; ?>">
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" name="update_score" class="btn btn-success">Update</button>
                </div>
            </form>
        </div> <!-- modal content -->
    </div> <!-- modal dialog -->
</div> <!-- modal fade -->


            </div>
        </div>
    </div>
</div>
</div>
<!-- End of Main Content -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>