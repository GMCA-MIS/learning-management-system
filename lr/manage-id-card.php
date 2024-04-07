<?php
include('includes/lr_session.php');
include('includes/header.php');
include('includes/navbar.php');
include('dbcon.php');
?>

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

        <!--Buttons-->
        <div class="row mb-5">
          <div class="btn-group">
            <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_lcardModal">
                <i class="fa fa-plus" aria-hidden="true"></i> Add New Card
            </button>
            <a href="generate-id.php">
                <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_lcardModal">
                    <i class="fa fa-plus" aria-hidden="true"></i> Generate ID Card
                </button>
            </a>
            <a href="generate-qr.php">
                <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_lcardModal">
                    <i class="fa fa-plus" aria-hidden="true"></i> Generate QR Code
                </button>
            </a>
          </div>
        </div>

        <!--Data Table-->
        <div class="table-striped">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
              <thead>
                  <tr>
                      <th>Student No.</th>
                      <th>Name</th>
                      <th>ID Card No.</th>
                      <th>Actions</th>
                  </tr>
              </thead>
              <tbody>

                  <?php 
                  $sql = "SELECT * FROM `cards` order by 1 DESC";
                  $result = mysqli_query($conn, $sql);
                  $sno = 0;
                    
                    while($row = mysqli_fetch_assoc($result)){
                  $sno = $sno + 1;
                      echo "<tr>
                              <th scope='row'>". $sno . "</th>
                              <td>". $row['name'] . "</td>
                              <td>". $row['id_no'] . "</td>
                              <td> <button class='edit btn btn-sm btn-success col-5' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-danger col-5' id=d".$row['sno'].">Delete</button></td>
                            </tr>";
                  } 
                  ?>
    
              </tbody>
          </table>
        </div>