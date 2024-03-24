<?php 
include('teacher_session.php');  ?>
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
                <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_assignmentModal" >
                    <i class="fa fa-plus" aria-hidden="true"></i> Add Student</button>
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
                    <td> <img src="<?php echo $row['location']; ?>" alt=""></td>
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

