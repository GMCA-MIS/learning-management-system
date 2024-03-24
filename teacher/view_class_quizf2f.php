<?php
include('teacher_session.php');
?>
<?php
$id = $_GET['quiz_id']; // Get the quiz_id from the URL
$get_id = $_GET['id'];
?>
<?php
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
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
</style>

<?php
// SQL query to fetch data from the quiz table
$sql = "SELECT * FROM quiz WHERE quiz_id = $id AND teacher_id = '$teacher_id'";

// Execute the query
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Fetch the quiz_title and other data
        $quiztitle = $row['quiz_title'];
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
                <h1 class="h3 mb-0 text-gray-800">Quiz Info:
                    <?php echo $quiztitle ?>
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
                    <ul class="nav nav-tabs" id="quizTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="uploadTab" data-toggle="tab" href="#quiz_questions"
                                role="tab" aria-controls="quiz_questions" aria-selected="true">Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="createTab" data-toggle="tab" href="#quiz_results" role="tab"
                                aria-controls="quiz_results" aria-selected="true">Scores</a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="quizTabsContent">
                    <div class="tab-pane fade show active" id="quiz_questions" role="tabpanel"
                        aria-labelledby="uploadTab">


                    </div>

                    <div class="tab-pane fade " id="quiz_results" role="tabpanel" aria-labelledby="createTab">
                        <div class="table-responsive">
                            <div class="d-sm-flex align-items-center justify-content-between mb-2"
                                style="margin-top: 10px; margin-left: 10px;">
                                <h1 class="h5 mb-0 text-gray-800">Quiz Scores</h1>
                            </div>
                            <button type="button" class="btn btn-success add_btn ml-auto mb-4" data-toggle="modal"
                                data-target="#update_quizscoreModal">
                                <i class="fa fa-plus" aria-hidden="true"></i> Update Scores
                            </button>
                            <?php
// Assuming $id and $quiz_id are already defined

$query_student_assignments = "SELECT s.student_id, s.firstname, s.lastname, scq.grade, cq.score_limit
    FROM student s
    LEFT JOIN student_class_quiz scq ON s.student_id = scq.student_id
    LEFT JOIN class_quiz cq ON scq.class_quiz_id = cq.class_quiz_id
    WHERE cq.teacher_class_id = '$get_id' AND cq.quiz_id = '$id'";

$query_run = mysqli_query($conn, $query_student_assignments);

if ($query_run) {
    ?>
    <table style="color: black;" id="" class="table table-bordered table table-striped"
        width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Student</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($query_run) > 0) {
                while ($row = mysqli_fetch_assoc($query_run)) {
                    // Calculate the score
                    $score = 'N/A'; // Default value if grade or score_limit is not available or zero
                    if ($row['grade'] !== null && $row['score_limit'] !== null && $row['score_limit'] != 0) {
                        $score = $row['grade'] . '/' . $row['score_limit'] . ' (' . round(($row['grade'] / $row['score_limit']) * 100) . '%)';
                    }
                    ?>
                    <tr>
                        <td>
                            <?php echo $row['firstname'] . ' ' . $row['lastname']; ?>
                        </td>
                        <td>
                            <?php echo $score; ?>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='2'>No data available</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
} else {
    echo "Query execution failed: " . mysqli_error($conn);
}
?>


                            </tbody>
                            </table>
                        </div>
                    </div>



                    <!-- Content Row -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        </div>

        <?php
        $query_max_score = "SELECT score_limit, class_quiz_id FROM class_quiz WHERE quiz_id = '$id'";

        $result_max_score = $conn->query($query_max_score);

        if ($result_max_score->num_rows > 0) {
            // Fetch the max score value
            $row = $result_max_score->fetch_assoc();
            $score_limit = $row['score_limit'];
            $class_quiz_id = $row['class_quiz_id'];
        } else {
        }
        ?>

        <!-- Update Score Pop Up Modal for Quiz -->
        <div class="modal fade" id="update_quizscoreModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Quiz Scores</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form class="" action="quiz-function.php" method="post">
    <div class="modal-body">
        <input type="hidden" name="get_id" value="<?php echo $get_id ?>">
        <input type="hidden" name="quiz_id" value="<?php echo $id ?>">
        <input type="hidden" name="class_quiz_id" value="<?php echo $class_quiz_id ?>">
        <input type="hidden" name="max_score" value="<?php echo $score_limit ?>">
        <div class="form-group">
        </div>
        <?php
        // Fetch student data from the database based on teacher_class_id
        $query_students = "SELECT s.*, tcs.*, scq.grade
                            FROM student s
                            JOIN teacher_class_student tcs ON s.student_id = tcs.student_id
                            LEFT JOIN student_class_quiz scq ON s.student_id = scq.student_id AND scq.class_quiz_id = '$class_quiz_id'
                            WHERE tcs.teacher_class_id = '$get_id'";
        
        // Execute the query and fetch the results
        $result_students = mysqli_query($conn, $query_students);

        // Loop through the results and create input fields for each student
        while ($row_students = mysqli_fetch_assoc($result_students)) {
            $student_id = $row_students['student_id'];
            $full_name = $row_students['firstname'] . ' ' . $row_students['lastname'];
            $grade = $row_students['grade']; // Get grade from student_class_quiz

            ?>
            <div class="form-group student-field-quiz">
                <label for="grade_<?php echo $student_id; ?>">
                    <?php echo $full_name; ?>
                </label>
                <input type="number" class="form-control" id="grades_<?php echo $student_id; ?>"
                    name="grades[<?php echo $student_id; ?>]" max="<?php echo $score_limit; ?>" required
                    placeholder="Enter Score for <?php echo $full_name; ?>" value="<?php echo $grade; ?>">
            </div>
            <?php
        }
        ?>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" name="update_scoreQuiz" class="btn btn-success">Update</button>
    </div>
</form>

                </div> <!-- modal content -->
            </div> <!-- modal dialog -->
        </div> <!-- modal fade -->


        <?php
        include('includes/scripts.php');
        include('includes/footer.php');
        ?>