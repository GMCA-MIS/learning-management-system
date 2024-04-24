<?php 
include('student_session.php');  ?>
<?php $get_id = $_GET['id']; ?>
<?php
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
include('dbcon.php');
include('initialize.php');
?>

       	 <!-- breadcrumb -->
	<?php $class_query = mysqli_query($conn,"select * from teacher_class
	LEFT JOIN class ON class.class_id = teacher_class.class_id
	LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
	where teacher_class_id = '$get_id'")or die(mysqli_error());
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                    <h3 class="h4 mb-0 text-gray-800">
                        <span style="font-weight: lighter;"><?php echo $class_row['class_name']; ?> <?php echo $class_row['subject_title']; ?></span> > Performance Task
                    </h3>

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

                        <!-- Nav Item - User Information -->
                        <!-- <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Welcome, <?php echo $row['firstname']." ".$row['lastname'];  ?></span>
                                <img class="img-profile rounded-circle" src="img/icons8-male-user-50.png">
                            </a>
                            
                        </li> -->

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <td>
                   
        
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        
                    </div>

                  

</head>
<body>
                <!-- Content Row -->
                <div class="row">
                    <div class="container mt-4">
                        <!-- Custom Container with Title -->
                        <div class="custom-container">
                            <div class="header mt-4" style ="backround: white;">
                                <h5 class="display-6">Performance Task List</h5>
                            </div>
                            <hr>
                            <?php

                            // Query to retrieve assignments
                           // $query = "SELECT * FROM assignment WHERE class_id = '$get_id' AND status = 'Available' AND type = '1' ORDER BY fdatein DESC";
                           
                           $query = "SELECT * FROM task WHERE teacher_class_id = $get_id AND status = 'Available'  ORDER BY date_added DESC";

                           $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) === 0) {
                                echo '<center> <div class="alert alert-warning text-center">There are no assignments yet.</div></center>';
                            } else {
                                while ($row = mysqli_fetch_array($result)) {
                                    $id = $row['task_id'];
                                    //$floc = $row['floc'];

                                    // Format the deadline
                                    $deadline = date("l, F d, Y  h:i A", strtotime($row['deadline']));
                                    ?>
                                    <!-- Assignment Card -->
                                    <a href="view_class_performancetask.php?id=<?php echo $get_id ?>&task_id=<?php echo $id ?>">
                                        <div class="card mt-3 position-relative">
                                            <div class="card-body">

                                            <h6 class="card-title" style="">
                                                 <div class="d-flex flex-row-reverse">
                                                    <?php 
                                                        $rowquery = " SELECT `status`,task_result_id FROM task_result WHERE task_result_id = $id AND student_id = $student_id ";
                                                        $rowresult = mysqli_query($conn, $rowquery);
                                                        $rowstats = mysqli_fetch_array($rowresult);
                                                        if(empty($rowstats['status'])){

                                                            if(empty($rowstats['student_assignment_id'])){
                                                                echo" <div class='p-2 border border-danger' style='color:red'>";
                                                                echo "Take Assignment" ;
                                                                echo "</div>";
                                                            }else{
                                                                echo" <div class='p-2 border border-warning' style='color:#D4AF37'>";
                                                                echo "Pending" ;
                                                                echo "</div>";
                                                            }

                                                        }elseif($rowstats['status'] == "1"){

                                                            echo" <div class='p-2 border border-success' style='color:green'>";
                                                            echo "Completed" ;
                                                            echo "</div>";
                                                        }
                                                    
                                                    ?>
                                                
                                                </div>
                                            </h6>

                                                <h6 class="card-title"><?php echo $row['task_title']; ?></h6>
                                                <p class="card-text rem"><strong>Due:</strong> <?php echo $deadline; ?></p>
                                            </div>
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
                                    <!-- /.container-fluid -->

                                </div>
                                <!-- End of Main Content -->



<?php
include('includes/scripts.php');
include('includes/footer.php');
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
    text-decoration: none; /* Remove underline on hover */
    color: inherit; /* Inherit the text color from the parent element */
  }
  a {
    text-decoration: none; /* Remove underline */
    color: gray; /* Set the text color to black */
  }
</style>