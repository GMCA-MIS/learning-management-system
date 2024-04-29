<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');

if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Query to retrieve user data
    $query = "SELECT * FROM class WHERE class_id = $class_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Fetch user data
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $class_name = $row['class_name'];
            $class_id = $row['class_id'];
        } else {
            echo "Class not Found.";
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
                <h1 class="h3 mb-0 text-gray-800">Class Profile</h1>
            </div>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Nav Item - User Information -->
                <?php include('includes/admin_name.php'); ?>
            </ul>
        </nav>
        <!-- End of Topbar -->

        <div class="d-sm-flex align-items-center justify-content-between" style="margin-top: 20px; margin-left: 10px;">

            <!--Add Pop Up Modal -->
            <div class="modal fade" id="add_class" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><b>Promote Section</b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form action="classprofile-function.php" method="GET">
                                    <div class="modal-body">

                                        <input type="hidden" name="class_id" value="<?php echo $_GET['class_id']?>">
                                        <label>Promoting Students under <b><?php echo $class_name; ?> </b> to Grade 12.</label>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" name="add_class" class="btn btn-primary">Confirm</button>
                                    </div>
                                </form>
                            </div> <!--modal content -->
                        </div> <!--modal dialog -->
                    </div> <!--modal fade -->


                    <?php
                    
                    if(!empty($class_name)){
                    // divide the section

                    $query = "SELECT COUNT(*) studentscounter FROM student s INNER JOIN class c ON s.class_id=c.class_id WHERE s.class_id = $class_id";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        // Fetch user data
                        $row = mysqli_fetch_assoc($result);
                         $studentcount = $row['studentscounter'];

                    }

                    $classname_exploded = explode("-",$class_name);
                    $class_shortname = $classname_exploded[0];
                    $class_grade = $classname_exploded[1];
                    $class_section = $classname_exploded[2];

                            if( ($class_grade == "11") && ($studentcount != 0)){
                                echo '<button type="button" class="btn btn-success add_btn"   data-toggle="modal" data-target="#add_class"
                                style="margin-bottom: 20px;"><i class="fa fa-arrow-up"></i> Promote Class to Grade 12</button>';
                                
                            }
                     }
                    
                    ?>
                      



        </div>
        <div class="d-sm-flex align-items-center justify-content-between" style="margin-top: 20px; margin-left: 10px;">

                    
        <h1 class="h5 mb-0 text-gray-800 ml-4"><?php echo  $class_name; ?></h1>
        </div>

        <?php
        // Displaying data into tables with class_name
        $query = "SELECT student_class.*,student.*, class.class_name, strand.name AS strand_name 
        FROM student_class 
        LEFT JOIN student ON student.student_id = student_class.student_id 
        LEFT JOIN class ON class.class_id = student_class.class_id 
        LEFT JOIN strand ON strand.id = student.strand_id 
        WHERE student_class.class_id = '$class_id' 
        ORDER BY student.student_id DESC";

        $query_run = mysqli_query($conn, $query);
        ?>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTableID" class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="display:none;">Student ID</th>
                        <th>Learner Reference Number</th>
                        <th>Name</th>
                        <th style="display:none;">Firstname</th>
                        <th style="display:none;">Lastname</th>
                        <th>Email</th>
                        <th>Strand</th>
                        <th>Enrollment</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query_run) > 0) {
                        while ($row = mysqli_fetch_assoc($query_run)) {
                            ?>
                            <tr>
                                <td style="display:none;"><?php echo $row['student_id']; ?></td>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td style="display:none;"><?php echo $row['firstname']; ?></td>
                                <td style="display:none;"><?php echo $row['lastname']; ?></td>
                                <td><?php echo $row['strand_name']; ?></td>
                                <td><?php if ($row['is_regular'] == 1) { ?>
                                        <p>Regular</p>
                                    <?php } else {
                                    ?>
                                        <p>Irregular</p>
                                    <?php
                                    } ?>
                                </td>
                                <td><?php if ($row['status'] == 1) { ?>
                                        <p>Active</p>
                                    <?php } else {
                                    ?>
                                        <p>Archive</p>
                                    <?php
                                    } ?>
                                </td>
                                <td width="15%"><a href="student_gradelist.php?student_id=<?php echo urlencode($row['student_id']) . "&class_id=" .$_GET['class_id']; ?>" class="btn btn-secondary">View Grades</a></td>
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