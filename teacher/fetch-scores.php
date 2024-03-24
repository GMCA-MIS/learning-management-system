<?php
// Include your database connection code here
include 'dbcon.php';

if (isset($_GET['task_id'])) {
    $taskID = $_GET['task_id'];

    // Query the database to get scores for the selected task
    $query = "SELECT student_id, score FROM task_result WHERE task_id = $taskID";
    $result = mysqli_query($conn, $query);

    // Fetch the scores and create a JSON response
    $scores = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $studentID = $row['student_id'];
        $score = $row['score'];
        $scores[$studentID] = $score;
    }

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($scores);
}
?>




<?php
// Include your database connection code here
include 'dbcon.php';

if (isset($_GET['assignment_id'])) {
    $assignmentID = $_GET['assignment_id'];

    // Query the database to get scores for the selected task
    $query = "SELECT student_id, grade FROM student_assignment WHERE assignment_id = $assignmentID";
    $result = mysqli_query($conn, $query);

    // Fetch the scores and create a JSON response
    $grades = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $studentID = $row['student_id'];
        $grade = $row['grade'];
        $grades[$studentID] = $grade;
    }

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($grades);
}
?>



<?php
// Include your database connection code here
include 'dbcon.php';

if (isset($_GET['quiz_id'])) {
    $quizID = $_GET['quiz_id'];

    // Query the database to get scores for the selected task
    $query = "SELECT student_id, grade FROM student_class_quiz WHERE quiz_id = $quizID";
    $result = mysqli_query($conn, $query);

    // Fetch the scores and create a JSON response
    $grades = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $studentID = $row['student_id'];
        $grade = $row['grade'];
        $grades[$studentID] = $grade;
    }

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($grades);
}
?>


<?php
// Include your database connection code here
include 'dbcon.php';

if (isset($_GET['exam_id'])) {
    $examID = $_GET['exam_id'];

    // Query the database to get scores for the selected task
    $query = "SELECT student_id, grade FROM student_class_exam WHERE exam_id = $examID";
    $result = mysqli_query($conn, $query);

    // Fetch the scores and create a JSON response
    $grades = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $studentID = $row['student_id'];
        $grade = $row['grade'];
        $grades[$studentID] = $grade;
    }

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($grades);
}
?>