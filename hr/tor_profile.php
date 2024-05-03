<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
?>
<?php
// Include your database connection file here (e.g., dbcon.php)
include('dbcon.php');

// Check if a user ID is provided in the URL (you may want to add more error handling)
if (isset($_GET['or_number'])) {
    $or_number = $_GET['or_number'];

    // Query to retrieve user data
    $query = "SELECT * FROM tor WHERE or_number = $or_number";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Fetch user data
        $row = mysqli_fetch_assoc($result);

        if ($row) {
           $lname = $row['lastname'];
           $fname = $row['firstname'];
           $middle_initial = $row['middle_initial'];
           $email = $row['email'];
           $address  = $row['address'];
           $course = $row['course'];
           $dob = $row['dob'];
           $pob = $row['pob'];
           $highschool = $row['highschool'];
           $other_colleges = $row['other_colleges'];
           $highschool_address = $row['highschool_address'];
           $gmc_admission_date = $row['gmc_admission_date'];
           $creds_submitted = $row['creds_submitted'];
           $sem_attended = $row['sem_attended'];
           $tor_purpose = $row['tor_purpose'];

        } else {
            echo "User not found.";
        }
    } else {
        echo "Error fetching user data: " . mysqli_error($conn);
    }
} else {
    echo "User ID not provided.";
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOR Request Information</title>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

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
                        <h1 class="h3 mb-0 text-gray-800">TOR Request Information</h1>
                    </div>
                    


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <?php include ('includes/admin_name.php'); ?>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="card-body">

                <div class="container light-style flex-grow-1 container-p-y">
        <h6 class="font-weight-bold py-3 mb-4">
            <a href="tor_admin.php"> Back</a>
        </h6>
        
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links" style = "border-bottom: 1px gray solid;">
                        <div class="card-body media align-items-center" style = "border-bottom: 1px gray solid;">
                            <img src="<?php echo $photo?>" alt="" class="rounded-circle d-block mx-auto" style="width: 150px;">
                        </div>
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">TOR Request Information</a>
                        
                        </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label"><p><?php  echo "<strong>OR NUMBER:</strong> $or_number";?></p></label>
                                </div>
                                <div class="form-group">
                                    <label class="form-label"><p><?php  echo "<strong>NAME:</strong> $fname"." $lname";?></p></label>
                                </div>
                                <div class="form-group">
                                    <label class="form-label"><?php  echo "<p><strong>EMAIL: </strong> $email</p>";?></label>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><?php  echo "<p><strong>ADDRESS: </strong>$address</p>";?></label>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><?php  echo "<p><strong>COURSE: </strong>$course</p>";?></label>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><?php  echo "<p><strong>DATE OF BIRTH: </strong> $dob</p>";?></label>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><?php  echo "<p><strong>PLACE OF BIRTH: </strong> $pob</p>";?></label>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><?php  echo "<p><strong>HIGHSCHOOL: </strong> $highschool</p>";?></label>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><?php  echo "<p><strong>OTHER COLLEGES: </strong> $other_colleges</p>";?></label>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><?php  echo "<p><strong>HIGHSCHOOL ADDRESS: </strong> $highschool_address</p>";?></label>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><?php  echo "<p><strong>GMC ADMISSION DATE: </strong> $gmc_admission_date</p>";?></label>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><?php  echo "<p><strong>CREDENTIALS SUBMITTED: </strong> $creds_submitted</p>";?></label>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><?php  echo "<p><strong>SEMESTER ATTENDED: </strong> $sem_attended</p>";?></label>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><?php  echo "<p><strong>TOR PURPOSE: </strong> $tor_purpose</p>";?></label>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <h4> TOR Request Information </h4>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><?php  echo "<p><strong>Class Enrolled:</strong> STEM 11-A</p>";?></label>
                                </div>

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>
</div>



<?php
include('includes/scripts.php');
include('includes/footer.php');
?>



    


