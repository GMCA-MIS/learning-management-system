<!-- Sidebar -->
<ul class="navbar-nav new-nav-bg sidebar sidebar-dark accordion" id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon">
      <img src="img/gmlogo.png" alt="">
    </div>
    <div class="sidebar-brand-text mx-0">GMC Accountant</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') echo 'active'; ?>">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>


  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Admin Menu
  </div>


  <?php
  include('dbcon.php');
  $school_year_query = mysqli_query($conn, "select * from school_year order by school_year_id DESC") or die(mysqli_error());
  $school_year_query_row = mysqli_fetch_array($school_year_query);
  $school_year = $school_year_query_row['school_year_id'];
  ?>


  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item <?php if (in_array(basename($_SERVER['PHP_SELF']), ['manage-students-enlisted.php', 'manage-students.php','manage-stud-transcation.php'])) echo 'active'; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-book-reader" aria-hidden="true"></i>
      <span>Manage Transactions</span>
    </a>
    <div id="collapse4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Manage Students</h6>
        <a class="collapse-item" href="manage-students-enlisted.php?id=<?php echo $school_year ?>"><i class="fas fa-book-reader" aria-hidden="true"></i> Students - Enlisted   </a>
        <a class="collapse-item" href="manage-students.php?id=<?php echo $school_year ?>"><i class="fas fa-book-reader" aria-hidden="true"></i> Students - Enrolled </a>
        <!--<a class="collapse-item" href="manage-archive-students.php?id=<?php echo $school_year ?>"><i class="fas fa-book-reader" aria-hidden="true"></i> Archive Student List </a>-->
      </div>
    </div>
  </li>

  <li class="nav-item <?php if (in_array(basename($_SERVER['PHP_SELF']), ['manage-typeoffees.php','manage-componentfees.php'])) echo 'active'; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsetor2" aria-expanded="true" aria-controls="collapseTwo">
      <i class='fas fa-book-open'></i>
      <span>Components & Fees</span>
    </a>
    <div id="collapsetor2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Components & Fees</h6>
        <!-- <a class="collapse-item" href="tor_admin.php?id=<?php echo $school_year ?>"> Requests Approval</a> -->
        <a class="collapse-item" href="manage-typeoffees.php?id=<?php echo $school_year ?>"> </i> - Type Fees</a>
        <a class="collapse-item" href="manage-componentfees.php?id=<?php echo $school_year ?>"> </i> - Component Fees</a>

      </div>
    </div>
  </li>


  <li class="nav-item <?php if (in_array(basename($_SERVER['PHP_SELF']), ['tor_admin.php', 'tor_transaction_confirm.php'])) echo 'active'; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsetor" aria-expanded="true" aria-controls="collapseTwo">
      <i class='fas fa-book-open'></i>
      <span>TOR Requests</span>
    </a>
    <div id="collapsetor" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Manage TOR Requests</h6>
        <!-- <a class="collapse-item" href="tor_admin.php?id=<?php echo $school_year ?>"> Requests Approval</a> -->
        <a class="collapse-item" href="tor_transaction_confirm.php?id=<?php echo $school_year ?>"> </i>Payment Confirmation</a>
      </div>
    </div>
  </li>

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

  <hr class="sidebar-divider">

  <li class="nav-item">
    <a class="nav-link"  data-toggle="modal" data-target="#logoutModal" style="font-size:13.6px;">
      <i class="fa fa-power-off" aria-hidden="true"></i>
      Logout
    </a>
  </li>



</ul>

<!--End of sidebar-->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Logout?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Are you sure you want to logout?</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="logout.php">Logout</a>
      </div>
    </div>
  </div>
</div>