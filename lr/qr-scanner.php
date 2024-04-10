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


<?php
    include('includes/scripts.php');
    include('includes/footer.php');
?>