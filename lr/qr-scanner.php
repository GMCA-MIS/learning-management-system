<?php
    include('includes/lr_session.php');
    include('includes/header.php');
    include('includes/navbar.php');
    include('dbcon.php');
?>

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
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow newtopbar"
            style="margin-bottom:0;">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4"
                style="margin-top: 27px; margin-left: 10px;">
                <h1 class="h3 mb-0 text-gray-800">QR Scanner</h1>
            </div>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - User Information -->
                <?php include('includes/lr_name.php'); ?>

            </ul>
        </nav>
        <!-- End of Topbar -->

        <!--Camera Preview-->
        <div class="row justify-content-center">
            <form action="CheckInOut.php" method="post" class="form-group" id="divvideo">
                <div class="card">
                    <video id="preview"></video>
                </div>
                <div class="card">
                    <input type="text" class="form-control" name="studentID" id="text"></input>
                </div>
            </form>
        </div>


        <!--Error QR message-->
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

          <!--Data Table-->
          <div class="table-striped">
            <table id="example1" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>User's ID</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Logdate</th>
                </tr>
            </thead>
            <tbody>

                <!--Table value from 'attendance' and 'student'-->
                <?php
                
                $server = "srv1320.hstgr.io";
                $username="u944705315_capstone2024";
                $password="Capstone@2024.";
                $dbname="u944705315_capstone2024";
                

                $conn = new mysqli($server,$username,$password,$dbname);
                $date = date('Y-m-d');

                  if($conn->connect_error){
                  die("Connection failed" .$conn->connect_error);
                }

                $sql ="SELECT * FROM attendance LEFT JOIN cards ON attendance.stud_no=cards.stud_no WHERE logdate='$date'";
                $query = $conn->query($sql);
                  while ($row = $query->fetch_assoc()){
                ?>
                    <tr>
                      <td><?php echo $row['firstname'];?></td>
                      <td><?php echo $row['stud_id'];?></td>
                      <td><?php echo $row['timein'];?></td>
                      <td><?php echo $row['timeout'];?></td>
                      <td><?php echo $row['logdate'];?></td>
                    </tr>
                <?php
                }
                ?>

                <!--Camera Scanner Script-->
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
                new DataTable('#example1');
                </script>

            </tbody>
            </table>
          </div>
    </div>


<?php
    include('includes/scripts.php');
    include('includes/footer.php');
?>