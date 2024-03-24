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
$class_query = mysqli_query($conn, "SELECT * FROM teacher_class
LEFT JOIN class ON class.class_id = teacher_class.class_id
LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
WHERE teacher_class_id = '$get_id' AND teacher_id = '$teacher_id'") or die(mysqli_error());

// Check if any rows are returned
if (mysqli_num_rows($class_query) == 0) {
    // Redirect to deny.php
    echo '<script>window.location.href = "../deny.php";</script>';
    exit(); // Make sure to exit after the header redirection
}

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
                            </span> > Grades
                        </h3>
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
            <?php } ?>
            <!-- Content Row -->
            <div class="card-body">
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="quizTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="uploadTab" data-toggle="tab" href="#assignments" role="tab"
                                aria-controls="assignments" aria-selected="false">Assignments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="createTab" data-toggle="tab" href="#quizzes" role="tab"
                                aria-controls="quizzes" aria-selected="true">Quizzes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="createTab" data-toggle="tab" href="#exams" role="tab"
                                aria-controls="exams" aria-selected="true">Exams</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="createTab" data-toggle="tab" href="#peta" role="tab"
                                aria-controls="peta" aria-selected="true">Performance Tasks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="createTab" data-toggle="tab" href="#finalgrades" role="tab"
                                aria-controls="finalgrades" aria-selected="true">Final Grades</a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="TabsContent">

                    <!--------------------------------- For Assignments tab pane --------------------------------->
                    <div class="tab-pane show active fade " id="assignments" role="tabpanel"
                        aria-labelledby="createTab">
                        <div class="table-responsive">
                            <div class="d-sm-flex align-items-center justify-content-between mb-2"
                                style="margin-top: 10px; margin-left: 10px;">
                                <h1 class="h5 mb-0 text-gray-800">Assignment List</h1>
                                <div>
                                    <!-- <button type="button" class="btn btn-success add_btn ml-auto" data-toggle="modal" data-target="#update_assignmentscoreModal">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Update Scores
                                    </button>
                                    <button type="button" class="btn btn-success add_btn ml-auto" data-toggle="modal" data-target="#archive_assignmentscoreModal">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Archive
                                    </button>
                                    <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_assignmentModal">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Add Assignment
                                    </button> -->
                                </div>
                            </div>
                            
                            <?php
                            $query_assignment_titles = "SELECT a.*, sa.student_id, sa.grade
                         FROM assignment a  
                         LEFT JOIN student_assignment sa ON a.assignment_id = sa.assignment_id   
                         WHERE a.class_id = $get_id AND a.status = 'Available'";

                            $result_assignment_titles = mysqli_query($conn, $query_assignment_titles);

                            // Check if the query was successful
                            if (!$result_assignment_titles) {
                                die("Error: " . mysqli_error($conn));
                            }

                            // Fetch all assignment titles into an array
                            $assignment_titles = [];
                            while ($row_assignment_titles = mysqli_fetch_assoc($result_assignment_titles)) {
                                $assignment_titles[$row_assignment_titles['assignment_id']] = $row_assignment_titles['fname'];
                                $assignment_titles_max_scores[$row_assignment_titles['assignment_id']] = $row_assignment_titles['max_score'];
                            }
                            // Close the result set
                            mysqli_free_result($result_assignment_titles);

                            $query_student_assignments = "SELECT s.student_id, s.firstname, s.lastname, sa.grade, sa.assignment_id
                            FROM student s
                            LEFT JOIN student_assignment sa ON s.student_id = sa.student_id
                            LEFT JOIN assignment a ON sa.assignment_id = a.assignment_id
                            WHERE a.class_id = '$get_id'";

                            $result_student_assignments = mysqli_query($conn, $query_student_assignments);

                            // Check if the query was successful
                            if (!$result_student_assignments) {
                                die("Error: " . mysqli_error($conn));
                            }


                            // Fetch all student assignment information into an array
                            $student_assignments = [];
                            while ($row_student_assignments = mysqli_fetch_assoc($result_student_assignments)) {
                                $student_id = $row_student_assignments['student_id'];

                                // Initialize the student assignment array if it doesn't exist
                                if (!isset($student_assignments[$student_id])) {
                                    $student_assignments[$student_id] = [
                                        'grades' => [],
                                        'firstname' => $row_student_assignments['firstname'],
                                        'lastname' => $row_student_assignments['lastname'],
                                    ];
                                }

                                // Store the grade for each assignment
                                $assignment_id = $row_student_assignments['assignment_id'];
                                $student_assignments[$student_id]['grades'][$assignment_id] = $row_student_assignments['grade'];
                            }
                            // Close the result set
                            mysqli_free_result($result_student_assignments);


                            ?>
                            <table style="color: black;" id="dataTableID"
                                class="table table-bordered table table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="display:none;">Assignment ID</th>
                                        <th>Student Name</th>
                                        <?php
                                        // Output assignment titles as th
                                        foreach ($assignment_titles as $assignment_id => $assignment_title) {
                                            echo "<a><th>$assignment_title</th></a>";
                                        }
                                        ?>
                                        <th>Total %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($student_assignments as $student_id => $student) {
                                        echo "<tr>";
                                        echo "<td style='display:none;'>{$student_id}</td>";
                                        echo "<td>{$student['firstname']} {$student['lastname']}</td>";

                                        $totalPercentage = 0;  // Variable to store the total percentage for the student
                                    
                                        foreach ($assignment_titles as $assignment_id => $assignment_title) {
                                            echo "<td>";

                                            if (isset($student_assignments[$student_id]['grades'][$assignment_id])) {
                                                $grade = $student_assignments[$student_id]['grades'][$assignment_id];

                                                // Check if grade is not NULL
                                                if (!is_null($grade)) {
                                                    // Retrieve max_score for the assignment from the assignment_titles_max_scores array
                                                    $max_score = isset($assignment_titles_max_scores[$assignment_id]) ? $assignment_titles_max_scores[$assignment_id] : null;

                                                    if (!is_null($max_score) && $max_score > 0) {
                                                        $percentage = ($grade / $max_score) * 100;
                                                        // Use number_format to limit the decimal places to 2 for decimals only
                                                        echo number_format($grade, 0, '.', '') . "/" . number_format($max_score, 0, '.', '') . " (" . number_format($percentage, 2, '.', '') . "%)";
                                                        $totalPercentage += $percentage;  // Add to the total percentage
                                                    } else {
                                                        // Use number_format to limit the decimal places to 2 for decimals only
                                                        echo number_format($grade, 0, '.', '') . "/-";
                                                    }
                                                } else {
                                                    echo "-";
                                                }
                                            } else {
                                                echo "-";
                                            }

                                            echo "</td>";
                                        }
                                        echo "<td>";
                                        $averagePercentage = count($assignment_titles) > 0 ? $totalPercentage / count($assignment_titles) : 0;
                                        // Use number_format to limit the decimal places to 2 for decimals only
                                        $averagePercentageFormatted = number_format($averagePercentage, 2, '.', '');

                                        // Check if a row already exists for the given teacher_class_id and student_id
                                        $check_existing_query = "SELECT * FROM student_grade WHERE teacher_class_id = $get_id AND student_id = $student_id";
                                        $existing_result = mysqli_query($conn, $check_existing_query);

                                        if (mysqli_num_rows($existing_result) > 0) {
                                            // If a row exists, update the existing row
                                            $update_query = "UPDATE student_grade SET assignment_grade = $averagePercentageFormatted
                                                                WHERE teacher_class_id = $get_id AND student_id = $student_id";
                                            mysqli_query($conn, $update_query) or die("Error updating record: " . mysqli_error($conn));
                                        } else {
                                            // If no row exists, insert a new row
                                            $insert_query = "INSERT INTO student_grade (teacher_class_id, student_id, assignment_grade) 
                                                                VALUES ($get_id, $student_id, $averagePercentageFormatted)";
                                            mysqli_query($conn, $insert_query) or die("Error inserting record: " . mysqli_error($conn));
                                        }
                                        echo "$averagePercentageFormatted%</td>";
                                        echo "</tr>";
                                    }

                                    ?>



                                </tbody>
                            </table>
                        </div>
                    </div>


                    <!--------------------------------- For QUIZ tab pane --------------------------------->
                    <div class="tab-pane fade " id="quizzes" role="tabpanel" aria-labelledby="createTab">
                        <div class="table-responsive">
                            <div class="d-sm-flex align-items-center justify-content-between mb-2"
                                style="margin-top: 10px; margin-left: 10px;">
                                <h1 class="h5 mb-0 text-gray-800">Quiz List</h1>
                                <div>
                                    <!-- <button type="button" class="btn btn-success add_btn ml-auto" data-toggle="modal" data-target="#update_quizscoreModal">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Update Scores
                                    </button>
                                    <button type="button" class="btn btn-success add_btn ml-auto" data-toggle="modal" data-target="#archive_quizModal">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Archive
                                    </button>
                                    <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_quizModal">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Add Quiz
                                    </button> -->
                                </div>
                            </div>
                            <?php
                        $query_quiz_titles = "SELECT q.*, cq.*, scq.grade, scq.max_score
                    FROM quiz q
                    JOIN class_quiz cq ON q.quiz_id = cq.quiz_id
                    LEFT JOIN student_class_quiz scq ON cq.class_quiz_id = scq.class_quiz_id
                    WHERE cq.teacher_class_id = '$get_id' 
                    AND q.status = 'Available'
                    AND cq.stats = '0'";



                            $result_quiz_titles = mysqli_query($conn, $query_quiz_titles);

                            // Check if the query was successful
                            if (!$result_quiz_titles) {
                                die("Error: " . mysqli_error($conn));
                            }

                            // Fetch all quiz titles into an array
                            $quiz_titles = [];
                            $quiz_titles_max_scores = [];  // New array to store max scores
                            while ($row_quiz_titles = mysqli_fetch_assoc($result_quiz_titles)) {
                                $quiz_titles[$row_quiz_titles['quiz_id']] = $row_quiz_titles['quiz_title'];
                                $quiz_titles_max_scores[$row_quiz_titles['quiz_id']] = $row_quiz_titles['max_score'];
                            }

                            // Close the result set
                            mysqli_free_result($result_quiz_titles);

                            $query_students = "SELECT s.*, tcs.*, scq.grade as student_grade, scq.quiz_id
                            FROM student s
                            JOIN teacher_class_student tcs ON s.student_id = tcs.student_id
                            LEFT JOIN student_class_quiz scq ON s.student_id = scq.student_id
                            WHERE tcs.teacher_class_id = '$get_id'";

                            $result_students = mysqli_query($conn, $query_students);

                            // Check if the query was successful
                            if (!$result_students) {
                                die("Error: " . mysqli_error($conn));
                            }

                            // Fetch all student information into an array
                            $students = [];
                            while ($row_students = mysqli_fetch_assoc($result_students)) {
                                $student_id = $row_students['student_id'];

                                // Initialize the student array if it doesn't exist
                                if (!isset($students[$student_id])) {
                                    $students[$student_id] = [
                                        'firstname' => $row_students['firstname'],
                                        'lastname' => $row_students['lastname'],
                                        'grades' => [],
                                    ];
                                }

                                // Store the grade for each quiz
                                if (!is_null($row_students['student_grade'])) {
                                    $quiz_id = $row_students['quiz_id'];
                                    $students[$student_id]['grades'][$quiz_id] = $row_students['student_grade'];
                                }
                            }

                            // Close the result set
                            mysqli_free_result($result_students);

                            ?>
                            <table style="color: black;" id="dataTableID"
                                class="table table-bordered table table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="display:none;">Quiz ID</th>
                                        <th>Student Name</th>
                                        <?php
                                        // Output quiz titles as th
                                        foreach ($quiz_titles as $quiz_id => $quiz_title) {
                                            echo "<th>$quiz_title</th>";
                                        }
                                        ?>
                                        <th>Total %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($students as $student_id => $student) {
                                        echo "<tr>";
                                        echo "<td style='display:none;'>{$student_id}</td>";
                                        echo "<td>{$student['firstname']} {$student['lastname']}</td>";

                                        $totalPercentage = 0;  // Variable to store the total percentage for the student
                                    
                                        foreach ($quiz_titles as $quiz_id => $quiz_title) {
                                            echo "<td>";

                                            if (isset($student['grades'][$quiz_id]) && isset($quiz_titles_max_scores[$quiz_id])) {
                                                $grade = $student['grades'][$quiz_id];
                                                $max_score = $quiz_titles_max_scores[$quiz_id];

                                                // Check if grade and max_score are not NULL
                                                if (!is_null($grade) && !is_null($max_score)) {
                                                    $percentage = ($grade / $max_score) * 100;
                                                    echo "{$grade}/{$max_score} (" . number_format($percentage, 2) . "%)";
                                                    $totalPercentage += $percentage;  // Add to the total percentage
                                                } else {
                                                    echo "-";
                                                }
                                            } else {
                                                echo "-";
                                            }

                                            echo "</td>";
                                        }

                                        echo "<td>";
                                        $averagePercentage = count($quiz_titles) > 0 ? $totalPercentage / count($quiz_titles) : 0;
                                        // Use number_format to limit the decimal places to 2 for decimals only
                                        $averagePercentageFormatted = number_format($averagePercentage, 2, '.', '');

                                        // Check if a row already exists for the given teacher_class_id and student_id
                                        $check_existing_query = "SELECT * FROM student_grade WHERE teacher_class_id = $get_id AND student_id = $student_id";
                                        $existing_result = mysqli_query($conn, $check_existing_query);

                                        if (mysqli_num_rows($existing_result) > 0) {
                                            // If a row exists, update the existing row
                                            $update_query = "UPDATE student_grade SET quiz_grade = $averagePercentageFormatted
                                                                WHERE teacher_class_id = $get_id AND student_id = $student_id";
                                            mysqli_query($conn, $update_query) or die("Error updating record: " . mysqli_error($conn));
                                        } else {
                                            // If no row exists, insert a new row
                                            $insert_query = "INSERT INTO student_grade (teacher_class_id, student_id, quiz_grade) 
                                                                VALUES ($get_id, $student_id, $averagePercentageFormatted)";
                                            mysqli_query($conn, $insert_query) or die("Error inserting record: " . mysqli_error($conn));
                                        }
                                        echo "$averagePercentageFormatted%</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!--------------------------------- For EXAM tab pane --------------------------------->
                    <div class="tab-pane fade " id="exams" role="tabpanel" aria-labelledby="createTab">
                        <div class="table-responsive">
                            <div class="d-sm-flex align-items-center justify-content-between mb-2"
                                style="margin-top: 10px; margin-left: 10px;">
                                <h1 class="h5 mb-0 text-gray-800">Exam List</h1>
                                <div>
                                    <!-- <button type="button" class="btn btn-success add_btn ml-auto" data-toggle="modal" data-target="#update_examscoreModal">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Update Scores
                                    </button>
                                    <button type="button" class="btn btn-success add_btn ml-auto" data-toggle="modal" data-target="#archive_examModal">
                                         Archive
                                    </button>
                                    <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_examModal">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Add Exam
                                    </button> -->
                                </div> 
                            </div>
                            <?php
                            $query_exam_titles = "SELECT e.*, ce.*, sce.grade, sce.max_score
                            FROM exam e
                            JOIN class_exam ce ON e.exam_id = ce.exam_id
                            LEFT JOIN student_class_exam sce ON ce.class_exam_id = sce.class_exam_id
                            WHERE ce.teacher_class_id = '$get_id' 
                            AND e.status = 'Available'
                            AND ce.stats = '0'";
                            $result_exam_titles = mysqli_query($conn, $query_exam_titles);

                            // Check if the query was successful
                            if (!$result_exam_titles) {
                                die("Error: " . mysqli_error($conn));
                            }

                            // Fetch all exam titles into an array
                            $exam_titles = [];
                            $exam_titles_max_scores = [];  // New array to store max scores
                            while ($row_exam_titles = mysqli_fetch_assoc($result_exam_titles)) {
                                $exam_titles[$row_exam_titles['exam_id']] = $row_exam_titles['exam_title'];
                                $exam_titles_max_scores[$row_exam_titles['exam_id']] = $row_exam_titles['max_score'];
                            }

                            // Close the result set
                            mysqli_free_result($result_exam_titles);

                            $query_students = "SELECT s.*, tcs.*, scq.grade as student_grade, scq.exam_id
                            FROM student s
                            JOIN teacher_class_student tcs ON s.student_id = tcs.student_id
                            LEFT JOIN student_class_exam scq ON s.student_id = scq.student_id
                            WHERE tcs.teacher_class_id = '$get_id'";

                            $result_students = mysqli_query($conn, $query_students);

                            // Check if the query was successful
                            if (!$result_students) {
                                die("Error: " . mysqli_error($conn));
                            }

                            // Fetch all student information into an array
                            $students = [];
                            while ($row_students = mysqli_fetch_assoc($result_students)) {
                                $student_id = $row_students['student_id'];

                                // Initialize the student array if it doesn't exist
                                if (!isset($students[$student_id])) {
                                    $students[$student_id] = [
                                        'firstname' => $row_students['firstname'],
                                        'lastname' => $row_students['lastname'],
                                        'grades' => [],
                                    ];
                                }

                                // Store the grade for each exam
                                if (!is_null($row_students['student_grade'])) {
                                    $exam_id = $row_students['exam_id'];
                                    $students[$student_id]['grades'][$exam_id] = $row_students['student_grade'];
                                }
                            }

                            // Close the result set
                            mysqli_free_result($result_students);

                            ?>
                            <table style="color: black;" id="dataTableID"
                                class="table table-bordered table table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="display:none;">Exam ID</th>
                                        <th>Student Name</th>
                                        <?php
                                        // Output exam titles as th
                                        foreach ($exam_titles as $exam_id => $exam_title) {
                                            echo "<th>$exam_title</th>";
                                        }
                                        ?>
                                        <th>Total %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($students as $student_id => $student) {
                                        echo "<tr>";
                                        echo "<td style='display:none;'>{$student_id}</td>";
                                        echo "<td>{$student['firstname']} {$student['lastname']}</td>";

                                        $totalPercentage = 0;  // Variable to store the total percentage for the student
                                    
                                        foreach ($exam_titles as $exam_id => $exam_title) {
                                            echo "<td>";

                                            if (isset($student['grades'][$exam_id]) && isset($exam_titles_max_scores[$exam_id])) {
                                                $grade = $student['grades'][$exam_id];
                                                $max_score = $exam_titles_max_scores[$exam_id];

                                                // Check if grade and max_score are not NULL
                                                if (!is_null($grade) && !is_null($max_score)) {
                                                    $percentage = ($grade / $max_score) * 100;
                                                    echo "{$grade}/{$max_score} (" . round($percentage, 2) . "%)";
                                                    $totalPercentage += $percentage;  // Add to the total percentage
                                                } else {
                                                    echo "-";
                                                }
                                            } else {
                                                echo "-";
                                            }

                                            echo "</td>";
                                        }

                                        echo "<td>";
                                        $averagePercentage = count($exam_titles) > 0 ? $totalPercentage / count($exam_titles) : 0;
                                        // Use number_format to limit the decimal places to 2 for decimals only
                                        $averagePercentageFormatted = number_format($averagePercentage, 2, '.', '');

                                        // Check if a row already exists for the given teacher_class_id and student_id
                                        $check_existing_query = "SELECT * FROM student_grade WHERE teacher_class_id = $get_id AND student_id = $student_id";
                                        $existing_result = mysqli_query($conn, $check_existing_query);

                                        if (mysqli_num_rows($existing_result) > 0) {
                                            // If a row exists, update the existing row
                                            $update_query = "UPDATE student_grade SET exam_grade = $averagePercentageFormatted
                                                                WHERE teacher_class_id = $get_id AND student_id = $student_id";
                                            mysqli_query($conn, $update_query) or die("Error updating record: " . mysqli_error($conn));
                                        } else {
                                            // If no row exists, insert a new row
                                            $insert_query = "INSERT INTO student_grade (teacher_class_id, student_id, exam_grade) 
                                                                VALUES ($get_id, $student_id, $averagePercentageFormatted)";
                                            mysqli_query($conn, $insert_query) or die("Error inserting record: " . mysqli_error($conn));
                                        }
                                        echo "$averagePercentageFormatted%</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>


                    </div>

                    <!--------------------------------- For Final Grades tab pane --------------------------------->
                    <div class="tab-pane fade " id="finalgrades" role="tabpanel" aria-labelledby="createTab">
                        <div class="table-responsive">
                            <div class="d-sm-flex align-items-center justify-content-between mb-2"
                                style="margin-top: 10px; margin-left: 10px;">
                                <h1 class="h5 mb-0 text-gray-800">Final Grades List</h1>
                            </div>
                          
                            <table style="color: black;" id="dataTableID" class="table table-bordered table table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="display:none;">Student ID</th>
                                        <th>Student Name</th>
                                        <th>Total %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch the list of students for the given teacher_class_id
                                    $query_students = "SELECT ts.student_id, s.firstname, s.lastname
                                    FROM teacher_class_student ts
                                    LEFT JOIN student s ON ts.student_id = s.student_id
                                    WHERE ts.teacher_class_id = $get_id";

                                    $result_students = mysqli_query($conn, $query_students);

                                    // Check if the query was successful
                                    if (!$result_students) {
                                        die("Error: " . mysqli_error($conn));
                                    }

                                    while ($row_student = mysqli_fetch_assoc($result_students)) {
                                        $student_id = $row_student['student_id'];
                                        $student_name = $row_student['firstname'] . ' ' . $row_student['lastname'];

                                        echo "<tr>";
                                        echo "<td style='display:none;'>{$student_id}</td>";
                                        echo "<td>{$student_name}</td>";

                                        // Additional logic for calculating total percentage based on subject_type and track
                                        $subject_query = "SELECT s.subject_type, s.track
                                        FROM teacher_class tc
                                        JOIN subject s ON tc.subject_id = s.subject_id
                                        WHERE tc.teacher_class_id = $get_id";

                                        $subject_result = mysqli_query($conn, $subject_query);
                                        $subject_row = mysqli_fetch_assoc($subject_result);

                                        $subject_type = $subject_row['subject_type'];
                                        $track = $subject_row['track'];

                                        // Fetch grades from student_grade table
                                        $grades_query = "SELECT assignment_grade, task_grade, exam_grade, quiz_grade
                                        FROM student_grade
                                        WHERE teacher_class_id = $get_id AND student_id = $student_id";

                                        $grades_result = mysqli_query($conn, $grades_query);
                                        $grades_row = mysqli_fetch_assoc($grades_result);

                                        // Placeholder for assignment_grade, task_grade, exam_grade, and quiz_grade
                                        $assignment_grade = $grades_row['assignment_grade'];
                                        $task_grade = $grades_row['task_grade'];
                                        $exam_grade = $grades_row['exam_grade'];
                                        $quiz_grade = $grades_row['quiz_grade'];

                                        $total_percentage = 0;

                                        if ($subject_type == "Applied" && $track == "Academic") {
                                            // Add the assignment_grade and task_grade, divide by 2, multiply by 0.4
                                            $total_percentage += (($assignment_grade + $task_grade) / 2) * 0.6;

                                            // Add the quotient of exam_grade plus quiz_grade divided by 2, multiply by 0.6
                                            $total_percentage += (($exam_grade + $quiz_grade) / 2) * 0.4;
                                        } elseif ($subject_type == "Applied" && $track == "TVL") {
                                            // Add the assignment_grade and task_grade, divide by 2, multiply by 0.4
                                            $total_percentage += (($assignment_grade + $task_grade) / 2) * 0.7;

                                            // Add the quotient of exam_grade plus quiz_grade divided by 2, multiply by 0.6
                                            $total_percentage += (($exam_grade + $quiz_grade) / 2) * 0.3;
                                        } elseif ($subject_type == "Specialized" && $track == "Academic") {
                                            // Add the assignment_grade and task_grade, divide by 2, multiply by 0.4
                                            $total_percentage += (($assignment_grade + $task_grade) / 2) * 0.6;

                                            // Add the quotient of exam_grade plus quiz_grade divided by 2, multiply by 0.6
                                            $total_percentage += (($exam_grade + $quiz_grade) / 2) * 0.4;
                                        } elseif ($subject_type == "Specialized" && $track == "TVL") {
                                            // Add the assignment_grade and task_grade, divide by 2, multiply by 0.4
                                            $total_percentage += (($assignment_grade + $task_grade) / 2) * 0.7;

                                            // Add the quotient of exam_grade plus quiz_grade divided by 2, multiply by 0.6
                                            $total_percentage += (($exam_grade + $quiz_grade) / 2) * 0.3;
                                        } elseif ($subject_type == "Core" && $track == "Academic") {
                                            // Add the assignment_grade and task_grade, divide by 2, multiply by 0.4
                                            $total_percentage += (($assignment_grade + $task_grade) / 2) * 0.6;

                                            // Add the quotient of exam_grade plus quiz_grade divided by 2, multiply by 0.6
                                            $total_percentage += (($exam_grade + $quiz_grade) / 2) * 0.4;
                                        } elseif ($subject_type == "Core" && $track == "TVL") {
                                            // Add the assignment_grade and task_grade, divide by 2, multiply by 0.4
                                            $total_percentage += (($assignment_grade + $task_grade) / 2) * 0.6;

                                            // Add the quotient of exam_grade plus quiz_grade divided by 2, multiply by 0.6
                                            $total_percentage += (($exam_grade + $quiz_grade) / 2) * 0.4;
                                        }

                                        // Display the calculated total percentage
                                        echo "<td>" . number_format($total_percentage, 2, '.', '') . "%</td>";

                                        echo "</tr>";
                                    }

                                    // Close the result sets
                                    mysqli_free_result($result_students);
                                    mysqli_free_result($subject_result);
                                    mysqli_free_result($grades_result);
                                    ?>
                                </tbody>
                            </table>
                        </div>



                        <!-- Content Row -->

                    </div>
                    <!-- /.container-fluid -->
                         <!--------------------------------- For Performance Tasks tab pane --------------------------------->
                         <div class="tab-pane fade " id="peta" role="tabpanel" aria-labelledby="createTab">
                         <div class="table-responsive">
                            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                                <h1 class="h5 mb-0 text-gray-800">Performance Tasks</h1>
                                <div>
                                    <!-- <button type="button" class="btn btn-success add_btn ml-auto" data-toggle="modal" data-target="#update_scoreModal">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Update Scores
                                    </button>
                                    <button type="button" class="btn btn-success add_btn ml-auto" data-toggle="modal" data-target="#archive_petaModal">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Archive
                                    </button>
                                    <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_taskModal">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Add Task
                                    </button> -->
                           
                                </div>
                            </div>

                            <?php
                            $query_task_titles = "SELECT * FROM task WHERE teacher_class_id = $get_id AND status = 'Available'";

                            $result_task_titles = mysqli_query($conn, $query_task_titles);

                            // Check if the query was successful
                            if (!$result_task_titles) {
                                die("Error: " . mysqli_error($conn));
                            }

                            // Fetch all quiz titles into an array
                            $task_titles = [];
                            $task_titles_max_scores = [];  // New array to store max scores
                            while ($row_task_titles = mysqli_fetch_assoc($result_task_titles)) {
                                $task_titles[$row_task_titles['task_id']] = $row_task_titles['task_title'];
                                $task_titles_max_scores[$row_task_titles['task_id']] = $row_task_titles['max_score'];
                            }

                            // Close the result set
                            mysqli_free_result($result_task_titles);

                            $query_students = "SELECT s.*, tcs.*, tr.*, t.*
                            FROM student s
                            JOIN teacher_class_student tcs ON s.student_id = tcs.student_id
                            LEFT JOIN task_result tr ON s.student_id = tr.student_id
                            LEFT JOIN task t ON tr.task_id = t.task_id
                            WHERE tcs.teacher_class_id = '$get_id' AND t.teacher_class_id = '$get_id' AND t.status = 'Available'";


                            $result_students = mysqli_query($conn, $query_students);

                            // Check if the query was successful
                            if (!$result_students) {
                                die("Error: " . mysqli_error($conn));
                            }

                            // Fetch all student information into an array
                            $students = [];
                            while ($row_students = mysqli_fetch_assoc($result_students)) {
                                $student_id = $row_students['student_id'];

                                // Initialize the student array if it doesn't exist
                                if (!isset($students[$student_id])) {
                                    $students[$student_id] = [
                                        'firstname' => $row_students['firstname'],
                                        'lastname' => $row_students['lastname'],
                                        'score' => [],
                                    ];
                                }

                                // Store the score for each task
                                if (!is_null($row_students['score'])) {
                                    $task_id = $row_students['task_id'];
                                    $students[$student_id]['score'][$task_id] = $row_students['score'];
                                }
                            }

                            // Close the result set
                            mysqli_free_result($result_students);

                            ?>
                            <table style="color: black;" id="dataTableID"
                                class="table table-bordered table table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="display:none;">Task ID</th>
                                        <th>Student Name</th>
                                        <?php
                                        // Output quiz titles as th
                                        foreach ($task_titles as $task_id => $task_title) {
                                            echo "<th>$task_title</th>";
                                        }
                                        ?>
                                        <th>Total %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($students as $student_id => $student) {
                                        echo "<tr>";
                                        echo "<td style='display:none;'>{$student_id}</td>";
                                        echo "<td>{$student['firstname']} {$student['lastname']}</td>";

                                        $totalPercentage = 0;  // Variable to store the total percentage for the student
                                    
                                        foreach ($task_titles as $quiz_id => $task_title) {
                                            echo "<td>";

                                            if (isset($student['score'][$quiz_id]) && isset($task_titles_max_scores[$quiz_id])) {
                                                $score = $student['score'][$quiz_id];
                                                $max_score = $task_titles_max_scores[$quiz_id];

                                                // Check if score and max_score are not NULL
                                                if (!is_null($score) && !is_null($max_score)) {
                                                    $percentage = ($score / $max_score) * 100;
                                                    $formattedPercentage = is_float($percentage) ? number_format($percentage, 2) : number_format($percentage);

                                                    echo "{$score}/{$max_score} ({$formattedPercentage}%)";
                                                    $totalPercentage += $percentage;  // Add to the total percentage
                                    
                                                } else {
                                                    echo "-";
                                                }
                                            } else {
                                                echo "-";
                                            }

                                            echo "</td>";
                                        }

                                        // Calculate the average percentage and display it in the Total % column
                                        echo "<td>";
                                        $averagePercentage = count($task_titles) > 0 ? $totalPercentage / count($task_titles) : 0;
                                        // Use number_format to limit the decimal places to 2 for decimals only
                                        $averagePercentageFormatted = number_format($averagePercentage, 2, '.', '');

                                        // Check if a row already exists for the given teacher_class_id and student_id
                                        $check_existing_query = "SELECT * FROM student_grade WHERE teacher_class_id = $get_id AND student_id = $student_id";
                                        $existing_result = mysqli_query($conn, $check_existing_query);

                                        if (mysqli_num_rows($existing_result) > 0) {
                                            // If a row exists, update the existing row
                                            $update_query = "UPDATE student_grade SET task_grade = $averagePercentageFormatted
                                                                WHERE teacher_class_id = $get_id AND student_id = $student_id";
                                            mysqli_query($conn, $update_query) or die("Error updating record: " . mysqli_error($conn));
                                        } else {
                                            // If no row exists, insert a new row
                                            $insert_query = "INSERT INTO student_grade (teacher_class_id, student_id, task_grade) 
                                                                VALUES ($get_id, $student_id, $averagePercentageFormatted)";
                                            mysqli_query($conn, $insert_query) or die("Error inserting record: " . mysqli_error($conn));
                                        }
                                        echo "$averagePercentageFormatted%</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Add Pop Up Modal -->
                    <div class="modal fade" id="add_taskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Performace Task</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form class="" action="class_grades-function.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name = "get_id" value = "<?php echo $get_id ?>">
                                        <div class="form-group">
                                            <label for="title">Task Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required placeholder="Enter Task Title">
                                        </div>
                                        <!-- <div class="form-group">
                                            <label for="task_objective">Learning Objective</label>
                                            <textarea class="form-control" id="description1" name="task_objective" required placeholder="Enter Task Objective(s)"> </textarea>
                                        </div> -->
                                        <div class="form-group">
                                            <label for="max_score">Max Score</label>
                                            <input type="number" class="form-control" id="max_score" name="max_score" required placeholder="Enter Max Score">
                                        </div>
                                        <hr>
                                        <br>
                                    
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" name="add_task" class="btn btn-success">Create</button>
                                    </div>
                                </form>
                            </div> <!-- modal content -->
                        </div> <!-- modal dialog -->
                    </div> <!-- modal fade -->
                    <style>
    .student-field {
        display: none;
    }
    .student-field-assignment {
        display: none;
    }
    .student-field-quiz{
        display: none;
    }
    .student-field-exam{
        display: none;
    }
</style>
                     <!-- Update Score Pop Up Task Modal -->
                     <div class="modal fade" id="update_scoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Performace Task Scores</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form class="" action="class_grades-function.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name = "get_id" value = "<?php echo $get_id ?>">
                                        <input type="hidden" name = "task_id" value = "task_id">
                                            <div class="form-group">
                                                <label for="title">Task</label>
                                                <select name="task" id="task" class="form-control" required onchange="updateScores()">
                                                        <option  selected disabled > Select Task </option>
                                                        <?php
                                                        $query = mysqli_query($conn, "SELECT task_id, max_score, task_title FROM task WHERE teacher_class_id = $get_id AND status ='Available' ORDER BY task_id ASC");
                                                        if ($query && mysqli_num_rows($query) > 0) {
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                $task_id = $row["task_id"];
                                                                $task_title = $row["task_title"];
                                                                $max_score = $row["max_score"];
                                                                echo '<option value="' . $task_id . '" data-max-score="' . $max_score . '">
                                                                ' . $task_title . ' (Max Score: ' . $max_score . ')
                                                            </option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                            </div>
                                                <?php
                                                // Fetch student data from the database based on teacher_class_id
                                                $query_students = "SELECT s.*, tcs.*
                                                                        FROM student s
                                                                        JOIN teacher_class_student tcs ON s.student_id = tcs.student_id
                                                                        WHERE tcs.teacher_class_id = '$get_id'";
                                                // Execute the query and fetch the results
                                                $result_students = mysqli_query($conn, $query_students);

                                                // Loop through the results and create input fields for each student
                                                while ($row_students = mysqli_fetch_assoc($result_students)) {
                                                    $student_id = $row_students['student_id'];
                                                    $full_name = $row_students['firstname'] . ' ' . $row_students['lastname'];
                                                    ?>
                                                            <div class="form-group student-field">
                                                    <label for="score_<?php echo $student_id; ?>"><?php echo $full_name; ?> </label>
                                                    <input type="number" class="form-control" id="score_<?php echo $student_id; ?>" name="scores[<?php echo $student_id; ?>]" required placeholder="Enter Score for <?php echo $full_name; ?>" value="">
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

                          <!-- Update Score Pop Up Modal for Assignment -->
                          <div class="modal fade" id="update_assignmentscoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Assignment Scores</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form class="" action="class_grades-function.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name = "get_id" value = "<?php echo $get_id ?>">
                                        <input type="hidden" name = "assignment_id" value = "assignment_id">
                                            <div class="form-group">
                                                <label for="title">Assignment</label>
                                                <select name="assignment_id" id="assignment" class="form-control" required onchange="updateScoresAssignment()">
                                                        <option  selected disabled > Select Assignment </option>
                                                        <?php
                                                        $query = mysqli_query($conn, "SELECT assignment_id, fname, max_score FROM assignment WHERE class_id = $get_id AND status = 'Available' ORDER BY assignment_id ASC");
                                                        if ($query && mysqli_num_rows($query) > 0) {
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                $assignment_id = $row["assignment_id"];
                                                                $fname = $row["fname"];
                                                                $max_score = $row["max_score"];
                                                                echo '<option value="' . $assignment_id . '" data-max-score="' . $max_score . '">
                                                                ' . $fname . ' (Max Score: ' . $max_score . ')
                                                            </option>';

                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                            </div>
                                                <?php
                                                // Fetch student data from the database based on teacher_class_id
                                                $query_students = "SELECT s.*, tcs.*
                                                                        FROM student s
                                                                        JOIN teacher_class_student tcs ON s.student_id = tcs.student_id
                                                                        WHERE tcs.teacher_class_id = '$get_id'";
                                                // Execute the query and fetch the results
                                                $result_students = mysqli_query($conn, $query_students);

                                                // Loop through the results and create input fields for each student
                                                while ($row_students = mysqli_fetch_assoc($result_students)) {
                                                    $student_id = $row_students['student_id'];
                                                    $full_name = $row_students['firstname'] . ' ' . $row_students['lastname'];
                                                    ?>
                                                            <div class="form-group student-field-assignment">
                                                            <label for="grade_<?php echo $student_id; ?>"><?php echo $full_name; ?> </label>
                                                            <input type="number" class="form-control" id="grade_<?php echo $student_id; ?>" 
                                                                name="grades[<?php echo $student_id; ?>]" 
                                                                max="<?php echo $max_score; ?>" 
                                                                required 
                                                                placeholder="Enter Score for <?php echo $full_name; ?>" 
                                                                value="">

                                                </div>
                                                        <?php
                                                }
                                                ?>
                                    
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" name="update_scoreAssignment" class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </div> <!-- modal content -->
                        </div> <!-- modal dialog -->
                    </div> <!-- modal fade -->

        <!-- Archive Pop Up Modal for Assignment -->
        <div class="modal fade" id="archive_assignmentscoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Archive Assignment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form class="" action="class_grades-function.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name = "get_id" value = "<?php echo $get_id ?>">
                                        <input type="hidden" name = "assignment_id" value = "assignment_id">
                                            <div class="form-group">
                                                <label for="title">Assignment</label>
                                                <select name="assignment_id" id="assignment" class="form-control" required onchange="updateScoresAssignment()">
                                                        <option  selected disabled > Select Assignment </option>
                                                        <?php
                                                        $query = mysqli_query($conn, "SELECT assignment_id, fname, max_score FROM assignment WHERE class_id = $get_id AND status = 'Available' ORDER BY assignment_id ASC");
                                                        if ($query && mysqli_num_rows($query) > 0) {
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                $assignment_id = $row["assignment_id"];
                                                                $fname = $row["fname"];
                                                                $max_score = $row["max_score"];
                                                                echo '<option value="' . $assignment_id . '" data-max-score="' . $max_score . '">
                                                                ' . $fname . ' (Max Score: ' . $max_score . ')
                                                            </option>';

                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" name="archive_assignment" class="btn btn-success">Archive</button>
                                    </div>
                                </form>
                            </div> <!-- modal content -->
                        </div> <!-- modal dialog -->
                    </div> <!-- modal fade -->

                           

                      <!-- Update Score Pop Up Modal for Quiz -->
                      <div class="modal fade" id="update_quizscoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Quiz Scores</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form class="" action="class_grades-function.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name = "get_id" value = "<?php echo $get_id ?>">
                                        <input type="hidden" name = "quiz_id" value = "quiz_id">
                                            <div class="form-group">
                                                <label for="title">Quiz</label>
                                                <select name="quiz_id" id="quiz" class="form-control" required onchange="updateScoresQuiz()">
                                                        <option  selected disabled > Select Quiz </option>
                                                        <?php

                                                        $query = mysqli_query($conn, "SELECT cq.quiz_id, q.quiz_title, scq.max_score AS max_score
                                                        FROM class_quiz cq
                                                        JOIN quiz q ON cq.quiz_id = q.quiz_id
                                                        LEFT JOIN student_class_quiz scq ON cq.class_quiz_id = scq.class_quiz_id
                                                        WHERE cq.teacher_class_id = $get_id AND q.status = 'Available'
                                                        GROUP BY cq.quiz_id, q.quiz_title
                                                        ORDER BY cq.quiz_id ASC");


                                                        if ($query && mysqli_num_rows($query) > 0) {
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                $quiz_id = $row["quiz_id"];
                                                                $quiz_title = $row["quiz_title"];
                                                                $max_score = $row["max_score"];
                                                                echo '<option value="' . $quiz_id . '" data-max-score="' . $max_score . '">
                                                                        ' . $quiz_title . ' (Max Score: ' . $max_score . ')
                                                                    </option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                            </div>
                                                <?php
                                                // Fetch student data from the database based on teacher_class_id
                                                $query_students = "SELECT s.*, tcs.*
                                                                        FROM student s
                                                                        JOIN teacher_class_student tcs ON s.student_id = tcs.student_id
                                                                        WHERE tcs.teacher_class_id = '$get_id'";
                                                // Execute the query and fetch the results
                                                $result_students = mysqli_query($conn, $query_students);

                                                // Loop through the results and create input fields for each student
                                                while ($row_students = mysqli_fetch_assoc($result_students)) {
                                                    $student_id = $row_students['student_id'];
                                                    $full_name = $row_students['firstname'] . ' ' . $row_students['lastname'];
                                                    ?>
                                                            <div class="form-group student-field-quiz">
                                                    <label for="grade_<?php echo $student_id; ?>"><?php echo $full_name; ?> </label>
                                                    <input type="number" class="form-control" id="grades_<?php echo $student_id; ?>" name="grades[<?php echo $student_id; ?>]" required placeholder="Enter Score for <?php echo $full_name; ?>" value="">
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


                       <!-- Update Score Pop Up Modal for Exam -->
                       <div class="modal fade" id="update_examscoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Exam Scores</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form class="" action="class_grades-function.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name = "get_id" value = "<?php echo $get_id ?>">
                                        <input type="hidden" name = "exam_id" value = "exam_id">
                                            <div class="form-group">
                                                <label for="title">Exam</label>
                                                <select name="exam_id" id="exam" class="form-control" required onchange="updateScoresExam()">
                                                        <option  selected disabled > Select Exam </option>
                                                        <?php
                                                        $query = mysqli_query($conn, "SELECT ce.exam_id, e.exam_title, MAX(sce.max_score) AS max_score
                                                                                        FROM class_exam ce
                                                                                        JOIN exam e ON ce.exam_id = e.exam_id
                                                                                        LEFT JOIN student_class_exam sce ON ce.class_exam_id = sce.class_exam_id
                                                                                        WHERE ce.teacher_class_id = $get_id AND e.status = 'Available'
                                                                                        GROUP BY ce.exam_id, e.exam_title
                                                                                        ORDER BY ce.exam_id ASC");

                                                        if ($query && mysqli_num_rows($query) > 0) {
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                $exam_id = $row["exam_id"];
                                                                $exam_title = $row["exam_title"];
                                                                $max_score = $row["max_score"];
                                                                echo '<option value="' . $exam_id . '" data-max-score="' . $max_score . '">
                                                                            ' . $exam_title . ' (Max Score: ' . $max_score . ')
                                                                        </option>';
                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                            </div>
                                                <?php
                                                // Fetch student data from the database based on teacher_class_id
                                                $query_students = "SELECT s.*, tcs.*
                                                                        FROM student s
                                                                        JOIN teacher_class_student tcs ON s.student_id = tcs.student_id
                                                                        WHERE tcs.teacher_class_id = '$get_id'";
                                                // Execute the query and fetch the results
                                                $result_students = mysqli_query($conn, $query_students);

                                                // Loop through the results and create input fields for each student
                                                while ($row_students = mysqli_fetch_assoc($result_students)) {
                                                    $student_id = $row_students['student_id'];
                                                    $full_name = $row_students['firstname'] . ' ' . $row_students['lastname'];
                                                    ?>
                                                            <div class="form-group student-field-exam">
                                                    <label for="grade_<?php echo $student_id; ?>"><?php echo $full_name; ?> </label>
                                                    <input type="number" class="form-control" id="grades-exam_<?php echo $student_id; ?>" name="grades[<?php echo $student_id; ?>]" required placeholder="Enter Score for <?php echo $full_name; ?>" value="">
                                                </div>
                                                        <?php
                                                }
                                                ?>
                                    
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" name="update_scoreExam" class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </div> <!-- modal content -->
                        </div> <!-- modal dialog -->
                    </div> <!-- modal fade -->

                      <!-- Archive Pop Up Modal for Exam -->
                      <div class="modal fade" id="archive_examModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Archive Exam</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form class="" action="class_grades-function.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name = "get_id" value = "<?php echo $get_id ?>">
                                        <input type="hidden" name = "exam_id" value = "exam_id">
                                            <div class="form-group">
                                                <label for="title">Exam</label>
                                                <select name="exam_id" id="exam" class="form-control" required onchange="updateScoresExam()">
                                                        <option  selected disabled > Select Exam </option>
                                                        <?php
                                                        $query = mysqli_query($conn, "SELECT ce.exam_id, e.exam_title, MAX(sce.max_score) AS max_score
                                                      FROM class_exam ce
                                                      JOIN exam e ON ce.exam_id = e.exam_id
                                                      LEFT JOIN student_class_exam sce ON ce.class_exam_id = sce.class_exam_id
                                                      WHERE ce.teacher_class_id = $get_id AND e.status = 'Available'
                                                      GROUP BY ce.exam_id, e.exam_title
                                                      ORDER BY ce.exam_id ASC");
                                                        if ($query && mysqli_num_rows($query) > 0) {
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                $exam_id = $row["exam_id"];
                                                                $exam_title = $row["exam_title"];
                                                                $max_score = $row["max_score"];
                                                                echo '<option value="' . $exam_id . '" data-max-score="' . $max_score . '">
                                                                        ' . $exam_title . ' (Max Score: ' . $max_score . ')
                                                                    </option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                            </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" name="archive_exam" class="btn btn-success">Archive</button>
                                    </div>
                                </form>
                            </div> <!-- modal content -->
                        </div> <!-- modal dialog -->
                    </div> <!-- modal fade -->

                     <!-- Archive Pop Up Modal for Quiz -->
                     <div class="modal fade" id="archive_quizModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Archive Quiz</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form class="" action="class_grades-function.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name = "get_id" value = "<?php echo $get_id ?>">
                                        <input type="hidden" name = "quiz_id" value = "quiz_id">
                                            <div class="form-group">
                                                <label for="title">Quiz</label>
                                                <select name="quiz_id" id="quiz" class="form-control">
                                                        <option  selected disabled > Select Quiz </option>
                                                        <?php
                                                        $query = mysqli_query($conn, "SELECT cq.quiz_id, q.quiz_title, scq.max_score AS max_score
                                                         FROM class_quiz cq
                                                         JOIN quiz q ON cq.quiz_id = q.quiz_id
                                                         LEFT JOIN student_class_quiz scq ON cq.class_quiz_id = scq.class_quiz_id
                                                         WHERE cq.teacher_class_id = $get_id AND q.status = 'Available'
                                                         GROUP BY cq.quiz_id, q.quiz_title
                                                         ORDER BY cq.quiz_id ASC");

                                                        if ($query && mysqli_num_rows($query) > 0) {
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                $quiz_id = $row["quiz_id"];
                                                                $quiz_title = $row["quiz_title"];
                                                                $max_score = $row["max_score"];
                                                                echo '<option value="' . $quiz_id . '" data-max-score="' . $max_score . '">
                                                                        ' . $quiz_title . '
                                                                    </option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                            </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" name="archive_quiz" class="btn btn-success">Archive</button>
                                    </div>
                                </form>
                            </div> <!-- modal content -->
                        </div> <!-- modal dialog -->
                    </div> <!-- modal fade -->

                     <!-- Archive Pop Up Modal for Performance Tasks -->
                     <div class="modal fade" id="archive_petaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Archive Task</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form class="" action="class_grades-function.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name = "get_id" value = "<?php echo $get_id ?>">
                                        <input type="hidden" name="task_id" id="task_id" value="">
                                            <div class="form-group">
                                                <label for="title">Task</label>
                                                <select name="task_id" id="task" class="form-control" required onchange="updateScores()">
                                                        <option  selected disabled > Select Task </option>
                                                        <?php
                                                        $query = mysqli_query($conn, "SELECT task_id, max_score, task_title FROM task WHERE teacher_class_id = $get_id AND status ='Available' ORDER BY task_id ASC");
                                                        if ($query && mysqli_num_rows($query) > 0) {
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                $task_id = $row["task_id"];
                                                                $task_title = $row["task_title"];
                                                                $max_score = $row["max_score"];
                                                                echo '<option value="' . $task_id . '" data-max-score="' . $max_score . '">
                                                                ' . $task_title . ' (Max Score: ' . $max_score . ')
                                                            </option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                            </div>
                                            <div class = "alert alert-warning"> Once you click CONFIRM, the Task will be archived. </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" name="archive_task" class="btn btn-success">Confirm</button>
                                    </div>
                                </form>
                            </div> <!-- modal content -->
                        </div> <!-- modal dialog -->
                    </div> <!-- modal fade -->

                    <script>
// Function to fetch and populate scores based on the selected task
function updateScores() {
    var taskSelect = document.getElementById('task');
    var taskID = taskSelect.value;

    // Clear all input fields
    var inputs = document.querySelectorAll('[id^="score_"]');
    inputs.forEach(function (input) {
        input.value = '';

        // Set max attribute based on the selected task's max_score
        var maxScore = taskSelect.options[taskSelect.selectedIndex].getAttribute('data-max-score');
        input.setAttribute('max', maxScore);
    });

    // Make all student-related elements visible
    var studentFields = document.querySelectorAll('.student-field');
    studentFields.forEach(function (field) {
        field.style.display = 'block';
    });

    // Make an AJAX request to the PHP script
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Parse the JSON response
            var scores = JSON.parse(xhr.responseText);

            // Populate input fields with scores
            for (var studentID in scores) {
                var inputField = document.getElementById('score_' + studentID);
                if (inputField) {
                    inputField.value = scores[studentID];
                }
            }
        }
    };
    xhr.open('GET', 'fetch-scores.php?task_id=' + taskID, true);
    xhr.send();
}
</script>


<!-- For assignment -->

<script>
   function updateScoresAssignment() {
    var assignmentSelect = document.getElementById('assignment');
    var assignmentID = assignmentSelect.value;

    // Clear all input fields
    var inputs = document.querySelectorAll('[id^="grade_"]');
    inputs.forEach(function (input) {
        input.value = '';
    });

    // Make all student-related elements visible
    var studentFields = document.querySelectorAll('.student-field-assignment');
    studentFields.forEach(function (field) {
        field.style.display = 'block';
    });

    // Make an AJAX request to the PHP script
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Parse the JSON response
            var grades = JSON.parse(xhr.responseText);

            // Populate input fields with scores and set max attribute
            for (var studentID in grades) {
                var inputField = document.getElementById('grade_' + studentID);
                if (inputField) {
                    inputField.value = grades[studentID];

                    // Set max attribute based on the selected assignment's max_score
                    var maxScore = assignmentSelect.options[assignmentSelect.selectedIndex].getAttribute('data-max-score');
                    inputField.setAttribute('max', maxScore);

                    console.log('Populating input for student ' + studentID + ': ' + grades[studentID]);
                }
            }
        }
    };
    xhr.open('GET', 'fetch-scores.php?assignment_id=' + assignmentID, true);
    xhr.send();
}

// Add an event listener to update the max attribute when the assignment is changed
document.getElementById('assignment').addEventListener('change', updateScoresAssignment);

</script>

<!-- For Quiz -->

<script>
function updateScoresQuiz() {
    var quizSelect = document.getElementById('quiz');
    var quizID = quizSelect.value;

    // Clear all input fields
    var inputs = document.querySelectorAll('[id^="grades_"]');
    inputs.forEach(function (input) {
        input.value = '';

        // Set max attribute based on the selected quiz's max_score
        var maxScore = quizSelect.options[quizSelect.selectedIndex].getAttribute('data-max-score');
        input.setAttribute('max', maxScore);
    });

    // Make all student-related elements visible
    var studentFields = document.querySelectorAll('.student-field-quiz');
    studentFields.forEach(function (field) {
        field.style.display = 'block';
    });

    // Make an AJAX request to the PHP script
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Parse the JSON response
            var grades = JSON.parse(xhr.responseText);

            // Populate input fields with scores
            for (var studentID in grades) {
                var inputField = document.getElementById('grades_' + studentID);
                if (inputField) {
                    inputField.value = grades[studentID];
                    console.log('Populating input for student ' + studentID + ': ' + grades[studentID]);
                }
            }
        }
    };
    xhr.open('GET', 'fetch-scores.php?quiz_id=' + quizID, true);
    xhr.send();
}

// Add an event listener to update the max attribute when the quiz is changed
document.getElementById('quiz').addEventListener('change', updateScoresQuiz);
</script>


<!-- For Exam -->

<script>
function updateScoresExam() {
    var examSelect = document.getElementById('exam');
    var examID = examSelect.value;

    // Clear all input fields
    var inputs = document.querySelectorAll('[id^="grades-exam_"]');
    inputs.forEach(function (input) {
        input.value = '';
    });

    // Make all student-related elements visible
    var studentFields = document.querySelectorAll('.student-field-exam');
    studentFields.forEach(function (field) {
        field.style.display = 'block';
    });

    // Make an AJAX request to the PHP script
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Parse the JSON response
            var grades = JSON.parse(xhr.responseText);

            // Populate input fields with scores and set max attribute
            for (var studentID in grades) {
                var inputField = document.getElementById('grades-exam_' + studentID);
                if (inputField) {
                    inputField.value = grades[studentID];

                    // Set max attribute based on the selected exam's max_score
                    var maxScore = examSelect.options[examSelect.selectedIndex].getAttribute('data-max-score');
                    inputField.setAttribute('max', maxScore);

                    console.log('Populating input for student ' + studentID + ': ' + grades[studentID]);
                }
            }
        }
    };
    xhr.open('GET', 'fetch-scores.php?exam_id=' + examID, true);
    xhr.send();
}

// Add an event listener to update the max attribute when the exam is changed
document.getElementById('exam').addEventListener('change', updateScoresExam);
</script>


        <!-- Add Pop Up Modal  for Assignment-->
        <div class="modal fade" id="add_assignmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Assignment Grades</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form class="" action="class_grades-function.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name = "get_id" value = "<?php echo $get_id ?>">
                                        <input type="hidden" name="teacher_id" value="<?php echo $teacher_id = $_SESSION['teacher_id']; ?>">

                                        <div class="form-group">
                                            <label for="fname">Assignment Title</label>
                                            <input type="text" class="form-control" id="fname" name="fname" required placeholder="Enter Assignment Title">
                                        </div>

                                        <!-- <div class="form-group">
                                            <label for="learning_objectives">Learning Objectives</label>
                                            <textarea class="form-control" id="description" name="learning_objectives" required placeholder="Enter Learning Objective(s)"></textarea>
                                        </div> -->
                                        
                                        <div class="form-group">
                                            <label for="max_score">Max Score</label>
                                            <input type="number" class="form-control" id="max_score" name="max_score" required placeholder="Enter Max Score">
                                        </div> <br>

                                        <center> <h5> Student List </h5> </center>

                                         <?php
                                         // Fetch student data from the database based on teacher_class_id
                                         $query_students = "SELECT s.*, tcs.*
                                                                        FROM student s
                                                                        JOIN teacher_class_student tcs ON s.student_id = tcs.student_id
                                                                        WHERE tcs.teacher_class_id = '$get_id'";
                                         // Execute the query and fetch the results
                                         $result_students = mysqli_query($conn, $query_students);

                                         // Loop through the results and create input fields for each student
                                         while ($row_students = mysqli_fetch_assoc($result_students)) {
                                             $student_id = $row_students['student_id'];
                                             $full_name = $row_students['firstname'] . ' ' . $row_students['lastname'];
                                             ?>
                                                            <div class="form-group">
                                                                <label for="score_<?php echo $student_id; ?>"><?php echo $full_name; ?> </label>
                                                                <input type="number" class="form-control" id="score_<?php echo $student_id; ?>" name="scores[<?php echo $student_id; ?>]" required placeholder="Enter Score for <?php echo $full_name; ?>" value="">
                                                            </div>
                                                        <?php
                                         }
                                         ?>
                                        <hr>
                                        <br>
                                    
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" name="add_assignment" class="btn btn-success">Create</button>
                                    </div>
                                </form>
                            </div> <!-- modal content -->
                        </div> <!-- modal dialog -->
                    </div> <!-- modal fade -->

                     <!-- Add Pop Up Modal for QUiz -->
                     <div class="modal fade" id="add_quizModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Quiz</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form class="" action="class_grades-function.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name = "get_id" value = "<?php echo $get_id ?>">
                                        <input type="hidden" name = "teacher_id" value = "<?php echo $teacher_id = $_SESSION['teacher_id']; ?>">
                                        <div class="form-group">
                                            <label for="title">Quiz Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required placeholder="Enter Quiz Title">
                                        </div>
                                   
                                        <div class="form-group">
                                            <label for="max_score">Max Score</label>
                                            <input type="number" class="form-control" id="max_score" name="max_score" required placeholder="Enter Max Score">
                                        </div>
                                        <hr>
                                        <br>
                                    
                                        <center> <h5> Student List </h5> </center>

                                         <?php
                                         // Fetch student data from the database based on teacher_class_id
                                         $query_students = "SELECT s.*, tcs.*
                                                                        FROM student s
                                                                        JOIN teacher_class_student tcs ON s.student_id = tcs.student_id
                                                                        WHERE tcs.teacher_class_id = '$get_id'";
                                         // Execute the query and fetch the results
                                         $result_students = mysqli_query($conn, $query_students);

                                         // Loop through the results and create input fields for each student
                                         while ($row_students = mysqli_fetch_assoc($result_students)) {
                                             $student_id = $row_students['student_id'];
                                             $full_name = $row_students['firstname'] . ' ' . $row_students['lastname'];
                                             ?>
                                                            <div class="form-group">
                                                                <label for="score_<?php echo $student_id; ?>"><?php echo $full_name; ?> </label>
                                                                <input type="number" class="form-control" id="score_<?php echo $student_id; ?>" name="scores[<?php echo $student_id; ?>]" required placeholder="Enter Score for <?php echo $full_name; ?>" value="">
                                                            </div>
                                                        <?php
                                         }
                                         ?>
                                        <hr>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" name="add_quiz" class="btn btn-success">Add</button>
                                    </div>
                                </form>
                            </div> <!-- modal content -->
                        </div> <!-- modal dialog -->
                    </div> <!-- modal fade -->

                    <!-- Add Pop Up Modal for Exam -->
                    <div class="modal fade" id="add_examModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Exam</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form class="" action="class_grades-function.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name = "get_id" value = "<?php echo $get_id ?>">
                                        <input type="hidden" name = "teacher_id" value = "<?php echo $teacher_id = $_SESSION['teacher_id']; ?>">
                                        <div class="form-group">
                                            <label for="title">Exam Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required placeholder="Enter Exam Title">
                                        </div>
                                   
                                        <div class="form-group">
                                            <label for="max_score">Max Score</label>
                                            <input type="number" class="form-control" id="max_score" name="max_score" required placeholder="Enter Max Score">
                                        </div>
                                        <hr>
                                        <br>
                                    
                                        <center> <h5> Student List </h5> </center>

                                         <?php
                                         // Fetch student data from the database based on teacher_class_id
                                         $query_students = "SELECT s.*, tcs.*
                                                                        FROM student s
                                                                        JOIN teacher_class_student tcs ON s.student_id = tcs.student_id
                                                                        WHERE tcs.teacher_class_id = '$get_id'";
                                         // Execute the query and fetch the results
                                         $result_students = mysqli_query($conn, $query_students);

                                         // Loop through the results and create input fields for each student
                                         while ($row_students = mysqli_fetch_assoc($result_students)) {
                                             $student_id = $row_students['student_id'];
                                             $full_name = $row_students['firstname'] . ' ' . $row_students['lastname'];
                                             ?>
                                                            <div class="form-group">
                                                                <label for="score_<?php echo $student_id; ?>"><?php echo $full_name; ?> </label>
                                                                <input type="number" class="form-control" id="score_<?php echo $student_id; ?>" name="scores[<?php echo $student_id; ?>]" required placeholder="Enter Score for <?php echo $full_name; ?>" value="">
                                                            </div>
                                                        <?php
                                         }
                                         ?>
                                        <hr>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" name="add_exam" class="btn btn-success">Add</button>
                                    </div>
                                </form>
                            </div> <!-- modal content -->
                        </div> <!-- modal dialog -->
                    </div> <!-- modal fade -->
                </div>
                <!-- End of Main Content -->

                <?php
                include('includes/scripts.php');
                include('includes/footer.php');
                ?>


