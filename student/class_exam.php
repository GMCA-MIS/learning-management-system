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
    .card-title {
        color: black;
    }
</style>

<!-- breadcrumb -->
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
            <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                <h3 class="h4 mb-0 text-gray-800">
                    <span style="font-weight: lighter;"><?php echo $class_row['class_name']; ?></span> > Exam
                </h3>
            </div>

        </nav>     <!-- Topbar Navbar -->
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Content Row -->
            <div class="row">
                <div class="container mt-4">
                    <!-- Custom Container with Title -->
                    <div class="custom-container">
                        <h5>Exam List</h5>
                        <hr>
                        <?php
                        // Query to retrieve exams
                        $query = "SELECT cq.*, q.exam_description, q.exam_title, q.date_added 
                        FROM class_exam AS cq
                        JOIN exam AS q ON cq.exam_id = q.exam_id
                        WHERE cq.teacher_class_id = '$get_id' AND cq.stats = '0'";
                        $result = mysqli_query($conn, $query);
              

                        if (mysqli_num_rows($result) === 0) {
                            echo '<center> <div class="alert alert-warning">You have not posted an exam yet.</div></center>';
                        } else {
                            while ($row = mysqli_fetch_array($result)) {
                                $exam_id = $row['exam_id'];
                                $date_added = $row['date_added'];
                                $exam_title = $row['exam_title'];
                                $exam_description = $row['exam_description'];
                                $class_exam_id = $row['class_exam_id'];
                                $exam_time = $row['exam_time'];
                                $deadline = $row['deadline'];
                        ?>
                                <!-- exam Card -->
                                <a href="exam_content.php?exam_id=<?php echo $exam_id; ?>&id=<?php echo $get_id;?>" class="card mt-2">
                                    <div class="card-body">
                                        
                                    <h6 class="card-title" style="">
                                            <div class="d-flex flex-row-reverse">
                                                    <?php 
                                                        $rowquery = " SELECT taken FROM student_class_exam WHERE exam_id = $exam_id AND student_id = $student_id ";
                                                        $rowresult = mysqli_query($conn, $rowquery);
                                                        $rowstats = mysqli_fetch_array($rowresult);
                                                        if(empty($rowstats['taken'])){

                                                            echo" <div class='p-2 border border-danger' style='color:red'>";
                                                            echo "Take Exam" ;
                                                            echo "</div>";

                                                            }elseif($rowstats['taken'] == "yes"){

                                                            echo" <div class='p-2 border border-success' style='color:green'>";
                                                            echo "Completed" ;
                                                            echo "</div>";
                                                        }
                                                    
                                                    ?>
                                                
                                            </div>
                                        </h6>
                                        <h6 class="card-title"><?php echo $exam_title; ?></h6>
                                        <h6 class="card-title"><?php echo $exam_description; ?></h6>
                                        <p class="card-text rem"><strong>Posted:</strong> <?php echo date('F j, Y \a\t g:i A', strtotime($date_added)); ?></p>
                                        <p class="card-text rem"><strong>Deadline:</strong> <?php echo date('F j, Y \a\t g:i A', strtotime($deadline)); ?></p>
                                    </div>
                                </a>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- Content Row -->
        </div>
        
    </div>
    <!-- End of Main Content -->

<?php
} else {
    echo '<script>window.location.href = "../deny.php?reason=access_denied";</script>';
    exit;
}
?>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Content Wrapper -->


<style>
    .custom-container {
        border: 1px solid #ccc;
        padding: 20px;
        margin-top: 20px;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        color: black;
    }

    a:hover {
        text-decoration: none; 
        color: inherit; 
    }
    a {
        text-decoration: none; 
        color: gray;
    }
</style>
