<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow newtopbar" style="margin-bottom:0;">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                
                 <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                        <h1 class="h3 mb-0 text-gray-800">Website Content Management</h1>
                    </div>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <?php include ('includes/admin_name.php'); ?>

                    </ul>

                </nav>
                <!-- End of Topbar -->

     <!-- Begin Page Content -->
     <div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    
</div>

<!-- Content Row -->
<div class="row">


    <!-- Mission Content Card-->
    <?php
// Fetch all mission content from the database
$query = "SELECT * FROM content";
$query_run = mysqli_query($conn, $query);
$missions = array();

$counterid = "";

if (mysqli_num_rows($query_run) > 0) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        $missions[] = $row;
    }
}
?>
<?php foreach ($missions as $mission) { ?>
    <td>
        <div class="col-xl-6 col-md-6 mb-4" data-toggle="modal" data-target="#contentModal<?php echo $mission['content_id']; ?>">
            <div class="card border-left-sector shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-primary text-uppercase mb-1" >
                                <center><?php echo $mission['title']; ?></center>
                            </div>
                            <div class="h6 mb-0 text-gray-800">
                                <?php echo $mission['content']; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </td>

    <!-- The Modal for this specific mission -->
    <div class="modal fade" id="contentModal<?php echo $mission['content_id']; ?>" tabindex="-1" role="dialog"
        aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Edit Mission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="managecontent.php"> <!-- Replace with your form handling script -->
                    <input type="hidden" class="form-control" id="content_id" name="content_id" value="<?php echo $mission['content_id']; ?>">
                        <div class="form-group">
                            <label for="missionTitle">Title</label>
                            <input type="text" class="form-control" id="missionTitle" name="missionTitle" value="<?php echo $mission['title']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="missionContent">Content</label>
                            <textarea class="form-control" id="<?php echo "description" . $counterid; ?>" name="missionContent" rows="5"><?php echo $mission['content']; ?></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="update_content" value="Save"> <!-- Use input type="submit to submit the form -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $counterid++; } ?>


    
</div>                       

<!-- Content Row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php
include('includes/scripts.php');
include('includes/footer.php');
?>



