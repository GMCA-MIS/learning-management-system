
<?php
include("dbcon.php");

include("includes/header.php");
include("student_session.php");

?>

<?php


// Assuming you have a database connection in $conn

if (isset($_POST['submit_quiz'])) {
    // Initialize an array to store the results for each question
    $results = [];
    $correctAnswersCount = 0; // Counter for correct answers
    $totalPoints = 0; // Counter for total points
    $totalQuestions = 0; // Counter for total questions
    $class_quiz_id = $_POST['class_quiz_id'];
    $student_id = $_POST['student_id'];
    $get_id = $_POST['quiz_id'];

    // Fetch all questions for the quiz
    $quizQuestions = mysqli_query($conn, "SELECT quiz_question_id, question_text, question_type_id, points FROM quiz_question WHERE quiz_id = $get_id");

    while ($row = mysqli_fetch_assoc($quizQuestions)) {
        $quiz_question_id = $row['quiz_question_id'];
        $question_text = $row['question_text'];
        $question_type_id = $row['question_type_id'];
        $points = $row['points'];
        $totalQuestions++; // Increment the total questions count
        $totalPoints += $points; // Add the question's points to the total

        // Retrieve the correct answer based on the question type
        $correct_answer = '';
        if ($question_type_id == 1 || $question_type_id == 2) {
            // For Multiple Choice and True or False, fetch the correct answer from question_choices
            $sql = "SELECT choice_text FROM question_choices WHERE quiz_question_id = $quiz_question_id AND is_correct = 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $correct_answer = $row['choice_text'];
        } elseif ($question_type_id == 3) {
            // For Identification, fetch the correct answer from the quiz_question table
            $sql = "SELECT answer FROM quiz_question WHERE quiz_question_id = $quiz_question_id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $correct_answer = $row['answer'];
        }

        // Initialize result as not answered
        $submitted_answer = 'Not Answered';
        $is_correct = 'Not Answered';

        // Check if the question was answered and, if so, compare the submitted answer with the correct answer
        $key = "question_$quiz_question_id";
        if (isset($_POST[$key])) {
            $submitted_answer = mysqli_real_escape_string($conn, $_POST[$key]);
            $is_correct = ($submitted_answer === $correct_answer) ? 'Correct' : 'Incorrect';
            if ($is_correct === 'Correct') {
                $correctAnswersCount += $points; // Add question's points to correct answers count
            }
        }

        // Store the result in the array
        $results[$quiz_question_id] = [
            'question_text' => $question_text,
            'correct_answer' => $correct_answer,
            'user_answer' => $submitted_answer,
            'result' => $is_correct,
            'points' => $points,
        ];
    }

    // Calculate the student's total score
    $studentTotalScore = $correctAnswersCount;

    // Print the results, including question text, correct answer, user's answer, and points
    echo '<div class="">'; // Start a container to separate the cards


    // Display the student's total score
    //  echo "Total Score: $studentTotalScore/$totalPoints"; // Display the score as X/Y points, where Y is the total points for the quiz.
    foreach ($results as $quiz_question_id => $result) {
        // echo '<div class="row">'; // Start a new row for each card
        // echo '<div class="col-md-6 mx-auto">'; // Center the card horizontally using mx-auto
        // echo '<div class="card">'; // Start card
        // echo '<div class="card-body">'; // Start card-body

        // echo "Question $quiz_question_id: <br>";
        // echo "Question: " . $result['question_text'] . "<br>";
        // echo "Your Answer: " . $result['user_answer'] . "<br>";
        // echo "Correct Answer: " . $result['correct_answer'] . "<br>";
        // echo "Result: " . $result['result'] . "<br>";
        // echo "Points: " . $result['points'] . "<br>";

        // echo '</div>'; // Close card-body
        // echo '</div>'; // Close card
        // echo '</div>'; // Close column
        // echo '</div>'; // Close row
        // echo "<br>";
    
    }
    echo '<div class="container d-flex justify-content-center align-items-center vh-100">';
    echo '<div class="alert alert-success text-center" role="alert">';
    echo '<p>Your response has been submitted!</p>';
    echo '<a href="index.php" class="btn btn-primary mt-3">Go Back</a>';
    echo '</div>';
    echo '</div>';
                
            // NOTIFICATION FUNCTION FOR QUIZ
            $sqlzz = "SELECT q.quiz_title, q.quiz_id , cq.teacher_class_id FROM class_quiz cq INNER JOIN quiz q ON cq.quiz_id = q.quiz_id WHERE cq.class_quiz_id = $class_quiz_id ";
            $resultzz = mysqli_query($conn, $sqlzz);
            $rowzzz = mysqli_fetch_assoc($resultzz);
            $quiz_id = $rowzzz['quiz_id'];
            $quiz_title = $rowzzz['quiz_title'];
            $teacher_class_id = $rowzzz['teacher_class_id'];
            

            $sqlzz = "SELECT teacher_id FROM teacher_class WHERE teacher_class_id = $teacher_class_id ";
            $resultzz = mysqli_query($conn, $sqlzz);
            $rowzzz = mysqli_fetch_assoc($resultzz);
            $teacher_idz = $rowzzz['teacher_id'];



            $notificationMessage = "Submitted Quiz : ";
            $notificationMessage .= "<b>" . $quiz_title . "</b>";
            $quizlink = "view_class_quiz.php?quiz_id=".$quiz_id."&id="$teacher_class_id;


            $insertNotificationQuery = "INSERT INTO teacher_notification (teacher_class_id, notification, date_of_notification, student_id, assignment_id, teacher_id,link)
            VALUES ('$teacher_idz', '$notificationMessage', NOW(), '$student_id', '$quiz_id', '$teacher_idz','$quizlink')";
            mysqli_query($conn, $insertNotificationQuery);
            


    
    // Store the total score in the student_class_quiz table
    if (isset($student_id) && isset($class_quiz_id)) {
        $studentId = $student_id;
        $classQuizId = $class_quiz_id;

        // Check if a record already exists for the student and class_quiz_id
        $checkSql = "SELECT * FROM student_class_quiz WHERE student_id = $studentId AND class_quiz_id = $classQuizId";
        $checkResult = mysqli_query($conn, $checkSql);



        if (mysqli_num_rows($checkResult) == 0) {
                // If no record exists, insert a new record
                $insertSql = "INSERT INTO student_class_quiz (student_id, class_quiz_id, grade, taken, max_score, quiz_id) VALUES ($studentId, $classQuizId, $studentTotalScore, 'yes', $totalPoints, $get_id)";
                $insertResult = mysqli_query($conn, $insertSql);

                

            // Store the individual question-wise results in the quiz_results table
            foreach ($results as $quiz_question_id => $result) {
                $question_text = mysqli_real_escape_string($conn, $result['question_text']);
                $user_answer = mysqli_real_escape_string($conn, $result['user_answer']);
                $is_correct = ($result['result'] === 'Correct') ? 1 : 0;
                $points = $result['points'];
                $correct_answer = mysqli_real_escape_string($conn, $result['correct_answer']);

                // Insert into quiz_results table
                $insertSql = "INSERT INTO quiz_results (student_id, quiz_question_id, user_answer, is_correct, points, quiz_id, correct_answer) VALUES ($student_id, $quiz_question_id, '$user_answer', $is_correct, $points, $get_id, '$correct_answer')";
                $insertResult = mysqli_query($conn, $insertSql);

                if (!$insertResult) {
                    echo "Error inserting quiz result into the database: " . mysqli_error($conn);
                    // Handle the error as needed
                }
            }
                if ($insertResult) {
                    echo "Score has been inserted into the database.";
                    //teacher notification

                        


                } else {
                    echo "Error inserting the score into the database.";
                }
            } else {
                // echo "A record already exists for this student and class quiz.";
            }
        } else {
            echo "The form has not been submitted.";
    }
}


?>



<?php
include("dbcon.php");

if (isset($_POST['submit_exam'])) {
    // Initialize an array to store the results for each question
    $results = [];
    $correctAnswersCount = 0; // Counter for correct answers
    $totalPoints = 0; // Counter for total points
    $totalQuestions = 0; // Counter for total questions
    $class_exam_id = $_POST['class_exam_id'];
    $student_id = $_POST['student_id'];
    $get_id = $_POST['exam_id'];

    // Fetch all questions for the exam
    $examQuestions = mysqli_query($conn, "SELECT exam_question_id, question_text, question_type_id, points FROM exam_question WHERE exam_id = $get_id");

    while ($row = mysqli_fetch_assoc($examQuestions)) {
        $exam_question_id = $row['exam_question_id'];
        $question_text = $row['question_text'];
        $question_type_id = $row['question_type_id'];
        $points = $row['points'];
        $totalQuestions++; // Increment the total questions count
        $totalPoints += $points; // Add the question's points to the total

        // Retrieve the correct answer based on the question type
        $correct_answer = '';
        if ($question_type_id == 1 || $question_type_id == 2) {
            // For Multiple Choice and True or False, fetch the correct answer from exam_choices
            $sql = "SELECT choice_text FROM exam_choices WHERE exam_question_id = $exam_question_id AND is_correct = 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $correct_answer = $row['choice_text'];
        } elseif ($question_type_id == 3) {
            // For Identification, fetch the correct answer from the exam_question table
            $sql = "SELECT answer FROM exam_question WHERE exam_question_id = $exam_question_id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $correct_answer = $row['answer'];
        }

        // Initialize result as not answered
        $submitted_answer = 'Not Answered';
        $is_correct = 'Not Answered';

        // Check if the question was answered and, if so, compare the submitted answer with the correct answer
        $key = "question_$exam_question_id";
        if (isset($_POST[$key])) {
            $submitted_answer = mysqli_real_escape_string($conn, $_POST[$key]);
            $is_correct = ($submitted_answer === $correct_answer) ? 'Correct' : 'Incorrect';
            if ($is_correct === 'Correct') {
                $correctAnswersCount += $points; // Add question's points to correct answers count
            }
        }

        // Store the result in the array
        $results[$exam_question_id] = [
            'question_text' => $question_text,
            'correct_answer' => $correct_answer,
            'user_answer' => $submitted_answer,
            'result' => $is_correct,
            'points' => $points,
        ];
    }

    // Calculate the student's total score
    $studentTotalScore = $correctAnswersCount;

// Print the results, including question text, correct answer, user's answer, and points
echo '<div class="col-md-12" >'; // Start a container to separate the cards
 // Display the student's total score

    echo "<nav class='navbar ' style='background-color:#381C14;margin-top:10px;margin-bottom:30px;padding:20px 20px 15px 20px;margin-left:100px;margin-right:100px;' >";
    
?>
<form class="form-inline">

    <?php
        echo "<h5 style='color:white' ><b>Total Score: $studentTotalScore/$totalPoints </b></h5>"; // Display the score as X/Y points, where Y is the total points for the exam.

    ?>
  </form>

    <a class="btn btn-outline-light" href="index.php" >Close</a>

<?php
    echo "</nav>";

    foreach ($results as $exam_question_id => $result) {
    echo '<div class="row">'; // Start a new row for each card
    echo '<div class="col-md-6 mx-auto">'; // Center the card horizontally using mx-auto
    echo '<div class="card">'; // Start card
    
    echo '<div class="card-body">'; // Start card-body

    echo "Question $exam_question_id: <br>";
    echo "Question: " . $result['question_text'] . "<br>";
    echo "Your Answer: " . $result['user_answer'] . "<br>";
    echo "Correct Answer: " . $result['correct_answer'] . "<br>";
    echo "Result: " . $result['result'] . "<br>";
    echo "Points: " . $result['points'] . "<br>";

    echo '</div>'; // Close card-body
    echo '</div>'; // Close card
    echo '</div>'; // Close column
    echo '</div>'; // Close row
    echo "<br>";
    }   
    
    echo '</div>'; // Close the container

    
    // NOTIFICATION FUNCTION FOR EXAM
    $sqlzz = "SELECT e.exam_title, e.exam_id , ce.teacher_class_id FROM class_exam ce INNER JOIN exam e ON ce.exam_id = e.exam_id WHERE ce.class_exam_id = $class_exam_id ";
    $resultzz = mysqli_query($conn, $sqlzz);
    $rowzzz = mysqli_fetch_assoc($resultzz);
    $exam_id = $rowzzz['exam_id'];
    $exam_title = $rowzzz['exam_title'];
    $teacher_class_id = $rowzzz['teacher_class_id'];
    

    $sqlzz = "SELECT teacher_id FROM teacher_class WHERE teacher_class_id = $teacher_class_id ";
    $resultzz = mysqli_query($conn, $sqlzz);
    $rowzzz = mysqli_fetch_assoc($resultzz);
    $teacher_idz = $rowzzz['teacher_id'];


    $notificationMessage = "Submitted Exam : ";
    $notificationMessage .= "<b>" . $exam_title . "</b>";

    $insertNotificationQuery = "INSERT INTO teacher_notification (teacher_class_id, notification, date_of_notification, student_id, assignment_id, teacher_id)
    VALUES ('$teacher_idz', '$notificationMessage', NOW(), '$student_id', '$exam_id', '$teacher_idz')";
    mysqli_query($conn, $insertNotificationQuery);

    // Store the total score in the student_class_exam table
    if (isset($student_id) && isset($class_exam_id)) {
        $studentId = $student_id;
        $classexamId = $class_exam_id;

            // Check if a record already exists for the student and class_exam_id
            $checkSql = "SELECT * FROM student_class_exam WHERE student_id = $studentId AND class_exam_id = $classexamId";
            $checkResult = mysqli_query($conn, $checkSql);

            if (mysqli_num_rows($checkResult) == 0) {
                // If no record exists, insert a new record
                $insertSql = "INSERT INTO student_class_exam (student_id, class_exam_id, grade, taken, max_score, exam_id) VALUES ($studentId, $classexamId, $studentTotalScore, 'yes', $totalPoints, $get_id)";
                $insertResult = mysqli_query($conn, $insertSql);
            // Store the individual question-wise results in the exam_results table
            foreach ($results as $exam_question_id => $result) {
                $question_text = mysqli_real_escape_string($conn, $result['question_text']);
                $user_answer = mysqli_real_escape_string($conn, $result['user_answer']);
                $is_correct = ($result['result'] === 'Correct') ? 1 : 0;
                $points = $result['points'];
                $correct_answer = mysqli_real_escape_string($conn, $result['correct_answer']);

                // Insert into exam_results table
                $insertSql = "INSERT INTO exam_results (student_id, exam_question_id, user_answer, is_correct, points, exam_id, correct_answer) VALUES ($student_id, $exam_question_id, '$user_answer', $is_correct, $points, $get_id, '$correct_answer')";
                $insertResult = mysqli_query($conn, $insertSql);

                if (!$insertResult) {
                    echo "Error inserting exam result into the database: " . mysqli_error($conn);
                    // Handle the error as needed
                }
            }
                if ($insertResult) {
                    echo "Score has been inserted into the database.";
                } else {
                    echo "Error inserting the score into the database.";
                }
            } else {
                
                //sucess submitting exam
            // echo "A record already exists for this student and class exam.";
            }
        } else {
            echo "The form has not been submitted.";
        }
    }


?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

</script>