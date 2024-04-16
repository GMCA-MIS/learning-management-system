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
                        <h1 class="h3 mb-0 text-gray-800">Manage Teachers</h1>
                    </div>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <?php include ('includes/admin_name.php'); ?>


                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="card-body">

                    <div class="table-responsive">

                    <td>
                    <!--Add Pop Up Modal -->
                    <div class="modal fade" id="addinstructormodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Teacher</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form action="manage-teachers-function.php" method = "POST"> 


                                                <div class="modal-body">
                                                
                                                        <input type="hidden" name= "add_ID" id ="add_ID">
                                                        <input type="hidden" name= "user_type" id ="user_type">

                                                        <div class="form-group">
                                                            <label for="department">Department </label>
                                                         <select name="department" class="form-control" required>
                                                                        <option value="" disabled selected>Select Department</option>
                                                                        <?php
                                                                        $query = mysqli_query($conn, "SELECT * FROM department ORDER BY department_name");
                                                                        while ($row = mysqli_fetch_array($query)) {
                                                                        ?>
                                                                        <option value="<?php echo $row['department_id']; ?>"><?php echo $row['department_name']; ?></option>
                                                                        <?php } ?>
                                                                </select>       
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="firstname">First Name </label>
                                                            <input type="text" class="form-control" id="firstname" name="firstname" required placeholder="Enter First Name">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="lastname">Last Name </label>
                                                            <input type="text" class="form-control" id="lastname" name="lastname" required placeholder="Enter Last Name">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter Email Address">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="dob">Date of Birth</label>
                                                            <input type="date" class="form-control" max="<?= date('Y-m-d', strtotime(' -15 Year')) ?>" id="dob" name="dob" required placeholder="Enter Date of Birth">
                                                        </div>

                                                         
                                                        <div class="form-group">
                                                            <label for="specialization">Specialization </label>
                                                            <input type="text" class="form-control" id="specialization" name="specialization" required placeholder="Enter Specialization(s)">
                                                        </div>                       

                                                
                                                </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" name="add_instructor" class="btn btn-primary">Submit</button>
                                                    </div>
                                            </form>  <!--end form -->
                                    </div> <!--modal content -->
                                </div> <!--modal dialog -->
                    </div>  <!--modal fade -->
                    
                            <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#addinstructormodal" 
                            style="margin-bottom: 20px; "><i class="fa fa-plus" aria-hidden="true"></i> Add Teacher</button>
            </td>
            <div class="form-group">
                <label>Add teachers via .csv file</label>
                <form method="post" action="manage-teachers-csv.php" enctype="multipart/form-data">
                    <input type="file" id="csvFile" placeholder="Upload .csv file" name="file" accept=".csv" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-right: 10px;">
                    <button type="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading..." id="uploadBtn" disabled>Upload</button>
                </form>
            </div>

            <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                        <h1 class="h5 mb-0 text-gray-800">Teacher List</h1>
                    </div>
                    <?php
                    // Displaying data into tables
                    $query = "SELECT t.*, d.department_name 
                            FROM teacher t
                            INNER JOIN department d ON t.department_id = d.department_id ORDER BY t.teacher_id DESC"; // Assuming 'department_id' is the foreign key linking teacher and department tables
                    $query_run = mysqli_query($conn, $query);
                    ?>
            
            <script>
                document.getElementById('csvFile').addEventListener('change', function() {
                    const uploadBtn = document.getElementById('uploadBtn');
                    if (this.files.length !== 0 && this.files[0].name.endsWith('.csv')) {
                        uploadBtn.disabled = false;
                    } else {
                        uploadBtn.disabled = true;
                    }
                });
            </script>

            <table id = "dataTableID" class="table table-bordered table table-striped" width = "100%" cellspacing="0">
                <thead>
                         <tr>
                    
                      
                            <th style="display:none;">Teacher ID </th>
                            <th style="display:none;">Teacher ID </th>
                            <th style="display:none;">Teacher ID </th>
                            <th style="display:none;">Teacher ID </th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Department</th>
                            <th>Email</th>
                            <th>Date of Birth</th>
                            <th>Specialization</th>
                            <th>Edit</th>
                            <th>Action</th>
                         </tr>
                </thead>
                <tbody>
                    <?php
                        if(mysqli_num_rows($query_run) > 0) {
                            while($row=mysqli_fetch_assoc($query_run))
                            {
                        
                                ?>
                    <tr>
                
                        <td style="display: none;"><?php echo $row['teacher_id']; ?></td>
                        <td style="display:none;"><?php echo $row['firstname'];?></td>
                        <td style="display:none;"><?php echo $row['lastname'];?></td>
                        <td style="display:none;"><?php echo $row['email'];?></td>
                        <td><?php echo $row['firstname'];?></td>
                        <td><?php echo $row['lastname'];?></td>
                        <td><?php echo $row['department_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['dob']; ?></td>
                        <td><?php echo $row['specialization']; ?></td>


                        

                        <td>
                            <!--Edit Pop Up Modal -->
                            <div class="modal fade" id="editinstructorsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Teacher Information</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <form action="manage-teachers-function.php" method = "POST"> 


                                        <div class="modal-body">
                                        
                                                <input type="hidden" name= "edit_ID" id ="edit_ID">
                                                <input type="hidden" name= "user_type" id ="user_type">
                                        

                                                <div class="form-group">
                                                    <label for="#">Department</label>
                                                    <select name="department_id" id ="edit_department" class="form-control" required>
                                                                        <option value="" disabled selected>Select Department</option>
                                                                        <?php
                                                                        $query = mysqli_query($conn, "SELECT * FROM department ORDER BY department_name");
                                                                        while ($row = mysqli_fetch_array($query)) {
                                                                        ?>
                                                                        <option value="<?php echo $row['department_id']; ?>"><?php echo $row['department_name']; ?></option>
                                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="#">First Name</label>
                                                    <input type="text" class="form-control" name="firstname" id="edit_firstname">
                                                </div>

                                                <div class="form-group">
                                                    <label for="#">Last Name</label>
                                                    <input type="text" class="form-control" name="lastname" id="edit_lastname">
                                                </div>

                                                <div class="form-group">
                                                    <label for="#">Email</label>
                                                    <input type="email" class="form-control" name="email" id="edit_email">
                                                </div>

                                                <div class="form-group">
                                                    <label for="dob">Date of Birth</label>
                                                    <input type="text" class="form-control flatpickrz" id="edit_dob" name="dob" required placeholder="Enter Date of Birth">
                                                </div>

                                                <div class="form-group">
                                                    <label for="specialization">Specialization </label>
                                                    <input type="text" class="form-control" id="edit_specialization" name="specialization" required placeholder="Enter Specialization(s)">
                                                </div>

                                        
                                        </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" name="edit_instructors" class="btn btn-primary">Update</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                            <button type="button" class="btn btn-success edit_btn" data-toggle="modal" data-target="#editManageUsersModal " >Edit</button>
                        </td>

                        <td> 
                        </div>
                        <!--Delete Pop Up Modal -->
                        <div class="modal fade" id="delete_instructors" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <form action="manage-teachers-function.php" method = "POST"> 


                                        <div class="modal-body">
                                        
                                                <input type="hidden" name= "delete_ID" id ="delete_ID">

                                            <h5>Do you want to delete this data?</h5>

                
                                        
                                        </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" name="delete_instructors" class="btn btn-primary">Confirm</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                        <!--  <form action="manage-users-function.php" method = "post"> -->
                            <!--  <input type = "hidden" name = "delete_id" value="<?php echo $row['teacher_id']; ?>"> -->
                            <button type ="submit" name = "delete_btn" class = "btn btn-danger delete_btn">Delete</button>
                        <!-- </form> -->
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



    


