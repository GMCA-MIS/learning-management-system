<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<?php $id = $_GET['id']; ?>
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
                        <h1 class="h3 mb-0 text-gray-800">Subjects</h1>
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
                    <div class="modal fade" id="add_courseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Subject</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form action="manage-courses-function.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <input type="hidden" name="add_ID" id="add_ID">
                                                    <input type="hidden" name= "get_id" value = <?php echo $id?>>

                                                    <div class="form-group">
                                                        <label for="course_code">Subject Code</label>
                                                        <input type="text" class="form-control" id="course_code" name="course_code" required placeholder="Enter Subject Code">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="course_title">Subject Title</label>
                                                        <input type="text" class="form-control" id="course_title" name="course_title" required placeholder="Enter Subject Title">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="course_type">Subject Type</label>
                                                        <select type="text" class="form-control" id="course_type" name="course_type" required placeholder="Enter Subject Type">
                                                            <option class="form-control" disabled selected> Select Subject Type </Option>
                                                            <option class="form-control" value = "Core"> Core </Option>
                                                            <option class="form-control" value = "Applied"> Applied </Option>
                                                            <option class="form-control" value = "Specialized"> Specialization </Option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="track">Track Type</label>
                                                        <select type="text" class="form-control" id="track" name="track" required placeholder="Enter Track Type">
                                                            <option class="form-control" disabled selected> Select Subject Track </Option>
                                                            <option class="form-control" value = "Academic"> Academic </Option>
                                                            <option class="form-control" value = "TVL"> Technical-Vocational-Livelihood (TVL) </Option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group" style="width: 100%;">
                                                        <span class="details">Description</span>
                                                        <textarea id="description" name="description"></textarea>
                                                    </div>
                                                    <div class="form-group" style="width: 100%;">
                                                        <span class="details">Subject Photo : </span>
                                                        <input type="file" class="form-control" name="images" id="image" >
                                                    </div>


                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="add_course" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                    </div> <!--modal content -->
                                </div> <!--modal dialog -->
                    </div>  <!--modal fade -->
                    
                            <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_courseModal" 
                            style="margin-bottom: 20px;"><i class="fa fa-plus" aria-hidden="true"></i> Add Subject</button>
            </td>
        

        
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                        <h1 class="h5 mb-0 text-gray-800">Subject List</h1>
                    </div>
            <?php
            //Displaying data into tables
            $query ="SELECT * FROM subject order by subject_id DESC";
            $query_run=mysqli_query($conn, $query);
            ?>
            <table id = "dataTableID" class="table table-bordered table table-striped" width = "100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="display:none;">Subject ID</th>
                        <th>Subject Code</th>
                        <th>Subject Title</th>
                        <th>Subject Photo</th>
                        <th>Type</th>
                        <th>Track</th>
                        <th>Description</th>
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
                        <td style="display:none;"><?php echo $row['subject_id']; ?></td>      
                        <td><?php echo $row['subject_code']; ?></td>
                        <td><img src="<?php echo $row['photo'];?>"  width="100px" height="100px" /></td>
                        <td><?php echo $row['subject_title']; ?></td>
                        <td><?php echo $row['subject_type']; ?></td>
                        <td><?php echo $row['track']; ?></td>
                        <td><?php echo $row['description']; ?></td>

                       

<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                        <td>
                            <!--Edit Pop Up Modal -->
                            <div class="modal fade" id="edit_courseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Subject Information</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                    <form action="manage-courses-function.php" method = "POST"> 

                                        <div class="modal-body">

                                                <input type="hidden" name= "edit_ID" id ="edit_ID">
                                                <input type="hidden" name= "get_id" value = <?php echo $id?>>
                                                <div class="form-group">
                                                    <label for="course_code">Subject Code</label>
                                                    <input type="text" class="form-control" id="edit_course_code" name="course_code" required placeholder="Enter Subject Code">
                                                </div>

                                                <div class="form-group">
                                                    <label for="course_title">Subject Title</label>
                                                    <input type="text" class="form-control" id="edit_course_title" name="course_title" required placeholder="Enter Subject Title">
                                                </div>

                                                 <div class="form-group">
                                                    <label for="course_type">Subject Type</label>
                                                        <select type="text" class="form-control" id="edit_course_type" name="course_type" required placeholder="Enter Subject Type">
                                                            <option class="form-control" disabled selected> Select Subject Type </Option>
                                                            <option class="form-control" value = "Core"> Core </Option>
                                                            <option class="form-control" value = "Applied"> Applied </Option>
                                                            <option class="form-control" value = "Specialized"> Specialization </Option>
                                                        <select>
                                                </div>

                                                <div class="form-group">
                                                        <label for="track">Track Type</label>
                                                        <select type="text" class="form-control" id="edit_track" name="track" required placeholder="Enter Track Type">
                                                            <option class="form-control" disabled selected> Select Subject Track </Option>
                                                            <option class="form-control" value = "Academic"> Academic </Option>
                                                            <option class="form-control" value = "TVL"> Technical-Vocational-Livelihood (TVL) </Option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group" style="width: 100%;">
                                                        <span class="details">Description</span>
                                                        <!-- Textarea for Description -->
                                                        <textarea  style="width: 100%;" rows= "6" id="edit_description" name="description"></textarea>
                                                    </div>


                                        </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="edit_course" class="btn btn-primary">Update</button>
                                                </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                            <button type="button" class="btn btn-success edit_btn" data-toggle="modal" data-target="#edit_courseModal ">Edit</button>
                        </td>

                        <td>
                        </div>
                        

<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

                        <!--Delete Pop Up Modal -->
                        <div class="modal fade" id="delete_courseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <form action="manage-courses-function.php" method = "POST"> 


                                        <div class="modal-body">
                                        
                                                <input type="hidden" name= "delete_ID" id ="delete_ID">
                                                <input type="hidden" name= "get_id" value = <?php echo $id?>>
                                            <h5>Do you want to delete this data?</h5>

                
                                        
                                        </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" name="delete_course" class="btn btn-primary">Confirm</button>
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


