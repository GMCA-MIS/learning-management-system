<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');

if (isset($_GET['student_id'])) {
    $class_id = $_GET['class_id'];
    $student_id = $_GET['student_id'];

    // Query to retrieve user data
    $query = "SELECT * FROM student WHERE student_id = $student_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Fetch user data
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            
        } else {
            echo "Student not Found.";
        }
    } else {
        echo "Error fetching user data: " . mysqli_error($conn);
    }

    // Query to retrieve user data
    $query = "SELECT * FROM class WHERE class_id = $class_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Fetch user data
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $class_name = $row['class_name'];
            
        } else {
            echo "Student not Found.";
        }
    } else {
        echo "Error fetching user data: " . mysqli_error($conn);
    }





} else {
    echo "User ID not provided.";
}
?>


<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow newtopbar" style="margin-bottom:0;">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mt-2" style="margin-top: 36px; margin-left: 10px;">
                <h1 class="h3 mb-0 text-gray-800">Subjects Grades under Class : <?php echo $class_name?></h1>
            </div>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Nav Item - User Information -->
                <?php include('includes/admin_name.php'); ?>
            </ul>
        </nav>
        <!-- End of Topbar -->

        <div class="d-sm-flex align-items-center justify-content-between" style="margin-top: 20px; margin-left: 10px;">
            <h1 class="h5 mb-0 text-gray-800 ml-4"><?php echo " NAME : ".  $firstname . " " . $lastname; ?></h1>
        </div>

        <?php
        // Displaying data into tables with class_name
  

        $query = " SELECT * FROM student_grade sg 
                    INNER JOIN teacher_class tc ON sg.teacher_class_id =  tc.teacher_class_id
                    INNER JOIN `subject` s ON tc.subject_id = s.subject_id 
                    WHERE sg.student_id = $student_id and tc.class_id = $class_id ";

        $query_run = mysqli_query($conn, $query);
        ?>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTableID" class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Task Grade</th>
                        <th>Assignment Grade</th>
                        <th>Exam Grade</th>
                        <th>Quiz Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query_run) > 0) {
                        while ($row = mysqli_fetch_assoc($query_run)) {
                            ?>
                            <tr>
                                <td><?php   if(!empty($row['subject'])){ echo $row['subject'] ; }else{ echo "N.A" ; }  ?></td>
                                <td><?php echo $row['task_grade']; ?></td>
                                <td><?php echo $row['assignment_grade']; ?></td>
                                <td><?php echo $row['exam_grade']; ?></td>
                                <td><?php echo $row['quiz_grade']; ?></td>
                            </tr>
                        <?php
                        }
                    } else {
                        echo "No Record Found";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function doapprovedModal(id) {
        document.getElementById("approvedinputid").value = id;
    }
</script>

<?php
include('includes/scripts.php');
// include('includes/footer.php');
?>