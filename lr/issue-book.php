<?php
    include('includes/lr_session.php');
    include('includes/header.php');
    include('includes/navbar.php');
    include('dbcon.php');

?>

<!--Camera Scanner JS-->
<script type="text/javascript" src="js/instascan.min.js"></script>

<!--SweetAlert2-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css">

<!--Font Awesome-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
crossorigin="anonymous" referrerpolicy="no-referrer" />

<!--Bootstrap Bundle-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <center><div class="row">
            <form action="issue-book.php" method="post" class="form-group" id="divvideo">
            
                <div class="card col-6">
                    <center><video id="preview"></video></center>
                </div>
                <div class="input-group mb-5 col-6">
                    <input type="text" class="form-control" id="qr-text" name="book_id">
                </div>
            </form>
        </div></center><!--End of Cam Scanner-->



        <!--Data Table-->
        <div class="table-striped mx-3">
            <table id="example1" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Book No.</th>
                    <th>Book Title</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                <!--Table value from 'booklist' and 'student'-->
                <?php
                
                $server = "srv1320.hstgr.io";
                $username="u944705315_capstone2024";
                $password="Capstone@2024.";
                $dbname="u944705315_capstone2024";
                

                $conn = new mysqli($server,$username,$password,$dbname);
                $date = date('Y-m-d');
                $book_no = $_POST['book_id'];
                $book_title = '';
                $borrower = '';
                $status = '';
                $return = '';
                

                /*if($conn->connect_error){
                  die("Connection failed" .$conn->connect_error);
                }*/

                $sql ="SELECT * FROM booklist WHERE book_id='$book_no'";
                $query_run = mysqli_query($conn, $sql);

                if(mysqli_num_rows($query_run) > 0) {
                    
                    //Get title of the book and set as value of a variable
                    $book_title = $row['book_title'];

                    //Echo SweetAlert2
                    echo '<script>                         
                            Swal.fire({
                                title: "Book scanned successfully!",
                                icon: "success",
                                showConfirmButton: "true"
                                })
                          </script>';
                }
                else {
                    echo '<script>                         
                            Swal.fire({
                                title: "Cannot find the book.",
                                icon: "question",
                                showConfirmButton: "true"
                                })
                          </script>';

                }
                
                if(isset($_POST['book_id'])) {

                    $status = "Borrowed";
                    
                    while ($row = $query_run->fetch_assoc()) {
                        
                        $book_title = $row['book_title'];

                        ?>
                            <!--<form action="issue-book.php" method="POST">-->
                                <tr>
                                    <td class="col-1"><?php echo $row['book_id']; ?></td>
                                    <td class="col-6"><?php echo $row['book_title']; ?></td>
                                    <td class="col-2"><span class="badge bg-warning text-dark ml-1 mt-1 px-5 py-2"><?php echo $status; ?></span></td>
                                    <td class="col-3">
                                        <button class="btn btn-warning mr-3 ml-4" type="button" id="borrow" name="borrow" data-bs-toggle="modal" data-bs-target="#borrow_book">
                                            <i class="fa-solid fa-hand"></i>
                                        </button>
                                        <button class="btn btn-info mr-3 ml-4" type="button" id="view-deets" name="view-deets">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn btn-success mr-3 ml-4" type="button" id="return" name="return">
                                            <i class="fa-solid fa-book"></i>
                                        </button>
                                    </td>
                                </tr>
                            <!--</form>-->
                        
                    <?php

                    //Check student number if it exists in student table
                    if(isset($_POST['stud_no'])) {
                        $borrower = $_POST['stud_no'];

                        $sql ="SELECT * FROM student WHERE student_id='$borrower'";
                        $query_run = mysqli_query($conn, $sql);
                    }
                    if(mysqli_num_rows($query_run) > 0) {

                        $sql ="INSERT INTO borrowed_books (book_id, book_title, student_no, borrowed_date, status, returned_date) 
                        VALUES ($book_no, $book_title, $borrower, $date, $status, '')";
                        $query_run = mysqli_query($conn, $sql);
                    }
                    else {
                        echo '<script>                         
                                Swal.fire({
                                    title: "Cannot find Student No.",
                                    icon: "question",
                                    showConfirmButton: "true"
                                })
                            </script>';
                    }


                    
                    }
                }
                
                ?>

        
        <!--Script for Modal-->
        <script>
            $("#borrow").on("click",function(){
                
                $("#borrow_book").modal("show");
                
                })
        </script>

        <!-- Modal for Borrow button-->
        <form action="issue-book.php" method="POST">
        <div class="modal fade" role="dialog" id="borrow_book">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fa-solid fa-circle-question fa-2xl mr-3" style="color: #FFD43B;"></i>Borrow book?</h5>
                            <label for="stud_no">Student No.:</label>

                                <input type="text" class="form-control" placeholder="Enter Student No. here" name="stud_no">
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-success" value="Borrow" id="issue" name="issue"></input>
                    </div>
                </div>
            </div>
        </div>
        </form>


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
                    document.getElementById('qr-text').value=c;
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











