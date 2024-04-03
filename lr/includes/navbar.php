<!-- Sidebar -->
<ul class="navbar-nav new-nav-bg sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
    <div class="sidebar-brand-icon">
        <img src="../img/gmlogo.png" alt="">
    </div>
    <div class="sidebar-brand-text mx-3">GMC LR</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') echo 'active'; ?>">
  <a class="nav-link" href="index.php">
  <i class="fas fa-fw fa-tachometer-alt"></i>
    <span> Dashboard </span>
  </a>
</li>

<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'library.php') echo 'active'; ?>">
  <a class="nav-link" href="library.php">
  <i class="fa fa-book" aria-hidden="true"></i>
    <span>GMC</span><span> E-Library </span>
  </a>
</li>

<hr class="sidebar-divider">
<!-- Heading -->
<div class="sidebar-heading">
    Library Menu
</div>




<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'manage-categories.php') echo 'active'; ?>">
  <a class="nav-link" href="manage-categories.php">
  <i class="fas fa-chalkboard-teacher"></i>
    <span>Manage Categories</span>
  </a>
</li>

<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'manage-books.php') echo 'active'; ?>">
  <a class="nav-link" href="manage-books.php">
    <i class="fas fa-book-reader" aria-hidden="true"></i>
    <span>Manage Books</span>
  </a>
</li>

<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'manage-book-approval.php') echo 'active'; ?>">
  <a class="nav-link" href="manage-book-approval.php">
    <i class="fas fa-book-reader" aria-hidden="true"></i>
    <span>Manage Book Approval</span>
  </a>
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