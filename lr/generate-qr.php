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
                <h1 class="h3 mb-0 text-gray-800">Library Card: QR Code Generator</h1>
            </div>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - User Information -->
                <?php include('includes/lr_name.php'); ?>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="modal-body">
            
            <div></div>
            <div class="tab-content" id="assignmentTabsContent">
                <div class="tab-pane fade" id="uploadAssignment" role="tabpanel" aria-labelledby="uploadTab">
            </div>
            <div class="tab-pane fade show active" id="createAssignment" role="tabpanel" aria-labelledby="createTab">
                <div class="card-body">

                    <div class="table-responsive">

                        
                            <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_lcardkModal">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add New Card
                            </button>
                            <a href="generate-id.php">
                                <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#gen_lcardModal">
                                    <i class="fa fa-address-card" aria-hidden="true"></i> Generate ID Card
                                </button>
                            </a>
                            <a href="generate-qr.php">
                                <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#gen_qrModal">  
                                    <i class="fa fa-qrcode" aria-hidden="true"></i> Generate QR Code
                                </button>
                            </a>
                        </td>

                        <div class="d-sm-flex align-items-center justify-content-between mb-2"
                            style="margin-top: 10px; margin-left: 10px;">
                            <h1 class="h5 mb-0 text-gray-800"></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content: QR -->
        <?php
            $first_name = "";
              
              if (isset($_POST["generate"])) {
                  $first_name = $_POST["first_name"];
        }
        ?>

        <div class="container">
            <div class="row">
                <div class="col-6">
                    <label for="generate">Student ID Card No.</label>
                    <form autocomplete="off" action="generate-qr.php" method="post">
                        <input type="text" class="form-control col-6" value="<?php echo $first_name;?>" name="first_name" placeholder="Type your ID no. here">
                        <br>
                        <br>
                        <button type="submit" class="btn btn-warning" name="generate"><span class="fa fa-cog mr-3"></span>Generate</button>
                    </form>
                </div>
            
                <div class="qr-card">
                    <div class="qr-img card">
                        <?php echo '<img src="' . $PNG_TEMP_DIR . basename($filename) . '" />'; ?>
                    </div>
                
                </div>
            </div>
        </div>


      </div>
    </div>

<?php
    include('includes/scripts.php');
    include('includes/footer.php');
?>