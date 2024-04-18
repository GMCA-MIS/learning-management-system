<?php
    include('includes/lr_session.php');
    include('includes/header.php');
    include('includes/navbar.php');
    include('dbcon.php');

?>

<!--Camera Scanner JS-->
<script type="text/javascript" src="js/instascan.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


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
                <h1 class="h3 mb-0 text-gray-800">Book Borrowing</h1>
            </div>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - User Information -->
                <?php include('includes/lr_name.php'); ?>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!--QR Code Cam Scanner-->
        <div class="row justify-content-center">
            <form action="issue-book.php" method="post" class="form-group" id="divvideo">
                <div class="card">
                    <video id="preview"></video>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-issue" type="button">Issue</button>
                        <button class="btn btn-return" type="button">Return</button>
                    </div>
                </div>
                <!--<div class="card">
                    <input type="text" class="form-control" name="book_id" id="text" data-toggle="modal" data-target="#myModal"></input>
                </div>-->
            </form>
        </div><!--End of Cam Scanner-->


        <!--Data Table-->
        <div class="table-striped">
            <table id="example1" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Book No.</th>
                    <th>Book Title</th>
                    <th>Student No.</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th></th>
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
                $book_no = $_POST['book_id'];
                $borrower = $_POST['stud_no'];
                $status = '';
                $return = '';

                if($conn->connect_error){
                  die("Connection failed" .$conn->connect_error);
                }

                $sql ="SELECT * FROM booklist WHERE book_id='$book_no'";
                $sqll = "SELECT * FROM student WHERE student_id='$borrower'";

                $query = $conn->query($sql);

                while ($row = $query->fetch_assoc()){

                if(isset($_POST["book_id"])){
                    echo '<div class="alert alert-success justify-content-center mr-1" role="alert">
                            <strong><div class="col-7">Book successfully scanned.</div></strong>
                          </div>';
                          
                }

                if(isset($_POST["issue"])) {
                
            
                         

                            //if($query->num_rows < 1){
                                //$_SESSION['error'] = 'Cannot find QR Code number '.$book_no;
                            //}else{
                                $status = "<span class='badge bg-warning' style='color: #FFF;'>Borrowed</span>";
                            if($query->num_rows>0){
        
                            }else{
                                $return = date('Y-m-d');
                            }
                } 
                  
                ?>
                    <tr>
                      <td><?php echo $row['book_id'];?></td>
                      <td><?php echo $row['book_title'];?></td>
                      <td><?php echo $borrower; ?></td>
                      <td><?php echo $date; ?></td>
                      <td><?php echo $return ;?></td>
                      <td><?php echo $status ;?></td>
                    </tr>
                <?php
                }
                //}
                //}
                header("location: issue-book.php");
                $conn->close();
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

                <!--Script for DataTable-->
                <script>
                    new DataTable('#example1');
                </script>


                    
                    </table>
                </div>
            </div>


            <!-- The Modal -->
            <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Modal Heading</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Modal body..
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

                </div>
            </div>
            </div>



<?php
    include('includes/scripts.php');
?>










