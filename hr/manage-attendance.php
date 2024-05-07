<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');


$tfname = "";
$tlname ="";
$tdob = "";
$temail = "";
$tdepartment = "";
$tspecialization = "";
$paramaters = "";
$totalwork = 0;
$tlate  = 0 ;
$tundertime  = 0 ;
$tovertime  = 0 ;

if(isset($_GET['teacherid'])){

    $teacherid = $_GET['teacherid'];
    $startdate = $_GET['startdate'];
    $enddate = $_GET['enddate'];
    
    
    $query ="SELECT * FROM teacher a INNER JOIN department b ON a.department_id = b.department_id WHERE teacher_id = $teacherid LIMIT 1";
    $query_run=mysqli_query($conn, $query);
    if(mysqli_num_rows($query_run) > 0) {
        while($row=mysqli_fetch_assoc($query_run))
        {
            $tfname = $row['firstname'];
            $tlname = $row['lastname'];
            $tdob = $row['dob'];
            $temail = $row['email'];
            $tlocation = $row['location'];
            $tdepartment = $row['department_name'];
            $tspecialization = $row['specialization'];
        }
    }

    $paramaters = " WHERE status='work' AND a.teacher_id = $teacherid AND DATE(a.expected_timein) >= DATE('$startdate') AND DATE(a.expected_timeout) <= DATE('$enddate')"; 

    $query ="SELECT * FROM time_attendance a LEFT JOIN teacher b ON a.teacher_id = b.teacher_id $paramaters ORDER BY a.teacher_id DESC";
    $query_run=mysqli_query($conn, $query);
    if(mysqli_num_rows($query_run) > 0) 
    {
        while($row=mysqli_fetch_assoc($query_run))
        {

            $expecteddate = strtotime($row['expected_timein']);
            $actualdate   = strtotime($row['actual_timein']);
            if($actualdate >= $expecteddate){
                $late = round(abs ($actualdate - $expecteddate) / 3600,2) ; 
                $tlate = $tlate + $late ; 
            }


            $expecteddate = strtotime($row['expected_timeout']);
            $actualdate   = strtotime($row['actual_timeout']);
            if($actualdate <= $expecteddate){
                $undertime = round(abs ($actualdate - $expecteddate) / 3600,2) ; 
               $tundertime = $tundertime + $undertime ; 

            }

             $expecteddate = strtotime($row['expected_timeout']);
             $actualdate   = strtotime($row['actual_timeout']);
             if($actualdate >= $expecteddate){
                 $overtime = round(abs ($actualdate - $expecteddate) / 3600,2) ; 
                $tovertime = $tovertime + $overtime ; 

             }

             $actualstartdate   = strtotime($row['actual_timein']);
             $actualenddate   = strtotime($row['actual_timeout']);
             $workhrs = round(abs ($actualstartdate - $actualenddate) / 3600,2) ; 
             $totalwork = $totalwork +  $workhrs;


        }
            $totalwork = $totalwork  - $tovertime ; 
         
    }

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
                        <h1 class="h3 mb-0 text-gray-800">Teacher Attendance</h1>
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

                    <div class="align-items-start mb-4" style=" margin-left: 10px">
                        <div class="row">
                            <div class="col-5 ">
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <label>TEACHER ID:</label>
                                    </div>
                                    <div class="col-8">
                                     <input type="text"  form="srchform" name="teacherid" class="form-control " placeholder="Enter Teacher ID" required/>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <label>START DATE:</label>
                                    </div>
                                    <div class="col-8">
                                     <input type="date" form="srchform" name="startdate" class="form-control " placeholder="" required />
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <label>END DATE:</label>
                                    </div>
                                    <div class="col-8">
                                     <input type="date" form="srchform" name="enddate" class="form-control " placeholder="" required/>
                                    </div>
                                </div>

                                <div class="row mt-3 justify-content-center">
                                    <form id="srchform" class="col-6" >
                                        <button class="form-control btn btn-primary col-12">SEARCH</button>
                                    </form>
                                </div>
                                
                                <div class="row mt-3 p-3" style="border: 1px solid gray; border-radius:10px;">
                                    <div class="col-6 mt-2">
                                        <label>Total wroking hours:</label>
                                    </div>
                                    <div class="col-5">
                                     <input type="text" name="" class="form-control " placeholder="" readonly value="<?php echo $totalwork ;?>"/>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <label>Total late hours:</label>
                                    </div>
                                    <div class="col-5">
                                     <input type="text" name="" class="form-control " placeholder="" readonly value="<?php echo $tlate ;?>"/>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <label>Total undertime hours:</label>
                                    </div>
                                    <div class="col-5">
                                     <input type="text" name="" class="form-control " placeholder="" readonly value="<?php echo $tundertime ;?>"/>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <label>Total overtime hours:</label>
                                    </div>
                                    <div class="col-5">
                                     <input type="text" name="teacherid" class="form-control " placeholder="" readonly value="<?php echo $tovertime ;?>"/>
                                    </div>
                                </div>


                            </div>
                            <div class="col-6 row ml-5 p-2" style="border: 1px solid gray; border-radius:10px;">
                               
                                <div class="row col-12" >

                                    <div class="col-3" >

                                        <img src="<?php echo $tlocation ; ?>" alt="alternative" width="100" height="100"/> 
                                    </div>                             

                                    <div class="col-12 mt-2 ">
                                     <label  class="form-control mb-3">First Name: <?php echo $tfname ;?></label>
                                     <label  class="form-control">Last Name: <?php echo $tlname ;?> </label>
                                    </div>
                                </div>              
             
                                <div class="row col-12 mt-3">
                                    <div class="col-6 ">
                                         <label  class="form-control mb-3">Date of Birth: <?php echo $tdob ;?> </label>
                                    </div>
                                    <div class="col-6 ">
                                     <label  class="form-control">Department: <?php echo $tdepartment ;?> </label>
                                    </div>
                                </div>
                                <div class="row col-12 ">
                                    <div class="col-12 ">
                                         <label  class="form-control mb-3">Email : <?php echo $temail ;?> </label>
                                    </div>
                                </div>
                                <div class="row col-12 ">
                                    <div class="col-12 ">
                                         <label  class="form-control mb-3">Specialization : <?php echo $tspecialization ;?></label>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
            <div class="table-responsive">

        
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                        <h1 class="h5 mb-0 text-gray-800">Time Sheet</h1>
                    </div>
            <?php
            //Displaying data into tables
            $query ="SELECT * FROM time_attendance a LEFT JOIN teacher b ON a.teacher_id = b.teacher_id $paramaters ORDER BY a.teacher_id DESC";
            $query_run=mysqli_query($conn, $query);
            ?>
            <table id = "dataTableID" class="table table-bordered table table-striped" width = "100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="display:none;">DTR ID</th>
                        <th>TEACHER NAME</th>  
                        <th>STATUS</th>  
                        <th>SCHEDULE</th>
                        <th>CLOCK-IN</th>
                        <th>CLOCK-OUT</th> 
                        <th>LATE</th>          
                        <th>UNDERTIME</th>       
                        <th> OVERTIME </th>                             
                        <th> ACTION </th>                         
                    
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(mysqli_num_rows($query_run) > 0) {
                            while($row=mysqli_fetch_assoc($query_run))
                            {
                                ?>
                    <tr>
                        <td style="display:none;"><?php echo $row['ta_id']; ?></td>      
                        <td><?php echo $row['firstname'] . " " . $row['lastname'] ; ?></td>   
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['expected_timein'] . "<br>" . $row['expected_timeout']; ?></td>
                        <td><?php echo $row['actual_timein']; ?></td>
                        <td><?php echo $row['actual_timeout']; ?></td>
                        <td><?php 
                         $expecteddate = strtotime($row['expected_timein']);
                         $actualdate   = strtotime($row['actual_timein']);
                         if($actualdate >= $expecteddate){
                            echo $late = round(abs ($actualdate - $expecteddate) / 3600,2) ."hr"; 
                         }else{
                            echo "0hr";
                         }
                        ?></td>
                        <td><?php 
                         $expecteddate = strtotime($row['expected_timeout']);
                         $actualdate   = strtotime($row['actual_timeout']);
                         if($actualdate <= $expecteddate){
                            echo $undertime = round(abs ($actualdate - $expecteddate) / 3600,2) ."hr"; 
                         }else{
                            echo "0";
                         }
                        
                        ?></td>
                        <td><?php 
                          $expecteddate = strtotime($row['expected_timeout']);
                          $actualdate   = strtotime($row['actual_timeout']);
                          if($actualdate >= $expecteddate){
                             echo $overtime = round(abs ($actualdate - $expecteddate) / 3600,2) ."hr"; 
                          }else{
                             echo "0hr";
                          }
                         ?></td>
                       

                       

<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                        <td>
                            <!--Edit Pop Up Modal -->
                            <div class="modal fade" id="editManageDepartments" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Department Information</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                    <form action="manage-departments-function.php" method = "POST"> 

                                        <div class="modal-body">

                                                <input type="hidden" name= "edit_ID" id ="edit_ID">

                                                <div class="form-group">
                                                    <label for="#">Department Name</label>
                                                    <input type="text" class="form-control" id="edit_Department_Name" name="department_name" required>
                                                </div>

                                        </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="update_departments" class="btn btn-primary">Update</button>
                                                </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                            <button type="button" class="btn btn-success edit_btn" data-toggle="modal" data-target="#editManageDepartments " >Edit</button>
                        </td>


<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

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


