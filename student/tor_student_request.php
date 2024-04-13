<?php 
include('student_session.php');  ?>
<?php
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('dbcon.php');
include('initialize.php');
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
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
        <?php
            $school_year_query = mysqli_query($conn, "select * from school_year order by school_year DESC") or die(mysqli_error());
            $school_year_query_row = mysqli_fetch_array($school_year_query);
            $school_year = $school_year_query_row['school_year'];
        ?>
        </div>    
        
        <?php
// SQL query to fetch data from both student table
$query = "SELECT * FROM student
          WHERE student_id = $student_id";

// Execute the query and get the result
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Check if there are rows in the result set
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Access the columns by their names
            $student_id = $row['student_id'];
            $username = $row['username'];
            $password = $row['password'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $middle_initial = $row['middle_initial'];
            $location = $row['location'];
            $dob = $row['dob'];
            $pob = $row['pob'];
            $email = $row['email'];

            $highschool  = $row['highschool'];
            $other_colleges  = $row['other_colleges'];

            $highschool_address  = $row['highschool_address'];
            $semester  = $row['semester'];
            $grade_level  = $row['grade_level'];

            $strand_id  = $row['strand_id'];

            
            $strand_query = mysqli_query($conn, "select * from strand where id = $strand_id") or die(mysqli_error());
            $strand_query_row = mysqli_fetch_array($strand_query);
            $student_strand = $strand_query_row['name'];


            // Output or use the retrieved data as needed
        }
    } else {
        echo "No records found for student ID: $student_id";
    }
} else {
    echo "Query execution failed: " . mysqli_error($conn);
}
?>



        
        <div class="container light-style flex-grow-1 container-p-y">

        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">

                            <hr class="border-light m-0">
                            <div class="card-body">
                                <div class="header">
                                    <center><h2 style="color: black;">Transcript of Records Request Form</h2><center>
                                </div>
                                <hr>
                                <form action="tor_request_function.php" method="post" enctype="multipart/form-data">
                                    <!-- Requester's Name -->
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-4 col-12-xsmall">
                                        <input
                                            type="text"
                                            name="studentid"
                                            id="studentid"
                                            value="<?php echo $student_id;?>"
                                            autocomplete="off"
                                            placeholder="Lastname"
                                            class="form-control"
                                            hidden
                                            required
                                        />
                                        <input
                                            type="text"
                                            name="lastname"
                                            id="lastname"
                                            value="<?php echo $lastname;?>"
                                            autocomplete="off"
                                            placeholder="Lastname"
                                            class="form-control"
                                            readonly="true"
                                            required
                                        />
                                        </div>
                                        <div class="col-4 col-12-xsmall">
                                        <input
                                            type="text"
                                            name="firstname"
                                            id="firstname"
                                            value="<?php echo $firstname;?>"
                                            autocomplete="off"
                                            placeholder="Firstname"
                                            class="form-control"
                                            readonly="true"
                                            required
                                        />
                                        </div>
                                        <div class="col-4 col-12-xsmall">
                                        <input
                                            type="text"
                                            name="middle_initial"
                                            id="middle_initial"
                                            value="<?php echo $middle_initial;?>"
                                            autocomplete="off"
                                            placeholder="Middle Initial"
                                            class="form-control"
                                            readonly="true"
                                            required
                                        />
                                        </div>
                                    </div>
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-4 col-12-xsmall">
                                        <label for="lastname">Last Name</label>
                                        </div>
                                        <div class="col-4 col-12-xsmall">
                                        <label for="firstname" >First Name</label>
                                        </div>
                                        <div class="col-4 col-12-xsmall">
                                        <label for="middle_initial"
                                            >Middle Initial - input N/A if not applicable</label
                                        >
                                        </div>
                                    </div>

                                    <br />

                                    <!-- user email -->
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-12">
                                        <input
                                            type="text"
                                            name="email"
                                            id="email"
                                            value="<?php echo $email;?>"
                                            autocomplete="off"
                                            placeholder="Email ( request status will be sent to this email )"
                                            class="form-control"
                                            readonly="true"
                                            required
                                        />
                                        </div>
                                    </div>
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-12">
                                        <label for="address">Email</label>
                                        </div>
                                    </div>
                                    <br />


                                    
                                    <!-- Requester's Address -->
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-12">
                                        <input
                                            type="text"
                                            name="address"
                                            id="address"
                                            value="<?php echo $location;?>"
                                            autocomplete="off"
                                            placeholder="Address"
                                            class="form-control"
                                            readonly="true"
                                            required
                                        />
                                        </div>
                                    </div>
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-12">
                                        <label for="address">Address</label>
                                        </div>
                                    </div>

                                    <br />

                                    <!-- Requester's Course/Program -->
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-12">
                                        <input
                                            type="text"
                                            name="course"
                                            id="course"
                                            value="<?php echo $student_strand;?>"
                                            autocomplete="off"
                                            placeholder="Course"
                                            class="form-control"
                                            readonly="true"
                                            required
                                        />
                                        </div>
                                    </div>
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-12">
                                        <label for="course">Course/Program</label>
                                        </div>
                                    </div>

                                    <br />
                                    
                                    <!-- Requester's Birth Info -->
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-4 col-12-xmall">
                                        <input
                                            type="date"
                                            name="dob"
                                            id="dob"
                                            value="<?php echo $dob;?>"
                                            autocomplete="off"
                                            placeholder="Date of Birth"
                                            class="form-control"
                                            readonly="true"
                                            required
                                        />
                                        </div>
                                        <div class="col-8 col-12-xsmall">
                                        <input
                                            type="text"
                                            name="pob"
                                            id="pob"
                                            value="<?php echo $pob;?>"
                                            autocomplete="off"
                                            placeholder="Place of Birth"
                                            class="form-control"
                                            readonly="true"
                                            required
                                        />
                                        </div>
                                    </div>
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-4 col-12-xsmall">
                                        <label for="dob">Date of Birth</label>
                                        </div>
                                        <div class="col-8 col-12-xsmall">
                                        <label for="pob">Place of Birth</label>
                                        </div>
                                    </div>

                                    <br />

                                    <!--  -->
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-6">
                                        <input
                                            type="text"
                                            name="highschool"
                                            id="highschool"
                                            value="<?php echo $highschool;?>"
                                            autocomplete="off"
                                            placeholder="Highschool"
                                            class="form-control"
                                            readonly="true"
                                            required
                                        />
                                        </div>
                                        <div class="col-6">
                                        <input
                                            type="text"
                                            name="other_colleges"
                                            id="other_colleges"
                                            value="<?php if(empty($other_colleges)){ echo "N/A"; }else{ echo $other_colleges;} ?>"
                                            autocomplete="off"
                                            placeholder="Other Colleges"
                                            class="form-control"
                                            readonly="true"
                                            required
                                        />
                                        </div>
                                    </div>
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-6 col-12-xsmall">
                                        <label for="highschool">Highschool</label>
                                        </div>
                                        <div class="col-6">
                                        <label for="other_colleges"
                                            >Other Colleges - input N/A if not applicable</label
                                        >
                                        </div>
                                    </div>
                                    <br />

                                    <!--  -->

                                    <!-- hs address -->
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-12">
                                        <input
                                            type="text"
                                            name="highschool_address"
                                            id="highschool_address"
                                            value="<?php echo $highschool_address; ?>"
                                            autocomplete="off"
                                            placeholder="Address of Highschool"
                                            class="form-control"
                                            readonly="true"
                                            required
                                        />
                                        </div>
                                    </div>
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-12">
                                        <label for="highschool_address">Address of Highschool</label>
                                        </div>
                                    </div>
                                    <br />

                                    <!-- GMC Admission, Requirements, and Purpose of Request -->

                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-6"> 
                                        <input
                                        
                                            type="date"
                                            name="gmc_admission_date"
                                            id="gmc_admission_date"
                                            value=""
                                            autocomplete="off"
                                            placeholder="Date of Admission to GMC"
                                            class="form-control"
                                            required
                                        />
                                        </div>
                                        <div class="col-6">
                                        <input
                                            type="text"
                                            name="sem_attended"
                                            id="sem_attended"
                                            value="<?php echo "Grade ". $grade_level . " - ". $semester; ?>"
                                            autocomplete="off"
                                            placeholder="Semesters Attended"
                                            class="form-control"
                                            readonly="true"
                                            required
                                        />
                                        </div>
                                    </div>
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-6">
                                        <label for="gmc_admission_date"
                                            >Date of Admission to GMC</label
                                        >
                                        </div>
                                        <div class="col-6">
                                        <label for="sem_attended">Semesters Attended</label>
                                        </div>
                                    </div>
                                    <br />
                                    <!-- Request Info -->

                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-4">
                                        <select name="doc_type" id="tor_purpose"  class="form-control" required>
                                            <option value="" disabled selected>
                                            -- Select Document to request --
                                            </option>
                                            <option value="Card">Card</option>
                                            <option value="Diploma">Diploma</option>
                                            <option value="Form 137">Form 137</option>
                                            <option value="Good Moral">Good Moral</option>
                                        </select>
                                        </div>
                                        <div class="col-4">
                                        <select class="form-control" name="tor_purpose" id="tor_purpose" required>
                                            <option value="" disabled selected>
                                            -- Select Purpose of Requesting ToR --
                                            </option>
                                            <option value="Employment">Employment</option>
                                            <option value="Job Application">Job Application</option>
                                            <option value="School Transfer">
                                            Transfer to other School
                                            </option>
                                        </select>
                                        </div>
                                        <div class="col-4">
                                        <input
                                            type="file"
                                            id="creds_submitted"
                                            name="creds_submitted"
                                            accept=".pdf, .doc, .docx, .jpg, .jpeg"
                                            class="form-control"
                                            required
                                        />
                                        </div>
                                    </div>
                                    <div class="row gtr-uniform gtr-50">
                                        <div class="col-4">
                                        <label for="doc_type">Document to request</label>
                                        </div>
                                        <div class="col-4">
                                        <label for="tor_purpose">Purpose of ToR Request</label>
                                        </div>
                                        <div class="col-4">
                                        <label for="creds_submitted"
                                            >Upload Credentials (PDF, DOC, DOCX, JPG, JPEG)</label
                                        >
                                        </div>
                                    </div>

                                    <br />
                                    <div class="col-12">
                                        <ul class="actions">
                                        <li>
                                            <input
                                            type="submit"
                                            name="submit"
                                            id="submit"
                                            class="btn btn-primary"
                                            style="background-color:#361E12"
                                            />
                                        </li>
                                        </ul>
                                    </div>
                                    </form>


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


                        <div class="tab-pane fade" id="account-info">
                            <div class="card-body pb-2">
                            <div class="header">
                                    <h2 style="color: black;">Information</h2>
                                </div>
                                <hr>

                                <!-- <div class="form-group">
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
                                </div> -->

                            </div>
                        </div>

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
								
								mysqli_query($conn,"update  student set location = '$location' where student_id  = '$student_id' ")or die(mysqli_error());
								
								?>
 
								<script>
								window.location = "profile.php";  
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

    // Assuming you already have a valid $student_id

    // Check if the current password is correct (you'll need to fetch the current hashed password from the database)
    $query = "SELECT password FROM student WHERE student_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id);
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
                    $updateQuery = "UPDATE student SET password = ? WHERE student_id = ?";
                    $stmt = $conn->prepare($updateQuery);
                    $stmt->bind_param("si", $hashedNewPassword, $student_id);

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
