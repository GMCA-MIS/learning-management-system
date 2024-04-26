<?php 
include('student_session.php');  
?>
<?php $get_id = $_GET['id']; ?>
<?php
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
include('dbcon.php');
include('initialize.php');
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

    .moving-background {
        background-size: 200% auto;
        background-image: linear-gradient(to right, black, rgba(23, 24, 32, 0.95), rgba(64, 64, 64, 0.95));
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

    .card-body .quiz-button {
        margin-top: 20px;
        background-size: 200% auto;
        background-image: linear-gradient(to right, #fff, white);
        animation: gradientMovement 10s ease infinite;
        color: black;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        /* Change the background color to complement the gradient */
    
    }

    .card-body .quiz-button:hover {
        background-color: gray; /* Change the hover color to complement the gradient */
    }

    .clr {
        color:white;
    }
</style>


<?php
// SQL query to fetch data from the quiz table
$sql = "SELECT * FROM quiz WHERE quiz_id = $get_id";

// Execute the query
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Fetch the quiz_title and other data
        $quiztitle = $row['quiz_title'];
        $quiz_description = $row['quiz_description'];
        $quiz_description = $row['quiz_description'];
        $quiz_id = $row['quiz_id'];
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
                <h1 class="h3 mb-0 text-gray-800">Quiz: <?php echo $quiztitle ?></h1>
            </div>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Content Row -->
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <!-- Quiz Title -->
                    <div class="card">
                        <div class="card-body text-center">
                            <h2 class="card-title"><?php echo $quiztitle ?></h2>
                        </div>
                    </div>

                    <?php
// Assuming you have the student's ID and quiz's ID
// Query to fetch the "taken" status from the student_class_quiz table
$sql = "SELECT * FROM student_class_quiz WHERE student_id = $student_id AND quiz_id = $get_id";
$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $taken = $row['taken'];
        $grade = $row['grade'];
        $max_score = $row['max_score'];
    } else {
        // No records found, which means the quiz hasn't been taken yet
        $taken = 'no'; // You can set a default value
    }
} else {
    echo "Error querying the database.";
}

// Determine whether to show the "Take quiz" button or the grade
$showButton = ($taken === 'yes') ? false : true;
?>

<div class="card mt-3 moving-background h-100">
    <div class="card-body text-center clr">
        <p class="card-text mx-auto clr"><?php echo $quiz_description ?></p>
        <?php if ($showButton) { ?>
            <!-- If the quiz is not taken, show the "Take quiz" button -->
            <div><a href="take_quiz.php?quiz_id=<?php echo $get_id ?>" class="quiz-button">Take quiz</a></div>
        <?php } else { ?>
            <!-- If the quiz is already taken, show the grade from student_class_quiz -->
            <div class = "mt-4">
                <div class = "mt-4"style="font-size: 20px;">SCORE: <?php echo $grade ?> out of <?php echo $max_score ?></div>
                <div class = "mt-4"style="font-size: 20px;">
                    <?php 
                    if(empty($grade)){
                        $grade = 0;
                    }
                    echo round(($grade / $max_score) * 100, 2) 
                    ?>%


                </div>
                    <div class = "card-body">
                        <div><a href="view_quiz_result.php?quiz_id=<?php echo $get_id ?>&id=<?php echo $student_id?>" class="quiz-button">View Details</a></div>
                    </div>
            </div>
        <?php } ?>
    </div>
</div>





                </div>
            </div>
            <!-- End Content Row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
    <?php
include('includes/scripts.php');
include('includes/footer.php');
?>

</div>



</div>



    