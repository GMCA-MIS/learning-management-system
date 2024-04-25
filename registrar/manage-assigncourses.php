<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<?php
					$school_year_query = mysqli_query($conn,"select * from school_year order by school_year_id DESC")or die(mysqli_error());
					$school_year_query_row = mysqli_fetch_array($school_year_query);
					$school_year = $school_year_query_row['school_year_id'];
                    $school_years = $school_year_query_row['school_year'];
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
                        <h1 class="h3 mb-0 text-gray-800">Assigned Subjects (S.Y <?php echo $school_years?>)</h1>
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
                    <div class="modal fade" id="add_assigncourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Assign Subject</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form action="manage-assigncourses-function.php" method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="add_ID" id="add_ID">
                                                    <input type="hidden" name="school_year_id" value = "<?php echo $school_year; ?>">

                                                    <?php
                                                    $query = mysqli_query($conn,"select * from school_year order by school_year DESC");
                                                    $row = mysqli_fetch_array($query);
                                                    ?>
                                                    <input id="" class="span5" type="hidden" class="" name="school_year" value="<?php echo $row['school_year']; ?>" >

                                                    <div class="form-group">
                                                        <label for="course">Subject</label>
                                                        <select name="subject_id" class="form-control" required>
                                                            <option value="" disabled selected>Select Subject</option>
                                                            <?php
                                                            $query = mysqli_query($conn, "SELECT * FROM subject ORDER BY subject_title");
                                                            while ($row = mysqli_fetch_array($query)) {
                                                            ?>
                                                            <option value="<?php echo $row['subject_id']; ?>"><?php echo $row['subject_title']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="class">Class</label>
                                                        <select name="class_id" class="form-control" required>
                                                            <option value="" disabled selected>Select Class</option>
                                                            <?php
                                                            $query = mysqli_query($conn, "SELECT * FROM class ORDER BY class_id");
                                                            while ($row = mysqli_fetch_array($query)) {
                                                            ?>
                                                            <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="instructors">Instructor to be Assigned</label>
                                                        <select name="teacher_id" class="form-control" required>
                                                            <option value="" disabled selected>Select Instructor</option>
                                                            <?php
                                                            $query = mysqli_query($conn, "SELECT * FROM teacher ORDER BY firstname");
                                                            while ($row = mysqli_fetch_array($query)) {
                                                            ?>
                                                            <option value="<?php echo $row['teacher_id']; ?>"><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <!-- Schedule input section -->
                                                    <div id="schedule-section">
                                                        <div class="form-group schedule-entry">
                                                            <label for="day">Day</label>
                                                            <input type="text" name="schedule_day[]" class="form-control" placeholder="Enter Day" required>
                                                            <label for="time">Time</label>
                                                            <input type="text" name="schedule_time[]" class="form-control" placeholder="Enter Time" required>
                                                        </div>
                                                    </div>

                                                    <button type="button" id="add-schedule" class="btn btn-primary">Add More Schedule Day</button>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="assign_course" class="btn btn-primary">Assign</button>
                                                </div>
                                            </form>

                                    </div> <!--modal content -->
                                </div> <!--modal dialog -->
                    </div>  <!--modal fade -->
                    
                            <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_assigncourseModal" 
                           ><i class="fa fa-plus" aria-hidden="true"></i> Assign Subject </button>
            </td>
        
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#add-schedule").click(function() {
            // Clone the schedule entry and append it to the schedule section
            var scheduleEntry = $(".schedule-entry:first").clone();
            scheduleEntry.find("input").val(""); // Clear the input values
            $("#schedule-section").append(scheduleEntry);
        });
    });
</script>
        
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                        <h1 class="h5 mb-0 text-gray-800"></h1>
                    </div>
                    <?php
// Fetch data from the database

$query = "SELECT tc.teacher_id,tc.teacher_class_id, t.firstname, t.lastname, s.subject_code, cl.class_name, s.subject_title
    FROM teacher_class tc
    INNER JOIN teacher t ON tc.teacher_id = t.teacher_id
    INNER JOIN subject s ON tc.subject_id = s.subject_id
    INNER JOIN class cl ON tc.class_id = cl.class_id
    WHERE tc.school_year_id = $school_year
    ORDER BY tc.teacher_class_id DESC";
$query_run = mysqli_query($conn, $query);
?>
<table id="dataTableID" class="table table-bordered table table-striped" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th style="display:none;">Teacher Class ID</th>
            <th>Subject Code</th>
            <th>Subject Title</th>
            <th>Class</th>
            <th>Assigned Instructor</th>
            <th>Schedule</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_assoc($query_run)) {
                 $teacher_idz = $row["teacher_id"];
                ?>
                <tr>
                    <td style="display:none;"><?php echo $row['teacher_class_id']; ?></td>
                    <td><?php echo $row['subject_code']; ?></td>
                    <td><?php echo $row['subject_title']; ?></td>
                    <td><?php echo $row['class_name']; ?></td>
                    <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
             
                    <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="<?php echo "#modal".$teacher_idz ?>">View Schedule</button>
                    </td>
<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                        <td>
                            <!--Edit Pop Up Modal -->
                            <div class="modal fade" id="edit_assigncourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Subject Assignment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                    <form action="manage-assigncourses-function.php" method = "POST"> 

                                    <div class="modal-body">
                                                    <input type="hidden" name="edit_ID" id="edit_ID">

                                                        <?php
                                                        $query = mysqli_query($conn,"select * from school_year order by school_year DESC");
                                                        $row = mysqli_fetch_array($query);
                                                        ?>
                                                        <input id="" class="span5" type="hidden" class="" name="school_year" value="<?php  echo $row['school_year']; ?>" >
                                                  
                                                    <div class="form-group">
                                                            <label for="course">Subject </label>
                                                                <select name="subject_id" id="edit_subject_id" class="form-control" required>
                                                                        <option value="" disabled selected>Select Subject</option>
                                                                        <?php
                                                                        $query = mysqli_query($conn, "SELECT * FROM subject ORDER BY subject_title");
                                                                        while ($row = mysqli_fetch_array($query)) {
                                                                        ?>
                                                                        <option value="<?php echo $row['subject_id']; ?>"><?php echo $row['subject_title']; ?></option>
                                                                        <?php } ?>
                                                                </select>
                                                    </div>

                                                    <div class="form-group">
                                                            <label for="class">Class </label>
                                                                <select name="class_id" id="edit_class_id" class="form-control" required>
                                                                        <option value="" disabled selected>Select Class</option>
                                                                        <?php
                                                                        $query = mysqli_query($conn, "SELECT * FROM class ORDER BY class_id");
                                                                        while ($row = mysqli_fetch_array($query)) {
                                                                        ?>
                                                                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                                                                        <?php } ?>
                                                                </select>
                                                    </div>

                                                    <div class="form-group">
                                                            <label for="instructors">Instructor to be Assigned </label>
                                                                <select name="teacher_id" id="edit_teacher_id" class="form-control" required>
                                                                        <option value="" disabled selected>Select Instructor</option>
                                                                        <?php
                                                                        $query = mysqli_query($conn, "SELECT * FROM teacher ORDER BY firstname");
                                                                        while ($row = mysqli_fetch_array($query)) {
                                                                        ?>
                                                                       <option value="<?php echo $row['teacher_id']; ?>"><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></option>
                                                                        <?php } ?>
                                                                </select>
                                                    </div>
                                    </div> <!-- modal body -->

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="edit_assigncourse" class="btn btn-primary">Update</button>
                                                </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                            <button type="button" class="btn btn-secondary edit_btn" data-toggle="modal" data-target="#edit_assigncourseModal ">Edit</button>
                        </td>

                        <td>
                        </div>
                        
                        <!--Schedule Pop Up Modal -->
                        <div class="modal fade" id="<?php echo "modal".$teacher_idz; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Schedule</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                    <form action="manage-assigncourses-function.php" method = "POST"> 

                                        <div class="modal-body">

                                        <table>
                                                <tr>
                                                    <th>Class</th>
                                                    <th>Day</th>
                                                    <th>Time</th>
                                                </tr>
                                                
                                                <?php
                                                $querys = mysqli_query($conn, "SELECT * FROM teacher_class tc INNER JOIN `class` c ON tc.class_id = c.class_id WHERE tc.teacher_id = ". $teacher_idz );
                                                while ($rows = mysqli_fetch_array($querys)) {
                                                ?>
                                                <tr>
                                                    <td> <?php echo $rows['class_name'] ?> </td>
                                                    <td> <?php echo $rows['schedule_day'] ?> </td>
                                                    <td> <?php echo $rows['schedule_time'] ?> </td>
                                                
                                                </tr>
                                                <?php } ?>
                                              
                                                </table> 
                                        </div> <!-- modal body -->
                                    </form>
                                    </div>
                                </div>
                         </div>  
<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

                        <!--Delete Pop Up Modal -->
                        <div class="modal fade" id="delete_assigncourse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <form action="manage-assigncourses-function.php" method = "POST"> 


                                        <div class="modal-body">
                                        
                                                <input type="hidden" name= "delete_ID" id ="delete_ID">

                                            <h5>Do you want to remove class and Subject assignment?</h5> <br>
                                            <h6>Warning: All data associated with the specific class and Subject will be deleted.</h6>

                
                                        
                                        </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" name="delete_assigncourse" class="btn btn-primary">Confirm</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                        <!--  <form action="manage-users-function.php" method = "post"> -->
                            <!--  <input type = "hidden" name = "delete_id" value="<?php echo $row['Reg_ID']; ?>"> -->
                                <button type ="submit" name = "delete_btn" class = "btn btn-danger delete_btn" >Archive</button>
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


