<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');


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

$paramaters = " WHERE  DATE(a.expected_timein) = DATE(NOW()) AND NOT actual_timein = '0000-00-00 00:00:00' "; 

?>



<script type="text/javascript" src="js/instascan.min.js"></script>

<style>
    a {
        text-decoration: none;
        /* Remove underline to the anchor text */
        color: black;
        /* Set the text color to blue */
    }

    a:hover {
        color: brown;
    }
    label {
        margin-top: 5%;
    }
</style>



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
                <div class="row justify-content-center">
                <form action="check-in-out_outside.php" method="post" class="form-group" id="divvideo">
                    <div class="card">
                        <video id="preview"></video>
                    </div>
                    <div class="card">
                        <input type="text" class="form-control" name="stud_no" id="text"></input>
                    </div>
                    <div class="card">
                        <center><b>CURRENT DATE: <?php echo date('Y-m-d') ?> </b></center>
                    </div>
                    
                </form>
            </div>

            <?php
                if(isset($_SESSION['error'])){
                    echo "
                        <div class='alert alert-danger alert-dismissible' style='background:red;color:#fff'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                <h4><i class='icon fa fa-warning'></i> Error!</h4>
                            ".$_SESSION['error']."
                        </div>
                            ";
                    unset($_SESSION['error']);
                    }
                    
                    if(isset($_SESSION['success'])) {
                    echo "
                        <div class='alert alert-success alert-dismissible' style='background:green;color:#fff'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                <h4><i class='icon fa fa-check'></i> Success!</h4>
                            ".$_SESSION['success']."
                        </div>
                            ";
                    unset($_SESSION['success']);
                    }
              
            ?>
                    
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
                       
                       

                       

<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                        


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
let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
Instascan.Camera.getCameras().then(function(cameras){
    if(cameras.length > 0 ){
        scanner.start(cameras[0]);
    } else{
        alert('No cameras found');
    }

}).catch(function(e) {
    console.error(e);
});

scanner.addListener('scan',function(c){
    document.getElementById('text').value=c;
    document.forms[0].submit();
});
</script>

<!--Time-->
<script type="text/javascript">
    date_default_timezone_set('Asia/Manila');
var timestamp = '<?=time();?>';
function updateTime(){
$('#time').html(Date(timestamp));
timestamp++;
}
$(function(){
setInterval(updateTime, 1000);
});
</script>


<script>
    $(document).ready(function() {
        $('#example1').DataTable();
    } );


</script>
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


