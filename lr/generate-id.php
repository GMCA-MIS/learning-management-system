<?php
    include('includes/lr_session.php');
    include('includes/header.php');
    include('includes/navbar.php');
    include('dbcon.php');
?>
<style>
    a {
        text-decoration: underline;
        /* Add underline to the anchor text */
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
                <h1 class="h3 mb-0 text-gray-800">Library Card</h1>
            </div>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - User Information -->
                <?php include('includes/lr_name.php'); ?>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_lcardkModal">
            <i class="fa fa-plus" aria-hidden="true"></i> Add New Card
            <?php
                include('manage-id-card-modal.php');
            ?>
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

<?php
    include('includes/scripts.php');
    include('includes/footer.php');
?>