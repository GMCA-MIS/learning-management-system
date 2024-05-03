<?php
include('includes/header.php');
include('includes/navbar.php');
include('../admin/database-connect/connect.php');
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
                        <h1 class="h3 mb-0 text-gray-800">Manage Courses</h1>
                    </div>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Welcome, Admin</span>
                                <img class="img-profile rounded-circle" src="img/icons8-male-user-50.png">
                            </a>
                            
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="card-body">

                    <div class="table-responsive">

                    <td>
                    <!--Add Pop Up Modal -->
                    <div class="modal fade" id="addManageUsersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form action="manage-students-function.php" method = "POST"> 


                                                <div class="modal-body">
                                                
                                                        <input type="hidden" name= "add_ID" id ="add_ID">

                                                        <div class="form-group">
                                                            <label for="#">Grade Level</label>
                                                            <select name="gr_level" name="gr_level" id="add_gr_level" class="form-control" required>
                                                                <option value="" disabled selected>Select Grade Level</option>
                                                                <option value="Grade 1">Grade 1</option>
                                                                <option value="Grade 2">Grade 2</option>
                                                                <option value="Grade 3">Grade 3</option>
                                                                <option value="Grade 4">Grade 4</option>
                                                                <option value="Grade 5">Grade 5</option>
                                                                <option value="Grade 6">Grade 6</option>
                                                                <option value="Grade 7">Grade 7</option>
                                                                <option value="Grade 8">Grade 8</option>
                                                                <option value="Grade 9">Grade 9</option>
                                                                <option value="Grade 10">Grade 10</option>
                                                                <option value="Grade 11">Grade 11</option>
                                                                <option value="Grade 12">Grade 12</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="#">Section</label>
                                                            <select name="section" name="section" id="add_section" class="form-control" required>
                                                                <option value="" disabled selected>Select Section</option>
                                                                <option value="Section 1">Section 1</option>
                                                                <option value="Section 2">Section 2</option>
                                                                <option value="Section 3">Section 3</option>
                                 
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="#">Learner Reference Number (LRN)</label>
                                                            <input type="text" class="form-control" id="add_student_number" name="student_number" maxlength="13" minlength="13" placeholder="Enter 12-Digit LRN" oninput="formatStudentNumber(this)" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="#">First Name</label>
                                                            <input type="text" class="form-control" name="first_name" id="add_First_Name" placeholder="Enter First Name" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="#">Last Name</label>
                                                            <input type="text" class="form-control" name="last_name" id="add_Last_Name" placeholder="Enter Last Name" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="#">Email</label>
                                                            <input type="text" class="form-control" name="email" id="add_Email" placeholder="Enter email" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="#">Date of Birth</label>
                                                            <input type="date" name="dob" required  id="add_dob" class="form-control"><br>
                                                        </div>

                                                
                                                </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" name="add_manage_users" class="btn btn-primary">Submit</button>
                                                    </div>
                                            </form>  <!--end form -->
                                    </div> <!--modal content -->
                                </div> <!--modal dialog -->
                    </div>  <!--modal fade -->
                    
                            <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#addManageUsersModal" style="margin-bottom: 20px; background-color:  #dfa106; border-color:  #dfa106;"><i class="fa fa-plus" aria-hidden="true"></i> Add Students</button>
            </td>
            </td>


            <?php
            //Displaying data into tables
            $query ="SELECT * FROM courses";
            $query_run=mysqli_query($conn, $query);
            ?>
            <table id = "dataTableID" class="table table-bordered table table-striped" width = "100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Code</th>
                        <th>Course Title</th>
                        <th>Course Description</th>
                        <th>Join Code</th>
                        <th>Instructor</th>
                        <th>Delete</th>
                        <!--<th colspan ="2">Action</th> Hindi pwedeng may colspan para sa dataTables--> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(mysqli_num_rows($query_run) > 0) {
                            while($row=mysqli_fetch_assoc($query_run))
                            {
                        
                                ?>
                    <tr>
                        <td><?php echo $row['course_id']; ?></td>
                        <td><?php echo $row['course_code']; ?></td>
                        <td><?php echo $row['course_title']; ?></td>
                        <td><?php echo $row['course_description']; ?></td>
                        <td><?php echo $row['course_join_code']; ?></td>


                        

                        <td>
                            <!--Edit Pop Up Modal -->
                            <div class="modal fade" id="editManageUsersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Student Information</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <form action="manage-students-function.php" method = "POST"> 


                                        <div class="modal-body">
                                        
                                                <input type="hidden" name= "edit_ID" id ="edit_ID">

                                                <div class="form-group">
                                                            <label for="#">Grade Level</label>
                                                            <select name="gr_level" name="gr_level" id="edit_gr_level" class="form-control" required>
                                                                <option value="" disabled selected>Select Grade Level</option>
                                                                <option value="Grade 1">Grade 1</option>
                                                                <option value="Grade 2">Grade 2</option>
                                                                <option value="Grade 3">Grade 3</option>
                                                                <option value="Grade 4">Grade 4</option>
                                                                <option value="Grade 5">Grade 5</option>
                                                                <option value="Grade 6">Grade 6</option>
                                                                <option value="Grade 7">Grade 7</option>
                                                                <option value="Grade 8">Grade 8</option>
                                                                <option value="Grade 9">Grade 9</option>
                                                                <option value="Grade 10">Grade 10</option>
                                                                <option value="Grade 11">Grade 11</option>
                                                                <option value="Grade 12">Grade 12</option>
                                                            </select>
                                                </div>
                                                
                                                <div class="form-group">
                                                            <label for="#">Section</label>
                                                            <select name="section" name="section" id="edit_section" class="form-control" required>
                                                                <option value="" disabled selected>Select Section</option>
                                                                <option value="Section 1">Section 1</option>
                                                                <option value="Section 2">Section 2</option>
                                                                <option value="Section 3">Section 3</option>
                                 
                                                            </select>
                                                        </div>

                                                <div class="form-group">
                                                    <label for="#">Student Number</label>
                                                    <input type="text" class="form-control" id="edit_student_number" name="student_number" maxlength="13"  minlength="13" placeholder="Enter 12-Digit LRN" oninput="formatStudentNumber(this)" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="#">First Name</label>
                                                    <input type="text" class="form-control" name="first_name" id="edit_first_name" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="#">Last Name</label>
                                                    <input type="text" class="form-control" name="last_name" id="edit_last_name">
                                                </div>

                                                <div class="form-group">
                                                    <label for="#">Email</label>
                                                    <input type="text" class="form-control" name="email" id="edit_email">
                                                </div>

                                                <div class="form-group">
                                                    <label for="#">Date of Birth</label>
                                                    <input type="date" class="form-control" name="dob" id="edit_dob">
                                                </div>

                                        </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" name="update_manage_users" class="btn btn-primary">Update</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                            <button type="button" class="btn btn-success edit_btn" data-toggle="modal" data-target="#editManageUsersModal" style="background-color:  #dfa106; border-color:  #dfa106;">Edit</button>
                        </td>

                        <td>

                        <!--Delete Pop Up Modal -->
                        <div class="modal fade" id="deleteManageUsersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <form action="manage-students-function.php" method = "POST"> 


                                        <div class="modal-body">
                                        
                                                <input type="hidden" name= "delete_ID" id ="delete_ID">

                                            <h5>Do you want to delete this data?</h5>

                
                                        
                                        </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" name="delete_manage_users" class="btn btn-primary">Confirm</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                        <!--  <form action="manage-users-function.php" method = "post"> -->
                            <!--  <input type = "hidden" name = "delete_id" value="<?php echo $row['Reg_ID']; ?>"> -->
                                <button type ="submit" name = "delete_btn" class = "btn btn-danger delete_btn" style="background-color:  #050c4b; border-color:  #050c4b;">Delete</button>
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



    


