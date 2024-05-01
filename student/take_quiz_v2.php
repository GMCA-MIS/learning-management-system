<style>
#unansweredModal {
    z-index: 1050; /* Adjust the z-index value as needed */
}
.modal-backdrop {
    display: none;
}

.unanswered-question-btn {
    padding: 5px;
    background-color: white;
    margin-bottom: 2px;
    border-radius: 1px;
    color: black;
    width: 140px;
    transition: background-color 0.3s, color 0.3s; /* Adding transition for smooth effect */
}

.unanswered-question-btn:hover {
    background-color: #333; /* Change background color on hover */
    color: white; /* Change text color on hover */
}

</style>
<?php
$get_id = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null; // Get the quiz_id from the URL

require_once 'dbcon.php';

// Function to get the CSS file path based on the theme
function getCssFilePath($conn, $quiz_id)
{
    $theme = getQuizTheme($conn, $quiz_id);

    // Map the theme to the corresponding CSS file
    if ($theme === 'stars') {
        return 'stars.css?' . time();
    } elseif ($theme === 'galaxy') {
        return 'boxes.css?' . time();
    } elseif ($theme === 'boxes') {
        return 'galaxy.css?' . time();
    } elseif ($theme === 'normal') {
        return 'normal.css?' . time();
    } else {
        return 'default.css?' . time(); // Default theme
    }
}

// Function to get the theme from the database based on quiz_id
function getQuizTheme($conn, $quiz_id)
{
    $query = "SELECT theme FROM quiz WHERE quiz_id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $quiz_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $theme);

        if (mysqli_stmt_fetch($stmt)) {
            return $theme;
        } else {
            die("Quiz with ID $quiz_id not found.");
        }

        //mysqli_stmt_close($stmt);
    } else {
        die("Error in SQL statement: " . mysqli_error($conn));
    }
}

?>
<style>
    #background-video {
        display:
            <?php echo ($theme === 'Galaxy') ? 'block' : 'none'; ?>
        ;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -1;
    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700&display=swap" rel="stylesheet">
    <link href="css/<?php echo getCssFilePath($conn, $get_id); ?>" rel="stylesheet">
</head>

<body>
    <script>

        window.history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function () {
            window.history.pushState(null, null, document.URL);
        });

        document.addEventListener("keydown", function (e) {
            if (e.key === "Enter" || e.keyCode === 13) {
                e.preventDefault();
            }
        });
    </script>

    <?php
    include('student_session.php');
    ?>
    <?php $get_id = $_GET['quiz_id']; ?>
    <?php

    include('includes/header.php');

    include('dbcon.php');
    include('initialize.php');
    ?>
    <?php
    // Assuming you have a database connection in $conn
    
    // Query to check if the student has taken the quiz
    $sql = "SELECT * FROM student_class_quiz WHERE student_id = $student_id AND quiz_id = $get_id AND taken = 'yes'";
    $result = mysqli_query($conn, $sql);

    // Check if there is a row in the result set
    if (mysqli_num_rows($result) > 0) {
        echo "<script>window.location.href = '../deny.php';</script>";
        exit();
    } else {

    }

    ?>

    <?php
    // SQL query to fetch data from the quiz table
    $sql = "SELECT q.*, qq.*, qt.*, qc.*, cq.*
        FROM quiz AS q
        LEFT JOIN quiz_question AS qq ON q.quiz_id = qq.quiz_id
        LEFT JOIN question_type AS qt ON qq.question_type_id = qt.question_type_id
        LEFT JOIN question_choices AS qc ON qq.quiz_question_id = qc.quiz_question_id
        LEFT JOIN class_quiz AS cq ON q.quiz_id = cq.quiz_id
        WHERE q.quiz_id = $get_id";


    // Execute the query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // Quiz Table
            $quiz_id = $row['quiz_id'];
            $quiz_title = $row['quiz_title'];
            $quiz_description = $row['quiz_description'];
            $date_added = $row['date_added'];
            $teacher_id = $row['teacher_id'];
            $deadline = $row['deadline'];

            //Quiz Question
            $quiz_question_id = $row['quiz_question_id'];
            $quiz_id = $row['quiz_id'];
            $question_type_id = $row['question_type_id'];
            $points = $row['points'];
            $answer = $row['answer'];
            $image = $row['image'];

            //Question Type
            $question_type_id = $row['question_type_id'];
            $question_type = $row['question_type'];

            //Question Choices
            $choice_id = $row['choice_id'];
            $quiz_question_id = $row['quiz_question_id'];
            $choice_text = $row['choice_text'];
            $is_correct = $row['is_correct'];

            //Class Quiz
            $class_quiz_id = $row['class_quiz_id'];
            $teacher_class_id = $row['teacher_class_id'];
            $quiz_time = $row['quiz_time'];
            $quiz_id = $row['quiz_id'];

        } else {
            echo '<script>
          window.location.href = "../deny.php";
          exit(); 
        </script>';
        }
    } else {
        echo '<script>
        window.location.href = "../deny.php";
        exit(); 
      </script>';
    }
    ?>
    <?php $questions = []; // Store questions in an array
    $currentQuestionID = null;
    $questionNumber = 1;
    $totalQuestions = 0; // Initialize total questions
    ?>
    <div class="banner-text">
        <nav class="navbar navbar-expand navbar-light bg-black topbar pt-4 mb-4 static-top"
            style="max-height: 50px; background: linear-gradient(to bottom, #000, #111); box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); display: flex; justify-content: space-between; align-items: center;">
            <div class="countdown-box"
                style="background-color: #2b2b2b; padding: 4px; margin-bottom: 10px; border-radius: 5px;">
                <p style="color: white; margin: 0;"><i class='fas fa-stopwatch'></i>: <span id="countdown"></span></p>
            </div>

            <div class="stopwatch-box"
                style="background-color: #2b2b2b; padding: 4px; margin-bottom: 10px; border-radius: 5px; display: flex; align-items: center;">
                <audio id="myAudio" src="../includes/quizsound.mp3" autoplay></audio>
                <i id="sound-icon" class="fa fa-music"
                    style="font-size: 24px; cursor: pointer;  width: 20px; margin-right: 10px;"></i>
            </div>
        </nav>
        <script>
            /* REY
            const audio = document.getElementById('myAudio');
            const soundIcon = document.getElementById('sound-icon');

            let isSoundOn = true;

            // Autoplay the audio when the page loads
            audio.autoplay = true;

            soundIcon.addEventListener('click', toggleSound);

            function toggleSound() {
                if (isSoundOn) {
                    audio.pause();
                    audio.currentTime = 0; // Rewind to the beginning
                    soundIcon.classList.remove('fa-volume-up');
                    soundIcon.classList.add('fa-volume-off');
                } else {
                    audio.play();
                    soundIcon.classList.remove('fa-volume-off');
                    soundIcon.classList.add('fa-volume-up');
                }

                isSoundOn = !isSoundOn;
            }*/
        </script>
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Content Row -->
            <div class="row justify-content-center">
                <div class="col-lg-12" style="background-color:rgba(255, 255, 255, 0.5);padding:20px;">

                    <!-- Quiz Title -->
                    <!-- <div class="card mb-4">
                <div class="card-body text-center">
                    <h6 class="card-title"><?php echo $quiz_description ?></h6>
                </div>
            </div> -->

                    <!-- Question Container -->
                    <form method="post" id="quiz-form" action="check_answers.php">
                        

                        <!-- Add the form element and set the action to a PHP script for checking answers -->
                        <input type="hidden" name="submit_quiz" value="submit_quiz">
                        <input type="hidden" name="quiz_id" value="<?php echo $get_id ?>">
                        <input type="hidden" name="class_quiz_id" value="<?php echo $class_quiz_id ?>">
                        <input type="hidden" name="student_id" value="<?php echo $student_id ?>">
                        <div id="quiz-container">
                            <?php
                            // Fetch and store questions, choices, and images in the $questions array
                            $sql = "SELECT quiz_question.*, question_choices.choice_text , question_choices.is_correct
                            FROM quiz_question
                            LEFT JOIN question_choices ON quiz_question.quiz_question_id = question_choices.quiz_question_id
                            WHERE quiz_question.quiz_id = $get_id";

                            $question_show = false;
                            $quiz_question_id = "";
                            $question_cntr = 0;
                            $result = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<div style='padding-top:20px;'>";
                                $question_text= $row['question_text'];
                                if($quiz_question_id == ""){
                                    $question_cntr = $question_cntr + 1;
                                    $quiz_question_id = $row['quiz_question_id'];

                                    echo "<div class='row' style='margin-top:20px;margin-bottom:10px;'>";
                                    echo "<div >$question_cntr. ) </div>";
                                    echo "<div  class='col-lg-11'><b>$question_text</b></div>";
                                    echo  "</div>";
                                }elseif($quiz_question_id != $row['quiz_question_id']){
                                    $question_cntr = $question_cntr + 1;
                                    $quiz_question_id = $row['quiz_question_id'];

                                    
                                    echo "<div class='row' style='margin-top:20px;margin-bottom:10px;'>";
                                    echo "<div >$question_cntr. ) </div>";
                                    echo "<div  class='col-lg-11'><b>$question_text</b></div>";
                                    echo  "</div>";
                                }

                                if($row['question_type_id'] == 3){
                                    echo "<div>";
                                    echo "<input type='text' 
                                            data-points$question_cntr='".$row['points']."'
                                                data-answer$question_cntr='".$row['answer']."'
                                                    data-iscorrect$question_cntr='".$row['is_correct']."'  
                                                        name='choice$question_cntr' value='' 
                                                            placeholder='Enter Answer' style='padding:5px'/>";
                                    echo "</div>";
                                }elseif(($row['question_type_id'] == 2)  || ($row['question_type_id'] == 1)){
                                    echo "<div>";
                                    echo '<input type="radio"  data-points'.$question_cntr.'="'.$row['points'].'"
                                            data-answer'.$question_cntr.'="'.$row['answer'].'" 
                                                data-iscorrect'.$question_cntr.'="'.$row['is_correct'].'"  
                                                    name="choice'.$question_cntr.'"  value="'.$row['choice_text'].
                                                        '" style="margin:10px" class="">'.$row['choice_text'].'</input>';
                                    echo "</div>";
                                }
                                echo "</div>";

                            }       
                                echo "<input type='text' name='question_cntr' value=".$question_cntr.">";
                                
                            ?>
                            </div>

                            <!-- Next and Previous Buttons -->



                    </form> <!-- Close the form element -->



                </div>
            </div>
            <!-- Question Number List at the bottom -->
            <div id="question-number-list" class="fixed-bottom mb-4 p-3 text-center">
                <div class="question-pages-container">
                    <?php
                    $questionsPerPage = 5; // Number of questions per page
                    $totalPages = ceil($totalQuestions / $questionsPerPage);

                    for ($page = 1; $page <= $totalPages; $page++) {
                        echo '<div class="question-page" data-page="' . $page . '" style="display: ' . ($page === 1 ? 'block' : 'none') . ';">';
                        for ($i = ($page - 1) * $questionsPerPage + 1; $i <= min($page * $questionsPerPage, $totalQuestions); $i++) {
                            echo '<button class="question-number btns" data-question-id="' . $i . '">' . $i . '</button>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
                <button id="review-button" type="button" class="btn btn-info ml-2 mr-2">
        Review
    </button>
                <button id="prev-button" type="button" class="btn btn-success ml-2 mr-2"
                    onclick="showPrevQuestion()">Previous </button>
                <button id="next-button" type="button" class="btn btn-success"
                    onclick="showNextQuestion()">Next</button>
                <button type="submit" name="submit_quiz" id="quiz_submit" class="btn btn-success"
                    style="display: none;">Submit</button>
                <button type="button" name="submit_quiz" id="submit_button_quiz" class="btn btn-success">Submit</button>
                
                <button style="margin-left:5px" type="button" name="" id="" onclick="forcecomplete();" class="btn btn-success">Complete Now</button>

            </div>
<!-- Modal -->
<div class="modal fade" id="unansweredModal" tabindex="-1" role="dialog" aria-labelledby="unansweredModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unansweredModalLabel">Unanswered Questions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="unansweredQuestionsList">
                <!-- Unanswered questions will be populated here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
/* REY
function forcecomplete(){

Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Confirm!"
    }).then((result) => {
    if (result.isConfirmed) {
        
        startQuizTimer(5);

    }
});
}


function showUnansweredModal() {
    let unansweredQuestions = [];

    let questions = document.querySelectorAll('.question-container');

    questions.forEach((question, index) => {
        let questionId = index + 1; // Assign a question number based on the index (assuming questions start from 1)
        let questionType = question.querySelector('input[type="radio"], input[type="text"]');
        
        if (
            (questionType && questionType.value === '') || // For text input type
            (questionType && questionType.type === 'radio' && !question.querySelector('input[type="radio"]:checked')) // For radio input type
        ) {
            unansweredQuestions.push(questionId); // Store the question number in the array
        }
    });

    let modalBody = document.getElementById('unansweredQuestionsList');
    modalBody.innerHTML = '';
    
    if (unansweredQuestions.length === 0) {
        modalBody.innerHTML = '<p>All questions have been answered.</p>';
    } else {
        unansweredQuestions.forEach(questionId => {
            let button = document.createElement('button');
            button.textContent = 'Question ' + questionId;
            button.classList.add('unanswered-question-btn');
            button.onclick = function() {
                $('#unansweredModal').modal('hide');
                showQuestion(questionId); // Show the clicked question in the quiz interface
            };
            modalBody.appendChild(button);
            modalBody.appendChild(document.createElement('br'));
        });
    }

    $('#unansweredModal').modal('show');
}

// Attach click event to the "Review" button
document.getElementById('review-button').addEventListener('click', function() {
    showUnansweredModal();
});
*/
</script>

        <?php
            include('includes/scriptsquiztimer_v2.php');
            ?>
            <!-- End Content Row -->

        </div>
    </div>
    <section>

    </section>
    <div class="animation-area">
        <ul class="box-area">
            <video id="background-video" autoplay loop muted>
                <source src="../includes/star.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
</body>

</html>