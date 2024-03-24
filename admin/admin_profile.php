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
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                <h1 class="h3 mb-0 text-gray-800">Profile</h1> 
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

        </div>    
        
        <?php
// SQL query to fetch data from both user and department tables
$query = "SELECT * FROM users WHERE user_id = $user_id";

// Execute the query and get the result
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Check if there are rows in the result set
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Access the columns by their names
            $user_id = $row['user_id'];
            $username = $row['username'];
            $password = $row['password'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $location = $row['location'];
         
         

            // Output or use the retrieved data as needed
        }
    } else {
        echo "No records found for teacher ID: $user_id";
    }
} else {
    echo "Query execution failed: " . mysqli_error($conn);
}
?>



        
        <div class="container light-style flex-grow-1 container-p-y">

        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
            <div class="side col-md-3 pt-0">
                <div>
                <img class="rounded mx-auto d-block img-fluid mt-3" src="<?php echo $location ?>" alt="" style="max-width: 200px;">
                
                <div class="text-center mt-3">
                <div class="media-body ml-1 d-block" data-toggle="tooltip" data-placement="top" title="Allowed JPG, PNG. Max size of 800K">


    <button type="button" class="btn btn-success " data-toggle="modal" data-target="#picture"> Upload new photo</button>

    &nbsp;
</div>

</div>

                </div>
                    <hr>
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">Change password</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-info">Information</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">

                            <hr class="border-light m-0">
                            <div class="card-body">
                                <div class="header">
                                    <h2 style="color: black;">General Information</h2>
                                </div>
                                <hr>

                                <div class="form-group">
                                    <label class="form-label">
                                        <span class="info-label">Name:</span>
                                        <?php echo $firstname . ' ' . $lastname ?>
                                    </label>
                                </div>

                                <!-- <div class="form-group">
                                    <label class="form-label">
                                        <span class="info-label">Date of Birth:</span>
                                        <?php
                                            $dob ; 
                                            echo date_create($dob)->format('F d, Y');
                                        ?>
                                    </label>
                                </div> -->

                                <!-- <div class="form-group">
                                    <label class="form-label">
                                        <span class="info-label">Specialization:</span>
                                        <?php echo $specialization ?>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <span class="info-label">Email:</span>
                                        <?php echo $email ?>
                                    </label>
                                </div> -->


                            </div>

                        </div>
                        <div class="tab-pane fade" id="account-change-password">
    <div class="card-body pb-2">
        <div class="header">
            <h2 style="color: black;">Password Settings</h2>
        </div>
        <hr>
        <form method="post" action = "">
            <div class="form-group">
                <label class="form-label">Current password</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">New password</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Repeat new password</label>
                <input type="password" name="repeat_password" class="form-control" required>
            </div>
            <button type="submit" name="update_password" class="btn btn-success">Update Password</button>
        </form>
    </div>
</div>


                        <!-- <div class="tab-pane fade" id="account-info">
                            <div class="card-body pb-2">
                            <div class="header">
                                    <h2 style="color: black;">Information</h2>
                                </div>
                                <hr>

                                <div class="form-group">
                                    <label class="form-label">
                                        <span class="info-label">Department:</span>
                                        <?php echo $department_name ?>
                                    </label>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label justify-content-between">Bio: <button data-toggle="modal" data-target="#editprofileModal" class="btn btn-success">
                                        <i class="fas fa-edit"></i> </button></label>
                                    <div class="rectangular-box ">
                                        
                                        <?php echo $bio ?>
                                    </div>
                                </div>

                            </div>
                        </div> -->

                    </div>
                </div>
            </div>
                     <div class="card-footer"></div>
        </div>
    </div>
    


    <div class="modal fade" id="editprofileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Bio</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form class="" action="" method="post">
                                                <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="desc">Bio</label>
                                                    <textarea class="form-control" id="description" name="desc" rows="4" max-length="5000" required><?php echo $bio; ?></textarea>
                                                </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="update_bio" class="btn btn-success">Update</button>
                                                </div>
                                            </form>
                                    </div> <!--modal content -->
                                </div> <!--modal dialog -->
                    </div>  <!--modal fade -->





    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
        <!-- Content Row -->

    </div>
    <!-- /.container-fluid -->

    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>

<div class="modal fade" id="picture" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Profile Picture</h5>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <center>
                        <div class="form-group">
                            <input name="image" class="form-control" type="file" id="fileInput" required>
                        </div>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="change">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>
<!-- End of Main Content -->

<?php
                            if (isset($_POST['change'])) {
                               

                                $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
                                $image_name = addslashes($_FILES['image']['name']);
                                $image_size = getimagesize($_FILES['image']['tmp_name']);

                                move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/" . $_FILES["image"]["name"]);
                                $location = "../uploads/" . $_FILES["image"]["name"];
								
								mysqli_query($conn,"update  users set location = '$location' where user_id  = '$user_id' ")or die(mysqli_error());
								
								?>
 
								<script>
								window.location = "admin_profile.php";  
								</script>

                       <?php     }  ?>




<?php
if (isset($_POST['update_password'])) {
    // Check if the 'update_password' button was clicked

    // Retrieve the entered passwords
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $repeatPassword = $_POST['repeat_password'];

    // Ensure you have a valid database connection
    // Include your database connection script here, e.g., include('dbcon.php');

    // Assuming you already have a valid $user_id

    // Check if the current password is correct (you'll need to fetch the current hashed password from the database)
    $query = "SELECT password FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($currentPassword, $hashedPassword)) {
        // Current password is correct

        if (strlen($newPassword) >= 8 && preg_match('/[A-Z]/', $newPassword)) {
            // New password meets the criteria

            if ($newPassword === $repeatPassword) {
                // Check if the new password is different from the current password
                if ($newPassword !== $currentPassword) {
                    // Hash the new password
                    $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);

                    // Update the password in the database
                    $updateQuery = "UPDATE users SET password = ? WHERE user_id = ?";
                    $stmt = $conn->prepare($updateQuery);
                    $stmt->bind_param("si", $hashedNewPassword, $user_id);

                    if ($stmt->execute()) {
                        // Password updated successfully
                        echo "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Password updated successfully!',
                                showConfirmButton: false
                            }).then(function() {
                                window.location = 'profile.php'; // Redirect to profile.php
                            });
                        </script>";
                    } else {
                        // Error handling if the update fails
                        echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Error updating password',
                                text: 'There was an error while updating the password. Please try again.',
                                confirmButtonColor: '#d33'
                            });
                        </script>";
                    }

                    $stmt->close();
                } else {
                    echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'The new password cannot be the same as the current password.'
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'New passwords do not match.'
                    });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'The new password must be at least 8 characters long and contain at least one capital letter.'
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Current password is incorrect.'
            });
        </script>";
    }
}
?>




<style>

.side {
    border-right: 1px black solid;

}

.ui-w-80 {
    width : 80px !important;
    height: auto;
}

.btn-default {
    border-color: rgba(24, 28, 33, 0.1);
    background  : rgba(0, 0, 0, 0);
    color       : #4E5155;
}

label.btn {
    margin-bottom: 0;
}

.btn-outline-primary {
    border-color: #26B4FF;
    background  : transparent;
    color       : #26B4FF;
}

.btn {
    cursor: pointer;
}

.text-light {
    color: #babbbc !important;
}

.btn-facebook {
    border-color: rgba(0, 0, 0, 0);
    background  : #3B5998;
    color       : #fff;
}

.btn-instagram {
    border-color: rgba(0, 0, 0, 0);
    background  : #000;
    color       : #fff;
}

.card {
    background-clip: padding-box;
    box-shadow     : 0 1px 4px rgba(24, 28, 33, 0.012);
}

.row-bordered {
    overflow: hidden;
}

.account-settings-fileinput {
    position  : absolute;
    visibility: hidden;
    width     : 1px;
    height    : 1px;
    opacity   : 0;
}

.account-settings-links .list-group-item.active {
    font-weight: bold !important;
}

html:not(.dark-style) .account-settings-links .list-group-item.active {
    background: transparent !important;
}

.account-settings-multiselect~.select2-container {
    width: 100% !important;
}

.light-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(24, 28, 33, 0.03) !important;
}

.light-style .account-settings-links .list-group-item.active {
    color: #4e5155 !important;
}

.material-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(24, 28, 33, 0.03) !important;
}

.material-style .account-settings-links .list-group-item.active {
    color: #4e5155 !important;
}

.dark-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(255, 255, 255, 0.03) !important;
}

.dark-style .account-settings-links .list-group-item.active {
    color: #fff !important;
}

.light-style .account-settings-links .list-group-item.active {
    color: #4E5155 !important;
}

.light-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(24, 28, 33, 0.03) !important;
}
</style>

<style>
    .info-label {
        display: inline-block;
        width: 200px; /* Adjust this width as needed for your layout */
        text-align: right;
        margin-right: 20px; /* Adjust the margin as needed */
    }
</style>

<style>
    .rectangular-box {
        border: 1px solid #ccc; /* Add a border for the rectangular box */
        padding: 10px; /* Add padding for spacing inside the box */
        background-color: #f9f9f9; /* Set a background color */
        border-radius: 5px; /* Add rounded corners if desired */
    }
</style>
