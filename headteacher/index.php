<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
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

                        

                        <!-- Nav Item - User Information -->
                        <?php include ('includes/admin_name.php'); ?>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <?php
					$school_year_query = mysqli_query($conn,"select * from school_year order by school_year DESC")or die(mysqli_error());
					$school_year_query_row = mysqli_fetch_array($school_year_query);
					$school_year = $school_year_query_row['school_year'];
				?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                      <!-- Pop up filter -->
                      <div class="modal fade" id="exampleModalPop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        Filter Table:                            
                                        <select name="section" id="section">
                                            <option value="" disabled selected></option>
                                            <option value="Operations">Operations</option>
                                            <option value="Leadership and Planning">Leadership and Planning</option>
                                            <option value="Support">Support</option>
                                            <option value="Performance Evaluation">Pe   rformance Evaluation</option>
                                        </select>

                                        <select name="Type" id="Type">
                                            <option value="" disabled selected></option>
                                            <option value="Quality Manual">Quality Manual</option>
                                            <option value="Process Manual">Process Manual</option>
                                            <option value="Work Instruction Manual">Work Instruction Manual</option>
                                            <option value="Forms Manual">Forms Manual</option>
                                            <option value="Reference Manual">Reference Manual</option>
                                            <option value="Risk Register Manual">Risk Register Manual</option>
                                            <option value="Job Description Manual">Job Description Manual</option>
                                            
                                            

                                        </select>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none; background-color: inherit;">
                                    <i class="fa-solid fa-xmark" style="font-size: 20px;"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    

                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: maroon;">Close</button>
                                </div>
                                </div>
                            </div>
                        </div>
                         <!--End Pop up filter -->

                     

                        <!-- Total Students Card-->
                      <!--
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-sector shadow h-100 py-2">
                                <a href="manage-students.php">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Students</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $total_students_query = "SELECT COUNT(*) AS total_students FROM student";
                                                    $total_students_result = mysqli_query($conn, $total_students_query);

                                                    if(mysqli_num_rows($total_students_result) > 0){
                                                        while($row = mysqli_fetch_assoc($total_students_result)){
                                                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['total_students'].'</div>';
                                                        }
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fa fa-sitemap text-gray-300" aria-hidden="true" style="font-size:30px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                    </a> 
                                </div>
                            </div>
                                                -->
                            
                            <!-- Total Instructors Card -->
                            <!--
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-office shadow h-100 py-2">
                                <a href="manage-teachers.php">

                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Instructors</div>

                                                    <?php
                                                        $total_instructors_query = "SELECT COUNT(*) AS total_instructors FROM teacher";
                                                        $total_instructors_result = mysqli_query($conn, $total_instructors_query);

                                                        if(mysqli_num_rows($total_instructors_result) > 0){
                                                            while($row = mysqli_fetch_assoc($total_instructors_result)){
                                                                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['total_instructors'].'</div>';
                                                            }
                                                        }
                                                    ?>                                            
                                            </div>
                                            <div class="col-auto">
                                            <i class="fa fa-building text-gray-300" aria-hidden="true" style="font-size:30px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                     </a>
                                </div>
                            </div>
                                                    -->
                             <!-- Total Class Card -->
                             <!--
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card shadow h-100">
                                <a href="manage-all-class.php">

                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fa fa-building fa-3x"></i>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-uppercase text-muted small">Total Classes</div>
                                                <?php
                                                $total_class_query = "SELECT COUNT(*) AS total_class FROM class";
                                                $total_class_result = mysqli_query($conn, $total_class_query);

                                                if ($total_class_result && mysqli_num_rows($total_class_result) > 0) {
                                                    $row = mysqli_fetch_assoc($total_class_result);
                                                    $total_classes = $row['total_class'];

                                                    echo '
                                                        <div class="progress-circle">
                                                            <div class="progress-circle-number">' . $total_classes . '</div>
                                                        </div>
                                                    ';
                                                } else {
                                                    echo '<div class="text-danger">Error retrieving data</div>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                                            -->

                             <!-- Total Departments Card -->
                             <!--
                             <div class="col-xl-3 col-md-6 mb-4">

                                <div class="card shadow h-100">
                                    <a href="manage-departments.php">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fa fa-building fa-3x"></i>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-uppercase text-muted small">Total Departments</div>
                                                <?php
                                                $total_department_query = "SELECT COUNT(*) AS total_department FROM department";
                                                $total_department_result = mysqli_query($conn, $total_department_query);

                                                if ($total_department_result && mysqli_num_rows($total_department_result) > 0) {
                                                    $row = mysqli_fetch_assoc($total_department_result);
                                                    $total_departments = $row['total_department'];

                                                    echo '
                                                        <div class="progress-circle">
                                                            <div class="progress-circle-number">' . $total_departments . '</div>
                                                        </div>
                                                    ';
                                                } else {
                                                    echo '<div class="text-danger">Error retrieving data</div>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                                            -->
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



    