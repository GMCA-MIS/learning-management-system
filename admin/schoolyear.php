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
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow newtopbar" style="margin-bottom:0;">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                
                 <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                        <h1 class="h3 mb-0 text-gray-800">School Year</h1>
                    </div>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <?php include ('includes/admin_name.php'); ?>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <?php
include ('dbcon.php');
					$school_year_query = mysqli_query($conn,"select * from school_year order by school_year DESC")or die(mysqli_error());
					$school_year_query_row = mysqli_fetch_array($school_year_query);
					$school_year = $school_year_query_row['school_year_id'];
				?>
                <!-- Begin Page Content -->
                <div class="card-body">
                    
                    <div class="table-responsive">

                    <td>
                    <!--Add Pop Up Modal -->
                    <div class="modal fade" id="add_schoolyearModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add School Year</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form action="" method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="add_ID" id="add_ID">
                                                    <input type="hidden" name="s_id" value="<?php echo $school_year?>">
                                                    <div class="form-group">
                                                        <label for="school_year">School Year</label>
                                                        <input type="text" class="form-control" id="school_year" name="school_year" required placeholder="Enter School Year">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="school_year">Semester</label>
                                                        <select name="semester" class="form-control" required>
                                                                        <option value="" disabled selected>Select Semester</option>
                                                                        <option value="First Semester">First Semester</option>
                                                                        <option value="Second Semester">Second Semester</option>
                                                                       
                                                                </select>   
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="start_date">Start Date</label>
                                                        <input type="date" class="form-control flatpickr" id="start_date" placeholder="Enter Start Date" name="start_date" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="end_date">End Date</label>
                                                        <input type="date" class="form-control flatpickr" id="end_date" placeholder="Enter End Date" name="end_date" required>
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="add_schoolyear" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                    </div> <!--modal content -->
                                </div> <!--modal dialog -->
                    </div>  <!--modal fade -->
                    
                            <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_schoolyearModal" 
                            style="margin-bottom: 20px" ><i class="fa fa-plus" aria-hidden="true"></i>  Add School Year</button>
            </td>
        

        
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                <h1 class="h5 mb-0 text-gray-800">School Year List</h1>
            </div>
            <?php
            //Displaying data into tables
            $query ="SELECT * FROM school_year";
            $query_run=mysqli_query($conn, $query);
            ?>
            <table id = "dataTableID" class="table table-bordered table table-striped" width = "100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="display:none;">School Year ID</th>
                        <th>School Year</th>
                        <th style="display:none;">Start Date</th>
                        <th style="display:none;">End Date</th>
                        <th>Semester</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>                             
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(mysqli_num_rows($query_run) > 0) {
                            while($row=mysqli_fetch_assoc($query_run))
                            {
                                ?>
                    <tr>
                        <td style="display:none;"><?php echo $row['school_year_id']; ?></td>      
                        <td><a href="sydetails.php"> <?php echo $row['school_year']; ?> </a></td>
                        <td style="display:none;"><?php echo date("F j, Y", strtotime($row['start_date'])); ?> </td>
                        <td style="display:none;"><?php echo date("F j, Y", strtotime($row['end_date'])); ?> </td>
                        <td><?php echo $row['semester']; ?></td>
                        <td><?php echo date("F j, Y", strtotime($row['start_date'])) . ' - ' . date("F j, Y", strtotime($row['end_date'])); ?></td>
                        <td><?php  if($row['status'] == 0 ) {  echo "<b style='color:gray'>Inactive</b>";  }else{ echo "<b style='color:green'>Active</b>"; } ?></td>
                         </td>


                   

<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                        <td>
                            <!--Edit Pop Up Modal -->
                            <div class="modal fade" id="editSchoolYearModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Department Information</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form action="" method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="edit_ID" id="edit_ID">

                                                    <div class="form-group">
                                                        <label for="school_year">School Year</label>
                                                        <input type="text" class="form-control" id="edit_school_year" name="school_year" required placeholder="Enter School Year">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="start_date">Start Date</label>
                                                        <input type="date" class="form-control flatpickr" id="edit_start_date" placeholder="Enter Start Date" name="start_date" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="end_date">End Date</label>
                                                        <input type="date" class="form-control flatpickr" id="edit_end_date" placeholder="Enter End Date" name="end_date" required>
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="edit_schoolyear" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                    </div>
                                </div>
                            </div>  

                            <button type="button" class="btn btn-success edit_btn" data-toggle="modal" data-target="#editSchoolYearModal " >Edit</button>
                        </td>

                        <td>
                        </div>
                        

<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

                        <!--Delete Pop Up Modal -->
                        <div class="modal fade" id="delete_schoolyearModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <form action="" method = "POST"> 


                                        <div class="modal-body">
                                        
                                                <input type="hidden" name= "delete_ID" id ="delete_ID">

                                            <h5>Do you want to delete this data?</h5>
                                            <h7>Deleting this will also wipe out the School Year Data.</h7>

                
                                        
                                        </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" name="delete_schoolyear" class="btn btn-primary">Confirm</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                
                                <button type ="submit" name = "delete_btn" class = "btn btn-danger delete_btn">Delete</button>
              
                        </td>
                    </tr>
                    <?php
                            }
                        }
                        else 
                        {
                            echo "No Record Found";
                        }
                        ?>
                </tbody>
            </table>
    </div>
</div>



<?php
include('includes/scripts.php');
include('includes/footer.php');
?>





<script>
    $(document).ready(function () {

        $('.edit_btn').on('click', function () {

            $('#editProcessModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#edit_ID').val(data[0]);
            $('#o_ID').val(data[1]);
            $('#edit_Process_Name').val(data[2]);
            $('#edit_Process_Description').val(data[3]);
            $('#edit_Process_Type').val(data[4]);
        });
    });
</script>


<?php
if (isset($_POST['add_schoolyear'])) {
    $school_year = $_POST['school_year'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $semester = $_POST['semester'];

    if (strtotime($end_date) < strtotime($start_date)) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date Input',
                text: 'The end date cannot be earlier than the start date.'
            });
        </script>";
    } else {
        $query = mysqli_query($conn, "select * from school_year where school_year = '$school_year'") or die(mysqli_error());
        $count = mysqli_num_rows($query);

        if ($count > 0) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Data Already Exists',
                    text: 'The school year already exists in the database.'
                }).then(function() {
                    window.location.href = 'schoolyear.php';
                });
            </script>";
        } else {
            mysqli_query($conn, "insert into school_year (school_year, start_date, end_date, semester) values('$school_year', '$start_date', '$end_date', '$semester')") or die(mysqli_error());

            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'School year added successfully.'
                }).then(function() {
                    window.location.href = 'schoolyear.php';
                });
            </script>";
        }
    }
}
?>


<?php
include('dbcon.php');


//Manage User Delete Function
if(isset($_POST['delete_schoolyear']))
{
    $id = $_POST['delete_ID'];

    $query = "DELETE FROM school_year WHERE school_year_id = '$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Success",
            text: "School year record has been deleted successfully!",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "schoolyear.php";
        });</script>';
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Error",
            text: "Failed to delete School Year!",
            icon: "error",
            confirmButtonText: "OK"
        });</script>';
    }
    
    
}

?>


<?php 
    // Manage-Users Edit Function 
    if(isset($_POST['edit_schoolyear'])) // Button Name
    {       
        // Name attributes are used here, make sure they match your form fields
        $id = $_POST['edit_ID'];

        $school_year = $_POST['school_year'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        // Check if the end date is earlier than the start date
        if (strtotime($end_date) < strtotime($start_date)) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "End date cannot be earlier than the start date.",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        } else {
            // If the date range is valid, update the database
            $query = "UPDATE school_year SET school_year='$school_year', start_date='$start_date', end_date='$end_date' WHERE school_year_id = '$id'";
            $query_run = mysqli_query($conn, $query);

            if($query_run) {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo '<script>Swal.fire({
                    title: "Success",
                    text: "School Year Details has been updated successfully!",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(function() {
                    window.location.href = "schoolyear.php";
                });</script>';
            } else {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo '<script>Swal.fire({
                    title: "Error",
                    text: "Failed to update School Year Details!",
                    icon: "error",
                    confirmButtonText: "OK"
                });</script>';
            }
        }
    } 
?>
