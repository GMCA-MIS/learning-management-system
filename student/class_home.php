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

    .custom-image-size {
        width: 120px;
        /* Adjust the width to your desired size */
        height: 120px;
        /* Automatically adjust the height based on the width */

    }

    .hover-image img {
        transition: transform 0.3s ease;
    }

    .hover-image:hover img {
        transform: scale(1.1);
    }
</style>
<!-- breadcrumb -->
<?php $class_query = mysqli_query($conn, "select * from teacher_class
    LEFT JOIN class ON class.class_id = teacher_class.class_id
    LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
    where teacher_class_id = '$get_id'") or die(mysqli_error());
$class_row = mysqli_fetch_array($class_query);

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
                <h3 class="h4 mb-0 text-gray-800">
                    <span style="font-weight: lighter;">
                        <?php echo $class_row['class_name']; ?>
                        <?php echo $class_row['subject_title']; ?>
                    </span> > Home
                </h3>
            </div>
        </nav>
        <!-- End of Topbar -->

        <!-- Content Row -->
        <!-- Define functions to retrieve assignments, quizzes, and exams deadlines -->
        <div class="container mt-4">
    <div class="row">
        <!-- Notifications Column -->
        <div class="col-md-6">
                    <div class="custom-container">
                        <h4>Notifications</h4>
                        <?php
                        // Query to retrieve notifications with necessary joins
                        $query = "SELECT n.notification, n.date_of_notification, n.link, te.location, CONCAT(te.firstname, ' ', te.lastname) AS teacher_name
                          FROM notification n
                          JOIN teacher_class tc ON n.teacher_class_id = tc.teacher_class_id
                          JOIN teacher te ON tc.teacher_id = te.teacher_id
                          WHERE tc.teacher_class_id = '$get_id'
                          ORDER BY n.date_of_notification DESC";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) === 0) {
                            echo '<div class="alert alert-warning">Nothing to see here yet.</div>';
                        } else {
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<div class="card mb-3">'; // Start of the card
                                echo '<div class="card-body">';
                                echo '<div class="notifi-item">'; // Start of the notifi-item
                                echo '<img src="' . $row['location'] . '" alt="img">'; // Image location from teacher table
                                echo '<div class="text">';
                                echo '<h4>' . $row['teacher_name'] . ' - ' . $row['notification'] . '</h4>';
                                echo '<p>Date: ' . $row['date_of_notification'] . '</p>';
                                echo '<a href="' . $row['link'] . '?id=' . $get_id . '" class="btn btn-success">View</a>';
                                echo '</div>';
                                echo '</div>'; // End of the notifi-item
                                echo '</div>';
                                echo '</div>'; // End of the card
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Upcoming Deadlines Column -->
                <div class="col-md-6">
                    <div class="custom-container">
                        <!-- Define functions to retrieve assignments, quizzes, and exams deadlines -->
                        <?php
                        function getAssignmentsDeadlines($conn, $get_id)
                        {
                            $query = "SELECT * FROM assignment WHERE class_id = '$get_id' AND deadline >= CURDATE() ORDER BY deadline ASC";
                            $result = mysqli_query($conn, $query);
                            return mysqli_fetch_all($result, MYSQLI_ASSOC);
                        }

                        function getQuizzesDeadlines($conn, $get_id)
                        {
                            $query = "SELECT * FROM class_quiz WHERE teacher_class_id = '$get_id' AND deadline >= CURDATE() ORDER BY deadline ASC";
                            $result = mysqli_query($conn, $query);
                            return mysqli_fetch_all($result, MYSQLI_ASSOC);
                        }

                        function getExamsDeadlines($conn, $get_id)
                        {
                            $query = "SELECT * FROM class_exam WHERE teacher_class_id = '$get_id' AND deadline >= CURDATE() ORDER BY deadline ASC";
                            $result = mysqli_query($conn, $query);
                            return mysqli_fetch_all($result, MYSQLI_ASSOC);
                        }

                        // Retrieve deadlines
                        $assignments = getAssignmentsDeadlines($conn, $get_id);
                        $quizzes = getQuizzesDeadlines($conn, $get_id);
                        $exams = getExamsDeadlines($conn, $get_id);
                        ?>

                        <!-- Display the To Do List -->
                        <div class="row">
                    <div class="col">
                                <div class="card custom-container">
                                    <div class="card-body">
                                        <h4 class="card-title">Upcoming</h4>
                                        <!-- Display Upcoming Deadlines -->
                                        <ul class="list-group list-group-flush">
                                            <?php
                                            // Display Assignments
                                            foreach ($assignments as $assignment) {
                                                $deadline = date('F j, Y \a\t g:i a', strtotime($assignment['deadline']));
                                                echo "<li class='list-group-item'>";
                                                echo "<div class='row'>";
                                                echo "<div class='col'>";
                                                echo "{$assignment['fname']}";
                                                echo "</div>";
                                                echo "</div>";
                                                echo "<div class='row'>";
                                                echo "<div class='col'>";
                                                echo "<small class='text-muted'>Due: {$deadline}</small>";
                                                echo "</div>";
                                                echo "</div>";
                                                echo "</li>";
                                            }
                                            
                                            // Display Quizzes
                                            foreach ($quizzes as $quiz) {
                                                $deadline = date('F j, Y \a\t g:i a', strtotime($quiz['deadline']));
                                                echo "<li class='list-group-item'>";
                                                echo "<div class='row'>";
                                                echo "<div class='col'>";
                                                echo "{$quiz['quiz_id']}";
                                                echo "</div>";
                                                echo "</div>";
                                                echo "<div class='row'>";
                                                echo "<div class='col'>";
                                                echo "<small class='text-muted'>Deadline: {$deadline}</small>";
                                                echo "</div>";
                                                echo "</div>";
                                                echo "</li>";
                                            }
                                            
                                            // Display Exams
                                            foreach ($exams as $exam) {
                                                $deadline = date('F j, Y \a\t g:i a', strtotime($exam['deadline']));
                                                echo "<li class='list-group-item'>";
                                                echo "<div class='row'>";
                                                echo "<div class='col'>";
                                                echo "{$exam['exam_id']}";
                                                echo "</div>";
                                                echo "</div>";
                                                echo "<div class='row'>";
                                                echo "<div class='col'>";
                                                echo "<small class='text-muted'>Deadline: {$deadline}</small>";
                                                echo "</div>";
                                                echo "</div>";
                                                echo "</li>";
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- Content Row -->
</div>
</div>
</div>