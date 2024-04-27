<?php
include('teacher_session.php');
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('dbcon.php');
?>

<?php $get_id = $_GET['quiz_id']; // Get the quiz_id from the URL ?>

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
// SQL query to fetch data from the quiz table
$sql = "SELECT * FROM quiz WHERE quiz_id = $get_id AND teacher_id = '$teacher_id'";

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
            <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                <h1 class="h3 mb-0 text-gray-800">Quiz Info: <?php echo $quiztitle ?></h1>
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

            <!-- Content Row -->
            <div class="card-body">

<div class="table-responsive">
<a href="quiz.php" class="btn btn-success">Back</a><br><br>

<td>
        <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_questionModal"><i class="fa fa-plus" aria-hidden="true"></i> Add Question</button>
</td>

<div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
    <h1 class="h5 mb-0 text-gray-800">Question List</h1>
</div>
<?php
// SQL query to fetch data from the quiz table
$query = "SELECT quiz_question.*, question_type.* 
          FROM quiz_question
          JOIN question_type ON quiz_question.question_type_id = question_type.question_type_id
          WHERE quiz_question.quiz_id = '$get_id'
          ORDER BY quiz_question.date_added DESC";

$query_run=mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {

    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

<table style = "color: black;" id = "dataTableID" class="table table-bordered table table-striped" width = "100%" cellspacing="0">
<thead>
<tr>
    <th style="display:none;">Course ID</th>
    <th>Question</th>
    <th>Type</th>
    <th>Points</th>
    <th>Correct Answer</th>
    <th>Delete</th>                             
</tr>
</thead>
<tbody>
<?php
    if(mysqli_num_rows($query_run) > 0) {
        while($row=mysqli_fetch_assoc($query_run))
        {
            ?>
<tr>
    <td style="display:none;"><?php echo $row['quiz_question_id']; ?></td>      
    <td><?php echo $row['question_text']; ?></td>
    <td><?php echo $row['question_type']; ?></td>
    <td><?php echo $row['points']; ?></td>
    <td><?php echo $row['answer']; ?></td>

    
                       

                        <td> 
                        </div>
                        <!--Delete Pop Up Modal -->
                        <div class="modal fade" id="delete_questionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <form action="quiz-function.php" method = "POST"> 


                                        <div class="modal-body">
                                        
                                                <input type="hidden" name= "delete_ID" id ="delete_ID">
                                                <input type="hidden" name= "quiz_id" id ="quiz_id" value = "<?php echo $get_id; ?>">

                                            <h5>Do you want to delete this data?</h5>
                                        </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                                                <button type="submit" name="delete_quiz_question" class="btn btn-danger">Confirm</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  
                            <button type ="submit" name = "delete_btn" class = "btn btn-danger delete_btn">Delete</button>
                        </td>
</tr>
<?php
        }
    }
    else 
    {
        echo "No Questions yet";
    }
    ?>

</div>
</tbody>
</table>
</div>
</div>

                    <!-- Add Quiz Pop Up Modal  -->
                    <div class="modal fade" id="add_questionModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Question</h5>
                                </div>
                            
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="question_type">Question Type</label>
                                    <select name="question_type" id="questionTypeSelect" class="form-control" required>
                                        <option value="" disabled selected>Select Question Type</option>
                                        <?php
                                        $query = mysqli_query($conn, "SELECT question_type FROM question_type ORDER BY question_type ASC");

                                        if ($query && mysqli_num_rows($query) > 0) {
                                            while ($row = mysqli_fetch_array($query)) {
                                                $question_type = $row["question_type"];
                                                echo '<option value="' . $question_type . '">' . $question_type . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                            <!-- Identification question type -->
                            <div id="identificationQuestion" style="display: none;">
                            <form action="quiz-function.php" method="POST"  enctype="multipart/form-data">
                                <input type="hidden" name="quiz_id" value="<?php echo $get_id; ?>">
                                <input type="hidden" name="question_type" value="Identification">
                                <div class="form-group">
                                    <label for="question">Question</label>
                                    <textarea class="form-control" id="description" name="question_identification" required> </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="identificationAnswer">Correct Answer</label>
                                    <input type="text" class="form-control" id="identificationAnswer" name="identificationAnswer" required>
                                </div>
                                <div class="form-group">
                                    <label for="points">Point(s)</label>
                                    <input type="number" class="form-control" name="points" min="1" required>
                                </div>
                                <div class="form-group">
                                    <label for="photo_upload">Upload Photo (optional)</label>
                                    <input type="file" class="form-control" name="photo_upload" accept="image/*" >
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="submit" name="save_question" class="btn btn-success">Save Question</button>
                                </div>
                            </form>
                            </div> <!-- End Identification -->

                            <!-- True or False question type -->
                            <div id="trueFalseQuestion" style="display: none;">
                            <form action="quiz-function.php" method="POST"  enctype="multipart/form-data">
                                <input type="hidden" name="quiz_id" value="<?php echo $get_id; ?>">
                                <input type="hidden" name="question_type" value="True or False">
                                <div class="form-group">
                                    <label for "question">Question</label>
                                    <textarea class="form-control" id="description1" name="question_true_false" required> </textarea>
                                </div>
                                <h6> Correct Answer </h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="trueFalseAnswer" value="True" required>
                                    <label class="form-check-label">True</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="trueFalseAnswer" value="False" required>
                                    <label class="form-check-label">False</label>
                                </div>

                                <div class="form-group">
                                    <label for="points">Point(s)</label>
                                    <input type="number" class="form-control" name="points" min="1" required>
                                </div>

                                <div class="form-group">
                                    <label for="photo_upload">Upload Photo (optional)</label>
                                    <input type="file" class="form-control" name="photo_upload" accept="image/*" >
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="submit" name="save_question" class="btn btn-success">Save Question</button>
                                </div>
                            </form>
                            </div> <!-- End True or False -->

                            <!-- Multiple Choice question type -->
                            <div id="multipleChoiceQuestion" style="display: none;">
                                <form action="quiz-function.php" method="POST"  enctype="multipart/form-data">
                                    <input type="hidden" name="quiz_id" value="<?php echo $get_id; ?>">
                                    <input type="hidden" name="question_type" value="Multiple Choice">
                                    <div class="form-group">
                                        <label for="question">Question</label>
                                        <input type="text" class="form-control" id="description1" name="question_multiple_choice" required>
                                    </div>

                                    <!-- Create a container for the choices -->
                                    <div id="choices-container">
                                        <div class="form-group">
                                            <label for="choice1">Choice 1</label>
                                            <textarea class="form-control" name="choice1" required> </textarea>
                                        </div>
                                    </div>

                                    <!-- Add Choice button -->
                                    <button type="button" class="btn btn-primary" id="add-choice">Add Choice</button>

                                    <div class="form-group">
                                        <label for="multipleChoiceAnswer">Correct Answer</label>
                                        <select name="multipleChoiceAnswer" class="form-control" required>
                                            <option value="choice1">Choice 1</option>
                                            <!-- You can dynamically add options for choices using JavaScript -->
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="points">Point(s)</label>
                                        <input type="number" class="form-control" name="points" min="1" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="photo_upload">Upload Photo (optional)</label>
                                        <input type="file" class="form-control" name="photo_upload" accept="image/*" >
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" name="save_question" class="btn btn-success">Save Question</button>
                                    </div>
                                </form>
                            </div>
                            <!-- End Multiple Choice -->

                        </div> <!-- Modal body -->
                </div> <!-- Modal content -->
            </div> <!-- Modal dialog -->
        </div> <!-- Modal -->


<script>
// JavaScript to show/hide question type specific fields
document.getElementById('questionTypeSelect').addEventListener('change', function () {
    var selectedQuestionType = this.value;
    var trueFalseQuestion = document.getElementById('trueFalseQuestion');
    var multipleChoiceQuestion = document.getElementById('multipleChoiceQuestion');
    var identificationQuestion = document.getElementById('identificationQuestion');

    if (selectedQuestionType === 'True or False') {
        trueFalseQuestion.style.display = 'block';
        multipleChoiceQuestion.style.display = 'none';
        identificationQuestion.style.display = 'none';
    } else if (selectedQuestionType === 'Multiple Choice') {
        trueFalseQuestion.style.display = 'none';
        multipleChoiceQuestion.style.display = 'block';
        identificationQuestion.style.display = 'none';
    } else if (selectedQuestionType === 'Identification') {
        trueFalseQuestion.style.display = 'none';
        multipleChoiceQuestion.style.display = 'none';
        identificationQuestion.style.display = 'block';
    } else {
        trueFalseQuestion.style.display = 'none';
        multipleChoiceQuestion.style.display = 'none';
        identificationQuestion.style.display = 'none';
        
    }
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        var choiceCount = 2; // Starting count of choices

        // Function to add a choice field
        $("#add-choice").click(function () {
            var newChoiceField = '<div class="form-group"><label for="choice' + choiceCount + '">Choice ' + choiceCount + '</label><input type="text" class="form-control" name="choice' + choiceCount + '" required></div>';
            $("#choices-container").append(newChoiceField);

            // Update the "Correct Answer" select options
            var newOption = '<option value="choice' + choiceCount + '">Choice ' + choiceCount + '</option>';
            $("select[name='multipleChoiceAnswer']").append(newOption);

            choiceCount++; // Increment the choice count
        });
    });
</script>

                    <!-- Content Row -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


<?php
include('includes/scripts.php');
include('includes/footer.php');
?>



    