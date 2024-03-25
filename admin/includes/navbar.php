<!-- Sidebar -->
<ul class="navbar-nav new-nav-bg sidebar sidebar-dark accordion" id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../admin/index.php">
    <div class="sidebar-brand-icon">
      <img src="img/gmlogo.png" alt="">
    </div>
    <div class="sidebar-brand-text mx-0">GMC Admin</div>
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


  <!-- <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'manage-students.php') echo 'active'; ?>">
  <a class="nav-link" href="manage-students.php">
    <i class="fas fa-book-reader" aria-hidden="true"></i>
    <span>Manage Students</span>
  </a>
</li> -->



  <!-- <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'manage-departments.php') echo 'active'; ?>">
  <a class="nav-link" href="manage-departments.php">
  <i class='far fa-building'></i>
    <span>Departments</span>
  </a>
</li> -->

  <!-- <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'manage-class.php') echo 'active'; ?>">
  <a class="nav-link" href="manage-class.php">
  <i class='fas fa-chalkboard'></i>
    <span>Sections</span>
  </a>
</li> -->

  <!-- <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'manage-courses.php') echo 'active'; ?>">
  <a class="nav-link" href="manage-courses.php">
  <i class='fas fa-book-open'></i>
    <span>Manage Subjects</span>
  </a>
</li>

<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'manage-assigncourses.php') echo 'active'; ?>">
  <a class="nav-link" href="manage-assigncourses.php">
    <i class="fas fa-book-reader" aria-hidden="true"></i>
    <span>Assign Subjects</span>
  </a>
</li> -->

  <!-- <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'manage-teachers.php') echo 'active'; ?>">
  <a class="nav-link" href="manage-teachers.php">
  <i class="fas fa-chalkboard-teacher"></i>
    <span>Manage Teachers</span>
  </a>
</li> -->

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item <?php if (in_array(basename($_SERVER['PHP_SELF']), ['manage-departments.php', 'manage-teachers.php'])) echo 'active'; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapses" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-chalkboard-teacher"></i>
      <span>Manage Teachers</span>
    </a>
    <div id="collapses" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Manage Teachers</h6>
        <a class="collapse-item" href="manage-departments.php?id=<?php echo $school_year ?>"> <i class='far fa-building'></i> Department List</a>
        <a class="collapse-item" href="manage-teachers.php?id=<?php echo $school_year ?>"> <i class="fas fa-chalkboard-teacher"></i> Teacher List </a>
      </div>
    </div>
  </li>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item <?php if (in_array(basename($_SERVER['PHP_SELF']), ['manage-class.php', 'manage-students.php'])) echo 'active'; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-book-reader" aria-hidden="true"></i>
      <span>Manage Students</span>
    </a>
    <div id="collapse4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Manage Students</h6>
        <a class="collapse-item" href="manage-strand.php?id=<?php echo $school_year ?>"> <i class='fas fa-chalkboard'></i> Strand List</a>
        <a class="collapse-item" href="manage-students.php?id=<?php echo $school_year ?>"><i class="fas fa-book-reader" aria-hidden="true"></i> Student List </a>
      </div>
    </div>
  </li>



  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item <?php if (in_array(basename($_SERVER['PHP_SELF']), ['manage-courses.php', 'manage-assigncourses.php'])) echo 'active'; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapseTwo">
      <i class='fas fa-book-open'></i>
      <span>Manage Subjects</span>
    </a>
    <div id="collapse3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Manage Subjects</h6>
        <a class="collapse-item" href="manage-courses.php?id=<?php echo $school_year ?>"> <i class='fas fa-book-open'></i> Subject List</a>
        <a class="collapse-item" href="manage-assigncourses.php?id=<?php echo $school_year ?>"> <i class="fas fa-book-reader" aria-hidden="true"></i> Assign Subject</a>
      </div>
    </div>
  </li>

  <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'manage-coordinators.php') echo 'active'; ?>">
    <a class="nav-link" href="manage-coordinators.php?id=<?php echo $school_year ?>">
      <i class='fas fa-user-alt'></i>
      <span>Manage Other Users</span>
    </a>
  </li>
  <!-- tor req -->

  <!--  -->
  <li class="nav-item <?php if (in_array(basename($_SERVER['PHP_SELF']), ['tor_admin.php', 'tor_transaction_confirm.php'])) echo 'active'; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsetor" aria-expanded="true" aria-controls="collapseTwo">
      <i class='fas fa-book-open'></i>
      <span>TOR Requests</span>
    </a>
    <div id="collapsetor" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Manage TOR Requests</h6>
        <a class="collapse-item" href="tor_admin.php?id=<?php echo $school_year ?>"> Requests Approval</a>
        <a class="collapse-item" href="tor_transaction_confirm.php?id=<?php echo $school_year ?>"> </i>Payment Confirmation</a>
      </div>
    </div>
  </li>


  <!--  -->

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item <?php if (in_array(basename($_SERVER['PHP_SELF']), ['sectors.php', 'offices.php', 'process.php'])) echo 'active'; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class='fas fa-school'></i>
      <span>School</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Select Classification</h6>
        <a class="collapse-item" href="calendar.php?id=<?php echo $school_year ?>"><i class='far fa-calendar'></i> School Calendar</a>
        <a class="collapse-item" href="schoolyear.php?id=<?php echo $school_year ?>"><i class='fas fa-graduation-cap'></i> School Year</a>
        <a class="collapse-item" href="content.php?id=<?php echo $school_year ?>"><i class="fa fa-edit"></i> Website Content</a>
      </div>
    </div>
  </li>



  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

  <hr class="sidebar-divider">

  <li class="nav-item">
    <a class="nav-link" href="logout.php" data-toggle="modal" data-target="#logoutModal" style="font-size:13.6px;">
      <i class="fa fa-power-off" aria-hidden="true"></i>
      Logout
    </a>
  </li>

  <!--<li class="nav-item">
  <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
  <i class="fa fa-power-off" aria-hidden="true"></i>
    <span>Logout</span>
  </a>
</li>-->



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