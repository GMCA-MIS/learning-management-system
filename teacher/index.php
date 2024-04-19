<?php 
include('teacher_session.php');
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                        <h1 class="h3 mb-0 text-gray-800">Classes</h1>
                    </div>

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

                // Get the teacher_id from the session
                $teacher_id = $_SESSION['teacher_id'];

                // SQL query to fetch teacher class information
                $query = mysqli_query($conn, "SELECT * FROM teacher_class
                    LEFT JOIN class ON class.class_id = teacher_class.class_id
                    LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                    WHERE teacher_id = '$teacher_id' AND school_year = '$school_year'") or die(mysqli_error());

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
                $subjid = $row['subject_id'];
                $classid = $row['class_id']
        ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="class_members.php<?php echo '?id=' . $id . "&subjid=" .$subjid ."&classid=". $classid; ?>"> <!-- Add this anchor element -->
                                <div class="card border-left-sector shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-2">
                                                <?php echo $row['subject_code'] ." ". $row['subject_title']; ?>
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $row['class_name']; ?> </div>
                                            </div>
                                            <div class="col-auto">
                                            <img src="<?php echo $row['photo'] ?>" class="circle" alt="" width="100" height="100">
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
            <div class="alert alert-warning"><i class="icon-info-sign"></i> No Class Currently Assigned</div>
        <?php
        }
        ?>
                        <!-- Total Sectors Card -->


                            
                            <!-- Total Instructors Card
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-sector shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-2">
                                                Pagbasa at Pagsusuri ng Iba’t-Ibang Teksto Tungo sa Pananaliksik</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"> STEM 12-A
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fa fa-sitemap text-gray-300" aria-hidden="true" style="font-size:30px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                          Total Class Card 
                             <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-sector shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-2">
                                                General Math</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"> STEM 12-A
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fa fa-sitemap text-gray-300" aria-hidden="true" style="font-size:30px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                             Total Class Card 
                             <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-sector shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-2">
                                                Statistics and Probability</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"> STEM 12-A
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fa fa-sitemap text-gray-300" aria-hidden="true" style="font-size:30px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            Total Class Card 
                             <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-sector shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-2">
                                                Earth and Life Science</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"> STEM 12-A
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fa fa-sitemap text-gray-300" aria-hidden="true" style="font-size:30px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            Total Class Card 
                             <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-sector shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-2">
                                                Physical Science</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"> STEM 12-A
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fa fa-sitemap text-gray-300" aria-hidden="true" style="font-size:30px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
<style>
    /* Custom CSS for Circular Progress Indicator */
.progress-circle {
    width: 100px; /* Adjust the width as needed */
    height: 100px; /* Adjust the height as needed */
    border: 6px solid #f3f3f3; /* Circle border color */
    border-top: 6px solid blue; /* Progress color (green in this example) */
    border-radius: 50%;
    display: inline-block;
    text-align: center;
    line-height: 100px; /* Center the number vertically */
}

.progress-circle-number {
    font-size: 24px; /* Adjust the font size as needed */
    font-weight: bold;
    color: black; /* Number color (green in this example) */
}
    a:hover {
    text-decoration: none; /* Remove underline on hover (optional) */
    color: inherit; /* Inherit the default text color on hover */
    /* Add any other styles you want to remove or reset on hover */
}

    </style>


                    </div>                       

                    <!-- Content Row -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
            <script>
                $(document).ready(function(){
                    $("#section").on('change', function(){
                        var value = $(this).val();
                        $.ajax({
                            url:"filter.php",
                            type:"POST",
                            data:'request=' + value,
                            beforeSend:function(){
                                $(".modal-body").html("<span>Loading...</span>");
                            },
                            success:function(data){
                                $(".modal-body").html(data);
                            }
                        });
                    });
                });

                $(document).ready(function(){
                    $("#Type").on('change', function(){
                        var value = $(this).val();
                        $.ajax({
                            url:"filter.php",
                            type:"POST",
                            data:'requestType=' + value,
                            beforeSend:function(){
                                $(".modal-body").html("<span>Loading...</span>");
                            },
                            success:function(data){
                                $(".modal-body").html(data);
                            }
                        });
                    });
                });
            </script>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>



    