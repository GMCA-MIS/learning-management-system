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

<style>
.card:hover {
  
    transform: none !important; /* Set transform property to none to disable the zoom effect */
    /* Any other styles applied during hover state can be overridden here */

}
@media (max-width: 768px) {
    .question-container {
        width: 90%; /* Use a percentage width for smaller screens */
    }
}

.question-container {
    position: relative;
}

.question-container .btn {
    position: absolute;
    bottom: 10px; /* Adjust the bottom position as needed */
}
.choices {
   
    margin: 0 auto; /* Center the container horizontally */
}
.card:hover {
    box-shadow: 0 0 0 !important; /* Reset box-shadow to none on hover */
}
    </style>
<?php 
include('student_session.php');  
?>
<?php $get_id = $_GET['exam_id']; ?>
<?php

include('includes/header.php');

include('dbcon.php');
include('initialize.php');
?>
<?php
// Assuming you have a database connection in $conn

// Query to check if the student has taken the exam
$sql = "SELECT * FROM student_class_exam WHERE student_id = $student_id AND exam_id = $get_id AND taken = 'yes'";
$result = mysqli_query($conn, $sql);

// Check if there is a row in the result set
if (mysqli_num_rows($result) > 0) {
    header("Location: ../deny.php");
    exit();
} else {
  
}

?>
<?php $get_id = $_GET['exam_id']; // Get the exam_id from the URL ?>

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

    .moving-background {
        background-size: 200% auto;
        background-image: linear-gradient(to right, rgba(23, 24, 32, 0.95), #FFD700, #FF8C00);
        animation: gradientMovement 10s ease infinite;
    }

    @keyframes gradientMovement {
        0% {
            background-position: 0% center;
        }

        50% {
            background-position: 100% center;
        }

        100% {
            background-position: 0% center;
        }
    }

    .card-body .exam-button {
        background-size: 200% auto;
        background-image: linear-gradient(to right, black, red, white);
        animation: gradientMovement 10s ease infinite;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        /* Change the background color to complement the gradient */
        background-color: #006699; /* Replace with your preferred color */
    }

    .card-body .exam-button:hover {
        background-color: red; /* Change the hover color to complement the gradient */
    }
    
    .custom-radio {
    display: inline-block;
    margin-right: 10px; /* Add spacing between choices if needed */
    cursor: pointer;
}

.custom-radio input {
    display: none;
}
#question-number-list {
    display: flex;
    align-items: center;
}

.question-pages-container {
    display: flex;
    margin: 0 5px; /* Adjust margin as needed */
}

.question-number {
    margin: 0 2px; /* Adjust margin as needed */
}

.choice-box {
    display: inline-block;
    width: 200px;
    padding: 15px;
    background-color: #fff;
    transition: background-color 0.5s ease, box-shadow 0.3s ease; /* Adjust transition timing function */
    border: 1px solid rgba(0, 0, 0, 0.1); /* Use a transparent border for a smoother look */
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    text-align: center;
    color: #000;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Update box shadow for a smoother effect */
}
.choice-box:hover {
    background-color: rgba(23, 24, 32, 0.80); /* Updated background color on hover */
    color: #fff; /* Text color on hover */
    border-color: rgba(23, 24, 32, 0.80); /* Border color on hover */
}


.custom-radio input:checked + .choice-box {
    background-color: rgba(23, 24, 32, 0.95); /* Change the background color when selected */
    border: 1px solid #007bff; /* Change the border color when selected */
    color: #fff; /* Change text color when selected */
    border: 1px black solid;
    transition: background-color 0.3s; /* Add transition effect for color change */
}

.btns {
    background-color: transparent;
    color: #333; /* Text color */
    border: 2px solid #333; /* Border color */
    border-radius: 8px; /* Rounded corners */
    padding: 8px 16px; /* Padding around the number */
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s; /* Add smooth transitions */
}

.btns:hover {
    background-color: #333; /* Background color on hover */
    color: #fff; /* Text color on hover */
    border-color: #333; /* Border color on hover */
}

.btns.clicked {
    background-color: rgba(23, 24, 32, 0.95);
    color: #fff; /* Text color when clicked */
    border-color: rgba(23, 24, 32, 0.95); /* Border color when clicked */
}


</style>


<?php
// SQL query to fetch data from the exam table
$sql = "SELECT q.*, qq.*, qt.*, qc.*, cq.*
        FROM exam AS q
        LEFT JOIN exam_question AS qq ON q.exam_id = qq.exam_id
        LEFT JOIN question_type AS qt ON qq.question_type_id = qt.question_type_id
        LEFT JOIN exam_choices AS qc ON qq.exam_question_id = qc.exam_question_id
        LEFT JOIN class_exam AS cq ON q.exam_id = cq.exam_id
        WHERE q.exam_id = $get_id";


// Execute the query
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // exam Table
        $exam_id = $row['exam_id'];
        $exam_title = $row['exam_title'];
        $exam_description = $row['exam_description'];
        $date_added = $row['date_added'];
        $teacher_id = $row['teacher_id'];
        $deadline = $row['deadline'];

        //exam Question
        $exam_question_id = $row['exam_question_id'];
        $exam_id = $row['exam_id'];
        $question_type_id = $row['question_type_id'];
        $points = $row['points'];
        $answer = $row['answer'];
        $image = $row['image'];

        //Question Type
        $question_type_id = $row['question_type_id'];
        $question_type = $row['question_type'];

        //Question Choices
        $choice_id = $row['choice_id'];
        $exam_question_id = $row['exam_question_id'];
        $choice_text = $row['choice_text'];
        $is_correct = $row['is_correct'];

        //Class exam
        $class_exam_id = $row['class_exam_id'];
        $teacher_class_id = $row['teacher_class_id'];
        $exam_time = $row['exam_time'];
        $exam_id = $row['exam_id'];
        
    } else {
        echo '<script>
          window.location.href = "../deny.php";
          exit(); 
        </script>';
      }
    }else {
        echo '<script>
        window.location.href = "../deny.php";
        exit(); 
      </script>';
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
            <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                <h1 class="h3 mb-0 text-gray-800">exam: <?php echo $row['exam_title'] ?></h1>
            </div>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

    <!-- Content Row -->
    <div class="row justify-content-center cc" style = "background-color: white;">
        <div class="col-lg-8">

            <!-- exam Title -->
           <!-- <div class="card mb-4">
                <div class="card-body text-center">
                    <h6 class="card-title"><?php echo $exam_description ?></h6>
                </div>
            </div> -->
            <p><i class='fas fa-stopwatch'></i>: <span id="countdown"></span></p>
            <!-- Question Container -->
            <form method="post" id= "exam-form" action="check_answers.php"> <!-- Add the form element and set the action to a PHP script for checking answers -->
            <input type="hidden" name="submit_exam" value="submit_exam">
            <input type="hidden" name = "exam_id" value = "<?php echo $get_id ?>">
            <input type="hidden" name = "class_exam_id" value = "<?php echo $class_exam_id ?>">
            <input type="hidden" name = "student_id" value = "<?php echo $student_id ?>">
                <div id="exam-container">
                <?php
$questions = []; // Store questions in an array
$currentQuestionID = null;
$questionNumber = 1;
$totalQuestions = 0; // Initialize total questions

// Fetch and store questions, choices, and images in the $questions array
$sql = "SELECT exam_question.*, exam_choices.choice_text 
        FROM exam_question
        LEFT JOIN exam_choices ON exam_question.exam_question_id = exam_choices.exam_question_id
        WHERE exam_question.exam_id = $get_id";

$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $exam_question_id = $row['exam_question_id'];

    if ($exam_question_id != $currentQuestionID) {
        $questions[$exam_question_id] = [
            'question_text' => $row['question_text'],
            'question_type_id' => $row['question_type_id'],
            'image' => $row['image'], // Add image to the array
            'choices' => [],
        ];
        $totalQuestions++; // Increment total questions
    }

    if ($row['choice_text']) {
        $questions[$exam_question_id]['choices'][] = $row['choice_text'];
    }

    $currentQuestionID = $exam_question_id;
}

// Display questions, choices, and images
foreach ($questions as $exam_question_id => $questionData) {
    ?>
    <div class='question-container mb-4' id='question-<?php echo $exam_question_id ?>'>
        <p>Question <?php echo $questionNumber ?> of <?php echo $totalQuestions ?></p>
        <div class='card'>
            <div class='card-body text-center'>
                <h5 class='card-title'><?php echo $questionData['question_text'] ?></h5>
                <?php if (!empty($questionData['image'])) { ?>
            
            <img src='<?php echo $questionData['image'] ?>' alt='Question Image' style='max-width: 50%; height: 300px; width: auto; margin: auto; display: block;'>
           
           <?php } ?>
            </div>
        </div>

   

        <?php
if ($questionData['question_type_id'] == 1 || $questionData['question_type_id'] == 2) { // Multiple Choice or True/False
    ?>
    <!-- <div class='card d-flex align-items-stretch'>
        <div class='card-body row justify-content-center choices text-center mb-5 mt-5'>
            <?php foreach ($questionData['choices'] as $choice) { ?>
                <div class="col-md-4 mb-3"> 
                    <label class="custom-radio d-flex flex-fill">
                        <input type="radio" name="question_<?php echo $exam_question_id ?>" value="<?php echo $choice ?>">
                        <span class="choice-box flex-fill"><?php echo $choice ?></span>
                    </label>
                </div>
            <?php } ?>
                </div>
            </div> -->

            <div class='card d-flex align-items-stretch'>
    <div class='card-body row justify-content-center choices text-center mb-5 mt-5'>
        <?php 
        $numChoices = count($questionData['choices']);
        $columns = ($numChoices == 6) ? 3 : 2; // Set 3 columns if there are 6 choices, otherwise use 2 columns
        $columnWidth = 12 / $columns; // Calculate column width

        foreach ($questionData['choices'] as $choice) { 
        ?>
            <div class="col-md-<?php echo $columnWidth; ?> mb-3">
                <label class="custom-radio d-flex flex-fill">
                    <input type="radio" name="question_<?php echo $exam_question_id ?>" value="<?php echo $choice ?>">
                    <span class="choice-box flex-fill"><?php echo $choice ?></span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>
            <?php
        } elseif ($questionData['question_type_id'] == 3) { // Identification
            ?>
            <div class='card'>
                <div class='card-body choices text-center'>
                    <input type='text' class="form-control" style="color: black;" name='question_<?php echo $exam_question_id ?>' placeholder='Your answer'>
                </div>
            </div>
            <?php
        }

        echo "</div>"; // Close question-container
        $questionNumber++;
    }
?>
</div>

                <!-- Next and Previous Buttons -->
                

                        </form> <!-- Close the form element -->
                        <!-- Question Number List -->
                        <div id="question-number-list">
    <button id="prev-page" type="button" class="btn btn-secondary" onclick="showPrevPage()"><</button>

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

    <button id="next-page" type="button" class="btn btn-secondary" onclick="showNextPage()">></button>

    <button id="prev-button" type="button" class="btn btn-success ml-2 mr-2" onclick="showPrevQuestion()">Previous </button>
    <button id="next-button" type="button" class="btn btn-success" onclick="showNextQuestion()">Next</button>
    <button type="submit" name="submit_exam" id="exam_submit" class="btn btn-success" style = "display: none;">Submit</button>
    <button type="button" name="submit_exam" id="submit_button" class="btn btn-success">Submit</button>
    </br>
    <button type="button" name="forcecomplete" onclick="forcecomplete()" class="btn btn-success">Complete</button>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    var currentPage = 1;
    var totalPages = <?php echo $totalPages; ?>;

    function forcecomplete{

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
                
                startexamTimer(5);

            }
        });
    }


    function showPrevPage() {
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
        }
    }

    function showNextPage() {
        if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
        }
    }

    function showPage(page) {
        var questionPages = document.querySelectorAll('.question-page');
        questionPages.forEach(function (pageElement) {
            pageElement.style.display = 'none';
        });

        var currentPageElement = document.querySelector('.question-page[data-page="' + page + '"]');
        if (currentPageElement) {
            currentPageElement.style.display = 'block';
        }
    }
</script>


<!-- JavaScript for Step-by-Step Display -->
<script>
    var currentQuestion = 1;
    var questionContainers = document.querySelectorAll(".question-container");
    var questionNumbers = document.querySelectorAll(".btns"); // Update the class name here
    var submitButton = document.getElementById("submit_button"); // Assuming your submit button has the id "submit_button"
    var nextButton = document.getElementById("next-button"); // Assuming your "Next" button has the id "next-button"

    function showQuestion(questionId) {
        questionContainers.forEach((container, index) => {
            if (index + 1 === questionId) {
                container.style.display = "block";
            } else {
                container.style.display = "none";
            }
        });
    }

    // Add click event listeners to question numbers
    questionNumbers.forEach((number) => {
        number.addEventListener("click", () => {
            const questionId = parseInt(number.getAttribute("data-question-id"), 10);
            showQuestion(questionId);
            currentQuestion = questionId;

            // Toggle the "clicked" class for styling
            questionNumbers.forEach((btn) => {
                btn.classList.remove("clicked");
            });
            number.classList.add("clicked");

            // Adjust the display of "Next" and "Submit" buttons
            if (currentQuestion === questionContainers.length) {
                nextButton.style.display = "none";
                submitButton.style.display = "inline";
            } else {
                nextButton.style.display = "inline";
                submitButton.style.display = "none";
            }
        });
    });

    // Initially hide all questions except the first one
    questionContainers.forEach((container, index) => {
        if (index !== 0) {
            container.style.display = "none";
        }
    });

    // Function to show the next question
    function showNextQuestion() {
        if (currentQuestion < questionContainers.length) {
            showQuestion(currentQuestion + 1);
            currentQuestion++;
            questionNumbers.forEach((btn) => {
                btn.classList.remove("clicked");
            });
            questionNumbers[currentQuestion - 1].classList.add("clicked");

            // Adjust the display of "Next" and "Submit" buttons
            if (currentQuestion === questionContainers.length) {
                nextButton.style.display = "none";
                submitButton.style.display = "inline";
            } else {
                nextButton.style.display = "inline";
                submitButton.style.display = "none";
            }
        }
    }

    // Function to show the previous question
    function showPrevQuestion() {
        if (currentQuestion > 1) {
            showQuestion(currentQuestion - 1);
            currentQuestion--;
            questionNumbers.forEach((btn) => {
                btn.classList.remove("clicked");
            });
            questionNumbers[currentQuestion - 1].classList.add("clicked");

            // Adjust the display of "Next" and "Submit" buttons
            nextButton.style.display = "inline";
            submitButton.style.display = "none";
        }
    }
    
    // Initially hide the submit button
    submitButton.style.display = "none";
</script>
 
  
        </div>
    </div>

                <!-- End Content Row -->


        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
    <?php
include('includes/scripts.php');

?>

</div>



</div>

<script>
    function startexamTimer(examTime) {
        var countdownElement = document.getElementById("countdown");
        var formElement = document.getElementById("exam-form"); // Ensure this matches your form ID
        var submitButton = document.getElementById("exam_submit");

        function updateTimer(timeRemaining) {
            var minutes = Math.floor((timeRemaining / 1000 / 60) % 60);
            var seconds = Math.floor((timeRemaining / 1000) % 60);

            countdownElement.textContent = minutes + "m " + seconds + "s";

            if (timeRemaining <= 0) {
                countdownElement.textContent = "Time's up!";
                formElement.submit(); // Use form submission instead of button click
                sessionStorage.removeItem("examStartTime");
                return;
            }
        }

        var startTime = sessionStorage.getItem("examStartTime");

        if (!startTime) {
            startTime = new Date().getTime();
            sessionStorage.setItem("examStartTime", startTime);
        }

        var currentTime = new Date().getTime();
        var elapsedTime = currentTime - startTime;
        var timeRemaining = examTime * 1000 - elapsedTime;

        if (timeRemaining <= 0) {
            countdownElement.textContent = "Time's up!";
            formElement.submit();
            sessionStorage.removeItem("examStartTime");
            return;
        }

        updateTimer(timeRemaining);

        var timerInterval = setInterval(function () {
            var currentTime = new Date().getTime();
            var elapsedTime = currentTime - startTime;
            var timeRemaining = examTime * 1000 - elapsedTime;

            updateTimer(timeRemaining);

            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
            }
        }, 1000);

        // Add event listener for form submission
        formElement.addEventListener("submit", function (event) {
            // Additional actions before or after form submission can be added here if needed.
            sessionStorage.removeItem("examStartTime");
        });
    }

    var examTime = <?php echo json_encode($exam_time); ?>;

    window.onload = function () {
        startexamTimer(examTime);
    };
</script>

</body>


    