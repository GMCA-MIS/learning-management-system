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
            <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                <h1 class="h3 mb-0 text-gray-800">Class Profile</h1>
            </div>


            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - User Information -->
                <?php include('includes/admin_name.php'); ?>

            </ul>

        </nav>
        <!-- End of Topbar -->





        <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
            <h1 class="h5 mb-0 text-gray-800"><?php echo  $class_name; ?></h1>
        </div>
        <?php
        // Displaying data into tables with class_name
        $query = "SELECT student.*, class.class_name, strand.name as strand_name FROM student
                LEFT JOIN class ON student.class_id = class.class_id
                LEFT JOIN strand ON strand.id = student.strand_id where student.class_id =  '$class_id' ORDER BY student.student_id DESC";

        $query_run = mysqli_query($conn, $query);
        ?>

        <table id="dataTableID" class="table table-bordered table table-striped" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="display:none;">Student ID</th>
                    <!-- <th>Photo</th> -->
                    <th>Learner Reference Number</th>
                    <th style="display:none;">Firstname</th>
                    <th style="display:none;">Lastname</th>
                    <th>Name</th>
                    <th>Strand</th>
                    <th>Section</th>
                    <th>Email</th>
                    <th>Date of Birth</th>





                    <!--<th colspan ="2">Action</th> Hindi pwedeng may colspan para sa dataTables-->
                </tr>
            </thead>

            <tbody>

                <?php
                if (mysqli_num_rows($query_run) > 0) {
                    while ($row = mysqli_fetch_assoc($query_run)) {

                ?>
                        <tr>

                            <td style="display:none;"><?php echo $row['student_id']; ?></td>
                            <!-- <td><img src="<?php echo $row['location']; ?>" alt="" class="rounded-circle d-block mx-auto" style="width: 60px;"></td> -->
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                            <td style="display:none;"><?php echo $row['firstname']; ?></td>
                            <td style="display:none;"><?php echo $row['lastname']; ?></td>
                            <td><?php echo $row['strand_name']; ?></td>
                            <td><?php echo $row['class_name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['dob']; ?></td>


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

<!-- approved Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Approve Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="manage-students-function.php" method="POST">


                <div class="modal-body">

                    <input type="hidden" name="approvedinputid" id="approvedinputid">

                    <h5>Do you want to approve this student?</h5>



                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="approve_student" class="btn btn-primary">Confirm</button>
                </div>
            </form>
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