<?php 
include('student_session.php');
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('dbcon.php');
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
                    <!--
                    <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                        <h1 class="h3 mb-0 text-gray-800">Classes</h1>
                        <div class="d-sm-flex" style="margin-left: 1200px;">
                            <a href="../landingpage/reenrollment.php?id=<?php echo urlencode($row['student_id']); ?>" class="btn btn-secondary">Enroll</a>
                        </div>
                    </div>
                    -->
                  <!-- Topbar Search 
                  <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn primarybtn-new" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>-->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) 
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            Dropdown - Messages 
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>-->

<?php
// Initialize $row to an empty array to avoid undefined variable error
$row = [];

// Assuming you have established a database connection already (e.g., $conn)

// Get the student_id from the session
$student_id = $_SESSION['student_id'];

// Use prepared statements to fetch teacher information
$stmt = $conn->prepare("SELECT * FROM student WHERE student_id = ?");
$stmt->bind_param("s", $student_id);
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
                        

                        <!-- Nav Item - User Information -->
                        <!-- <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="<?php echo $imageLocation; ?>" alt="Teacher Image">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?php echo $row['firstname']." ".$row['lastname'];  ?></span>

                          
                            </a>
                            
                        </li> -->

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <?php
								$school_year_query = mysqli_query($conn,"select * from school_year order by school_year DESC")or die(mysqli_error());
								$school_year_query_row = mysqli_fetch_array($school_year_query);
								$school_year = $school_year_query_row['school_year'];
								?>

<?php
// Include the session code from session.php
// Initialize $count to 0
$count = 0;

// Assuming you have established a database connection already (e.g., $conn)

// Get the student_id from the session
$student_id = $_SESSION['student_id'];

// The existing SQL query to fetch teacher_class information
$query = mysqli_query($conn, "SELECT * FROM teacher_class_student
    LEFT JOIN teacher_class ON teacher_class.teacher_class_id = teacher_class_student.teacher_class_id
    LEFT JOIN class ON class.class_id = teacher_class.class_id AND class.status = 1
    LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
    LEFT JOIN teacher ON teacher.teacher_id = teacher_class.teacher_id
    WHERE student_id = '$student_id' AND class.class_id IS NOT NULL") or die(mysqli_error());

$count = mysqli_num_rows($query);
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">

</div>

<!-- Content Row -->
<div class="row">
    <?php
    if ($count > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $id = $row['teacher_class_id'];
    ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="class_home.php<?php echo '?id=' . $id; ?>"> <!-- Add this anchor element -->
                    <div class="card border-left-sector shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xl font-weight-bold text-primary text-uppercase mb-2">
                                        <?php echo $row['subject_code'] . " " . $row['subject_title']; ?>
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $row['class_name']; ?> </div>
                                </div>
                                <div class="col-auto">
                                    <img src="img/gmlogo1.png" class="circle" alt="" width="100" height="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </a> <!-- Close the anchor element -->
            </div>
    <?php
        }
    } else {
    ?>
        <div class="alert alert-info"><i class="icon-info-sign"></i> You are currently not enrolled in any class</div>
    <?php
    }
    ?>
</div>



                    </div>                       

                    <!-- Content Row -->

                </div>
                <!-- /.container-fluid -->

                <?php
include('includes/scripts.php');
include('includes/footer.php');
?>

            </div>
            <!-- End of Main Content -->





    