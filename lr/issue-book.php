<?php
    include('includes/lr_session.php');
    include('includes/header.php');
    include('includes/navbar.php');
    include('dbcon.php');

?>

<!--Camera Scanner JS-->
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
            <form action="checkmate.php" method="post" class="form-group" id="divvideo">
                <div class="card">
                    <video id="preview"></video>
                </div>
                <div class="card">
                    <input type="text" class="form-control" name="book_id" id="text"></input>
                </div>
            </form>
        </div><!--End of Cam Scanner-->


        <!--Book Info-->
        <div class="row">
            <h4>Book Information</h4>
        </div>


        <!--Buttons-->
        <div class="row">
            <button type="button" class="btn btn-primary">Issue</button>
        </div>


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







