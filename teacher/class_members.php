<?php 
include('teacher_session.php');  ?>
<?php $get_id = $_GET['id']?>
<?php
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
include('dbcon.php');
include('initialize.php');

if(isset($_GET['addstudent'])){



    $querys3 = mysqli_query($conn, "SELECT * FROM teacher_class WHERE teacher_class_id = ". $get_id);
    $rows3 = mysqli_fetch_array($querys3);


    
    $teacher_id = $_SESSION['teacher_id'];
    $student_id1 = $_GET['studentid'];
    $teacher_class_id =  $get_id;    
    $idclaz =  $rows3['class_id'];
    $subjid =  $rows3['subject_id'];



    

    
   $sql= "INSERT INTO teacher_class_student (teacher_class_id, student_id, teacher_id) VALUES ('$teacher_class_id', '$student_id1', $teacher_id)";
    if ($conn->query($sql) === TRUE) {

    }    
    $sql= "INSERT INTO student_class (class_id, student_id, `status`) VALUES ('$idclaz', '$student_id1', 1)";
   

    if ($conn->query($sql) === TRUE) {

        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

        echo "<script>Swal.fire({
            title: 'success',
            text: 'Successfully added the Student!',
            icon: 'Success',
        }).then(function() {

           // window.location = 'class_members.php?id=$teacher_class_id&subjid=$subjid&classid=$idclaz';
            
        });</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


 
}

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
                        <span style="font-weight: lighter;"><?php echo $class_row['class_name']; ?></span> > Class Members
                    </h3>
	<a id="print" onclick="window.print()"  class="btn btn-success"><i class="icon-print"></i> Print Student List</a>
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
                <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_student" >
                    <i class="fa fa-plus" aria-hidden="true"></i>Active Students </button>

                <!-- add student function -->
                <div class="modal fade " id="add_student" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg " role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Schedule</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>


                                        <div class="modal-body">
                                                
                                            <table id="dataTableID" class="table table-bordered table table-striped" width="100%" cellspacing="0">
                                            <thead>

                                                <tr>
                                                    <th>Student ID</th>
                                                    <th>Name</th>
                                                    <th></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $querys3 = mysqli_query($conn, "SELECT * FROM teacher_class WHERE teacher_class_id = ". $get_id);
                                                $rows3 = mysqli_fetch_array($querys3);


                                                
                                                $classid = $rows3['class_id'];
                                                $subjid = $rows3['subject_id'];
                                                $querys1 = mysqli_query($conn, "SELECT *,s.student_id as studno  FROM student s 
                                                LEFT JOIN teacher_class tc ON s.class_id = tc.class_id
                                                WHERE s.class_id = " . $classid . " and tc.subject_id = " . $subjid . "

                                                 ;");
                                                while ($rows1 = mysqli_fetch_array($querys1)) {


                                                    $querys2 = "SELECT *   FROM  teacher_class_student WHERE student_id = " . $rows1['studno'] .";";
                                                    $results2 = mysqli_query($conn, $querys2);
                                                    if ($results2->num_rows <= 0) {
                                                ?>
                                                    <tr>
                                                    <td> <?php echo $rows1['username']; ?> </td>
                                                    <td> <?php echo $rows1['firstname'] . " " . $rows1['lastname']; ?> </td>
                                                    <td> 
                                                        <form action="" method="get"> 
                                                            <input type="hidden" name="addstudent" value="set" />
                                                            <input type="hidden" name="classid" value="<?php echo $classid ?>" />
                                                            <input type="hidden" name="id" value="<?php echo $get_id ?>" />
                                                            <input type="hidden" name="subjid" value="<?php echo $subjid ?>" />

                                                            
                                                            <input type="hidden" name="studentid" hidden value="<?php echo $rows1['studno'] ?>" />
                                                            <button type="submit" name="" class="btn btn-primary">ADD</button>

                                                        </form>
                                                    </td>
                                                
                                                    </tr>
                                                <?php } 
                                                }
                                                ?>
                                                </tbody>  
                                            </table> 
                                        </div> <!-- modal body -->
                                    </div>
                                </div>
                         </div>  




                    <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    
                    </div>

                    <!-- Content Row -->
                    <div class="row">      
                            <main class="table">
                            <?php
// Start the session at the beginning of your PHP script if not already started.


// Assuming the teacher's ID is stored in the session variable 'teacher_id'.
$teacher_id = $_SESSION['teacher_id'];

// Ensure you have a valid database connection ($conn) before using it.

// Replace '$get_id' with the class ID you want to display.


// Check if the teacher has access to the class
$check_access_query = mysqli_query($conn, "SELECT * FROM teacher_class WHERE teacher_id = '$teacher_id' AND teacher_class_id = '$get_id'");
if (mysqli_num_rows($check_access_query) > 0) {
    // The teacher has access to this class

    $my_student = mysqli_query($conn, "SELECT * FROM teacher_class_student
        INNER JOIN student ON student.student_id = teacher_class_student.student_id
        WHERE teacher_class_id = '$get_id'") or die(mysqli_error());

    $count_my_student = mysqli_num_rows($my_student);
    ?>
<div class="header mt-4 pl-4" style ="backround: white;">
    <h5 class="display-6">Student List</h5>
</div>
                    <hr>
    <section class="table__header">
        <?php if ($count_my_student > 0) { ?>
            <h6>Number of Students: <span class="badge -info"><?php echo $count_my_student; ?></span></h6>
            <div class="input-group">
                <input type="search" placeholder="Search Student...">
            </div>
        <?php } else { ?>
            <center> <div class ="alert alert-warning" > No class members yet</div> </center>
        <?php } ?>
    </section>

    <?php
    if ($count_my_student > 0) {
    ?>
    
    <section class="table__body">
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th> Name <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Student Number <span class="icon-arrow">&UpArrow;</span></th>
                </tr>
            </thead>
    
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($my_student)) {
                    $id = $row['teacher_class_student_id'];
                ?>
                <tr>
                    <td> <img src="<?php echo $row['picture']; ?>" alt=""></td>
                    <td class="rem"> <?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                    <td class="rem"> <?php echo $row['username']; ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </section>
    
    <?php
    }
} else {
    // The teacher does not have access to this class
    echo '<script>window.location.href = "../deny.php?reason=access_denied";</script>';
    exit; // Make sure to exit the script after the JavaScript redirect
}
?>

                                    </tbody>
                                </table>
                            </section> <!-- table_header -->
                        </main>
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

