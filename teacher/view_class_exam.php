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
$exam_id = $_GET['exam_id']; // Get the exam_id from the URL
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
        text-decoration: none; /* Remove underline on hover */
        color: inherit; /* Inherit the text color from the parent element */
    }

    a {
        text-decoration: none; /* Remove underline */
        color: gray; /* Set the text color to black */
    }
</style>

<?php
// SQL query to fetch data from the exam table
$sql = "SELECT * FROM exam WHERE exam_id = $exam_id AND teacher_id = '$teacher_id'";

// Execute the query
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Fetch the exam_title and other data
        $examtitle = $row['exam_title'];
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
                <h1 class="h3 mb-0 text-gray-800"> <?php echo $examtitle ?></h1>
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
                            <a class="nav-link active" id="uploadTab" data-toggle="tab" href="#exam_questions" role="tab"
                                aria-controls="exam_questions" aria-selected="false">Questions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="createTab" data-toggle="tab" href="#exam_results" role="tab"
                                aria-controls="exam_results" aria-selected="true">Results</a>
                        </li>
                        <!--
                        <li class="nav-item">
                            <a class="nav-link" id="createTab" data-toggle="tab" href="#exam_feedback" role="tab"
                                aria-controls="exam_feedback" aria-selected="true">Feedback</a>
                        </li>-->
                    </ul>
                </div>

                <div class="tab-content" id="examTabsContent">
                    <div class="tab-pane fade show active" id="exam_questions" role="tabpanel" aria-labelledby="uploadTab">

                        <div class="table-responsive">

                            <div class="d-sm-flex align-items-center justify-content-between mb-2"
                                style="margin-top: 10px; margin-left: 10px;">
                                <h1 class="h5 mb-0 text-gray-800">Question List</h1>
                            </div>
                            <?php
                            // SQL query to fetch data from the exam table
                            $query = "SELECT exam_question.*, question_type.* 
                                      FROM exam_question
                                      JOIN question_type ON exam_question.question_type_id = question_type.question_type_id
                                      WHERE exam_question.exam_id = '$exam_id'
                                      ORDER BY exam_question.date_added DESC";

                            $query_run = mysqli_query($conn, $query);

                            if ($result) {
                                $row = mysqli_fetch_assoc($result);

                                if ($row) {

                                }
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }
                            ?>

                            <table style="color: black;" id="dataTableID"
                                class="table table-bordered table table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="display:none;">Course ID</th>
                                        <th>Question</th>
                                        <th>Type</th>
                                        <th>Points</th>
                                        <th>Correct Answer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc($query_run)) {
                                            ?>
                                            <tr>
                                                <td style="display:none;"><?php echo $row['exam_question_id']; ?></td>
                                                <td><?php echo $row['question_text']; ?></td>
                                                <td><?php echo $row['question_type']; ?></td>
                                                <td><?php echo $row['points']; ?></td>
                                                <td><?php echo $row['answer']; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo  '<div class = "alert alert-warning">"No Questions yet" </div>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="exam_results" role="tabpanel" aria-labelledby="createTab">
                        <div class="table-responsive">

                            <div class="d-sm-flex align-items-center justify-content-between mb-2"
                                style="margin-top: 10px; margin-left: 10px;">
                                <h1 class="h5 mb-0 text-gray-800">Exam Result</h1>
                            </div>
                            <?php
                            // SQL query to fetch data from the exam table
                            $query = "SELECT * 
                            FROM student_class_exam
                            JOIN student ON student_class_exam.student_id = student.student_id
                            JOIN class_exam ON student_class_exam.exam_id = class_exam.exam_id
                            JOIN exam ON class_exam.exam_id = exam.exam_id
                            WHERE teacher_class_id = $id AND exam.exam_id = $exam_id";
                  

                            $query_run = mysqli_query($conn, $query);

                            if ($result) {
                                $row = mysqli_fetch_assoc($result);

                                if ($row) {

                                }
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }
                            ?>

                            <table style="color: black;" id="dataTableID"
                                class="table table-bordered table table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="display:none;">Student ID</th>
                                        <th>Student Name</th>
                                        <th>Score</th>
                                        <th>View Answers</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc($query_run)) {
                                            ?>
                                            <tr>
                                                <td style="display:none;"><?php echo $row['student_id']; ?></td>
                                                <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                                                <td><?php echo $row['grade'] .' ' .  '/'  . ' '.  $row['max_score'];?></td>
                                                <td><a href = "view_exam_result.php?exam_id=<?php echo $exam_id ?>&post_id=<?php echo $get_id?>&id=<?php echo $row['student_id'];?>" class = "btn btn-secondary"> View Performance </a> </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo  '<div class = "alert alert-warning">"No Results yet" </div>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--
                    <div class="tab-pane fade " id="exam_feedback" role="tabpanel" aria-labelledby="createTab">
                        <div class="table-responsive">

                            <div class="d-sm-flex align-items-center justify-content-between mb-2"
                                style="margin-top: 10px; margin-left: 10px;">
                                <h1 class="h5 mb-0 text-gray-800">Exam Result</h1>
                            </div>
                            <?php
                            // SQL query to fetch data from the exam table
                            $query = "SELECT * 
                            FROM student_class_exam
                            JOIN student ON student_class_exam.student_id = student.student_id
                            JOIN class_exam ON student_class_exam.exam_id = class_exam.exam_id
                            JOIN exam ON class_exam.exam_id = exam.exam_id
                            WHERE teacher_class_id = $id AND exam.exam_id = $exam_id";
                  
                  

                            $query_run = mysqli_query($conn, $query);

                            if ($result) {
                                $row = mysqli_fetch_assoc($result);

                                if ($row) {

                                }
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }
                            ?>

                            <table style="color: black;" id="dataTableID"
                                class="table table-bordered table table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="display:none;">Student ID</th>
                                        <th>Student Name</th>
                                        <th>Score</th>
                                        <th>View Answers</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc($query_run)) {
                                            ?>
                                            <tr>
                                                <td style="display:none;"><?php echo $row['student_id']; ?></td>
                                                <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                                                <td><?php echo $row['grade'] .' ' .  '/'  . ' '.  $row['max_score'];?></td>
                                                <td><a href = "view_exam_result.php?exam_id=<?php echo $exam_id ?>&id=<?php echo $row['student_id'];?>" class = "btn btn-secondary"> View Performance </a> </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo  '<div class = "alert alert-warning">"No Results yet" </div>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    -->
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

