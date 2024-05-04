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
                        <h1 class="h3 mb-0 text-gray-800">Manage Materials</h1>
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
                    
                           <!-- <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#addinstructormodal" 
                            style="margin-bottom: 20px; "><i class="fa fa-plus" aria-hidden="true"></i> Add Teacher</button>-->
            </td>

            <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                        <h1 class="h5 mb-0 text-gray-800">Pending Material List <b style='color:red'>[ Please Approved ]</b></h1>
                    </div>
                    <?php
                    // Displaying data into tables
                    $query = "SELECT * FROM files f INNER JOIN teacher t ON f.teacher_id = t.teacher_id
                        WHERE `status` = '' "; 
                    $query_run = mysqli_query($conn, $query);
                    ?>
            

            <table id = "dataTableID" class="table table-bordered table table-striped" width = "100%" cellspacing="0">
                <thead>
                         <tr>
                    
                      
                            <th>Material ID </th>
                            <th>Material Name</th>
                            <th>Description</th>
                            <th>Uploaded Date</th>
                            <th>Link</th>
                            <th>Teacher ID</th>
                            <th>Teacher Name</th>
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
                
                        <td><?php echo $row['file_id'];?></td>
                        <td><?php echo $row['fname'];?></td>
                        <td><?php echo $row['fdesc']; ?></td>
                        <td><?php echo $row['fdatein']; ?></td>
                        <td><?php
                         $fileLocationWithNames = $row['floc'];
                         $fileLocations = json_decode($fileLocationWithNames, true);

                         
                         if (is_array($fileLocations)) {

                            
                            foreach ($fileLocations as $file) {
                                $filename = basename($file);
                        ?>
                               <a href="//docs.google.com/gview?url=https://gmca.online/uploads/<?php echo $file; ?>&embedded=true" download="<?php echo $filename; ?>" class="pdf-link">Downloadable File: Link <!--<?php echo $filename; ?>--> </a>

                        <?php
                            }
                         }
                        ?></td>
                        <td><?php echo $row['teacher_id']; ?></td>
                        <td><?php echo $row['firstname'] . " " . $row['lastname'];  ?></td>
                        <td> 
                        </div>
                        <!--Delete Pop Up Modal -->
                        <div class="modal fade" id="delete_instructors" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Approved Material</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <form action="manage-materials-func.php" method = "POST"> 


                                        <div class="modal-body">
                                        
                                                <input type="hidden" name= "delete_ID" id ="delete_ID">

                                            <h5>Please press Confirm to Approved.</h5>

                
                                        
                                        </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" name="approvematerial" class="btn btn-primary">Confirm</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                        <!--  <form action="manage-users-function.php" method = "post"> -->
                            <!--  <input type = "hidden" name = "delete_id" value="<?php echo $row['teacher_id']; ?>"> -->
                            <button type ="submit" name = "delete_btn" class = "btn btn-success delete_btn">Approved</button>
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



    


