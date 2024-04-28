
<!-- Sidebar -->
<ul class="navbar-nav new-nav-bg sidebar sidebar-dark accordion" id="accordionSidebar">
<!-- Divider -->
<hr class="sidebar-divider my-0">
<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon">
    <img class="rounded-circle" src="<?php echo $imageLocation; ?>" alt="Teacher Image">
    </div>

</a>
<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->

<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'profile.php') echo 'active'; ?>">
  <a class="nav-link" href="profile.php">
  <i class='fas fa-user-alt'></i>
    <span>Profile</span>
  </a>
</li>
<!-- Divider -->
<hr class="sidebar-divider">

<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') echo 'active'; ?>">
  <a class="nav-link" href="index.php">
  <i class='fas fa-chalkboard-teacher'></i>
    <span>Classes</span>
  </a>
</li>


<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
     Create
</div>

<!-- <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'materials.php') echo 'active'; ?>">
  <a class="nav-link" href="materials.php">
  <i class='fas fa-pencil-alt'></i>
    <span>Materials</span>
  </a>
</li>

<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'announcements.php') echo 'active'; ?>">
  <a class="nav-link" href="announcements.php">
  <i class="fa fa-sticky-note"></i>
    <span>Announcements</span>
  </a>
</li> -->

<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'quiz.php') echo 'active'; ?>">
  <a class="nav-link" href="quiz.php">
  <i class="fa fa-sticky-note"></i>
    <span>Quiz</span>
  </a>
</li>

<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'exam.php') echo 'active'; ?>">
  <a class="nav-link" href="exam.php">
  <i class="fa fa-sticky-note"></i>
    <span>Exam</span>
  </a>
</li>
<!--
<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'assignments.php') echo 'active'; ?>">
  <a class="nav-link" href="manage-assigncourses.php">
  <i class='fas fa-tasks'></i>
    <span>Assignment</span>
  </a>
</li>


<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'quiz.php') echo 'active'; ?>">
  <a class="nav-link" href="manage-assigncourses.php">
    <i class="fas fa-book-reader" aria-hidden="true"></i>
    <span>Quiz</span>
  </a>
</li>


<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'exam.php') echo 'active'; ?>">
  <a class="nav-link" href="manage-assigncourses.php">
    <i class="fas fa-book-reader" aria-hidden="true"></i>
    <span>Exam</span>
  </a>
</li> -->

<!-- Divider -->
<hr class="sidebar-divider">


<!-- Nav Item - Pages Collapse Menu -->

<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'calendar.php') echo 'active'; ?>">
  <a class="nav-link" href="calendar.php">
  <i class='far fa-calendar-alt'></i>
    <span>School Calendar</span>
  </a>
</li>

<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'library.php') echo 'active'; ?>">
  <a class="nav-link" href="library.php">
  <i class="fa fa-book" aria-hidden="true"></i>
    <span>GMC</span><span> E-Library </span>
  </a>
</li>



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
                      <button class="btn btn-success" type="button" data-dismiss="modal">Cancel</button>
                      <a class="btn btn-danger" href="logout.php">Logout</a>
                  </div>
      </div>
  </div>
</div>