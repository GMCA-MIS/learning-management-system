<?php
include('student_session.php');
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
    WHERE teacher_class_id = '$get_id'") or die(mysqli_error());

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
                          
                            </div>
                            
                            <?php
                       $student_id = $_SESSION['student_id'];  // Assuming 'student_id' is the correct session variable name

                       $query_assignment_titles = "SELECT a.*, sa.student_id, sa.grade
                                                   FROM assignment a
                                                   LEFT JOIN student_assignment sa ON a.assignment_id = sa.assignment_id   
                                                   WHERE a.class_id = $get_id AND a.status = 'Available' AND sa.student_id = $student_id";

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
                            WHERE s.student_id = $student_id";
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
                         
                            </div>
                            <?php
                            $query_quiz_titles = "SELECT q.*, cq.*, scq.grade, scq.max_score
                            FROM quiz q
                            JOIN class_quiz cq ON q.quiz_id = cq.quiz_id
                            LEFT JOIN student_class_quiz scq ON cq.class_quiz_id = scq.class_quiz_id
                            WHERE cq.teacher_class_id = '$get_id' AND q.status = 'Available' AND scq.student_id = $student_id";
                            
                            

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
                            WHERE s.student_id = $student_id";

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
                                                    echo "{$grade}/{$max_score} ({$percentage}%)";
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
                            
                            </div>
                            <?php
                            $query_exam_titles = "SELECT e.*, ce.*, sce.grade, sce.max_score
                            FROM exam e
                            JOIN class_exam ce ON e.exam_id = ce.exam_id
                            LEFT JOIN student_class_exam sce ON ce.class_exam_id = sce.class_exam_id
                            WHERE ce.teacher_class_id = '$get_id' AND e.status = 'Available' AND sce.student_id = $student_id";

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
                            WHERE s.student_id = $student_id";;

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
$student_id = $_SESSION['student_id'];

$query_students = "SELECT ts.student_id, s.firstname, s.lastname
                    FROM teacher_class_student ts
                    LEFT JOIN student s ON ts.student_id = s.student_id
                    WHERE ts.teacher_class_id = $get_id AND ts.student_id = $student_id";


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
    }
    elseif($subject_type == "Applied" && $track == "TVL") {
        // Add the assignment_grade and task_grade, divide by 2, multiply by 0.4
        $total_percentage += (($assignment_grade + $task_grade) / 2) * 0.7;

        // Add the quotient of exam_grade plus quiz_grade divided by 2, multiply by 0.6
        $total_percentage += (($exam_grade + $quiz_grade) / 2) * 0.3;
    }
    elseif($subject_type == "Specialized" && $track == "Academic") {
        // Add the assignment_grade and task_grade, divide by 2, multiply by 0.4
        $total_percentage += (($assignment_grade + $task_grade) / 2) * 0.6;

        // Add the quotient of exam_grade plus quiz_grade divided by 2, multiply by 0.6
        $total_percentage += (($exam_grade + $quiz_grade) / 2) * 0.4;
    }
    elseif($subject_type == "Specialized" && $track == "TVL") {
        // Add the assignment_grade and task_grade, divide by 2, multiply by 0.4
        $total_percentage += (($assignment_grade + $task_grade) / 2) * 0.7;

        // Add the quotient of exam_grade plus quiz_grade divided by 2, multiply by 0.6
        $total_percentage += (($exam_grade + $quiz_grade) / 2) * 0.3;
    }

    elseif($subject_type == "Core" && $track == "Academic") {
        // Add the assignment_grade and task_grade, divide by 2, multiply by 0.4
        $total_percentage += (($assignment_grade + $task_grade) / 2) * 0.6;

        // Add the quotient of exam_grade plus quiz_grade divided by 2, multiply by 0.6
        $total_percentage += (($exam_grade + $quiz_grade) / 2) * 0.4;
    }

    elseif($subject_type == "Core" && $track == "TVL") {
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
                                </div>
                            </div>

                            <?php
                            $query_task_titles = "SELECT * FROM task WHERE class_id = $get_id AND status = 'Available'";

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
                            $student_id = $_SESSION['student_id'];

                            $query_students = "SELECT s.*, tcs.*, tr.*, t.*
                                                FROM student s
                                                JOIN teacher_class_student tcs ON s.student_id = tcs.student_id
                                                LEFT JOIN task_result tr ON s.student_id = tr.student_id
                                                LEFT JOIN task t ON tr.task_id = t.task_id
                                                WHERE tcs.teacher_class_id = '$get_id' AND t.class_id = '$get_id' AND t.status = 'Available' AND s.student_id = '$student_id'";
                            
         

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


                

                <?php
                include('includes/scripts.php');
                include('includes/footer.php');
                ?>


