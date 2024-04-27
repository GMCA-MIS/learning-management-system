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
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow newtopbar"
            style="margin-bottom:0;">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4"
                style="margin-top: 27px; margin-left: 10px;">
                <h1 class="h3 mb-0 text-gray-800">Manage Registrar Accounts</h1>
            </div>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - User Information -->
                <?php include('includes/admin_name.php'); ?>


            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="card-body">

            <div class="table-responsive">

                <td>
                    <!--Add Pop Up Modal -->
                    <div class="modal fade" id="add_coordinatorModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form action="manage-accounts-function.php" method="POST" oninput='pwd_rpt.setCustomValidity(pwd_rpt.value != pwd.value ? "Passwords do not match." : "")'>


                                    <div class="modal-body">

                                        <input type="hidden" name="add_ID" id="add_ID">
                                        <input type="hidden" name="user_type" id="user_type">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
                                        <div class="form-group">
                                            <label for="firstname">First Name </label>
                                            <input type="text" class="form-control" id="firstname" name="firstname"
                                                required placeholder="Enter First Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="lastname">Last Name </label>
                                            <input type="text" class="form-control" id="lastname" name="lastname"
                                                required placeholder="Enter Last Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Username</label>
                                            <input type="text" class="form-control" id="" name="username" required
                                                placeholder="Enter Username">
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Password</label>
                                            <input type="password" class="form-control" id="password1" name="pwd" required
                                                placeholder="Enter Password" pattern="(?=.*[~!@#$.,:<>=])(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, atleast 1 symbol ( ~!@#$.,:<>= ) and at least 8 or more characters">

                                        </div>
                                        <div class="form-group">
                                            <label for="email">Repeat Password</label>
                                            <input type="password" class="form-control" id="password1" name="pwd_rpt" required
                                                placeholder="Enter Password" pattern="(?=.*[~!@#$.,:<>=])(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, atleast 1 symbol ( ~!@#$.,:<>= ) and at least 8 or more characters">

                                        </div>
                                        

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" name="add_coordinator"
                                            class="btn btn-primary">Submit</button>
                                    </div>
                                </form> <!--end form -->
                            </div> <!--modal content -->
                        </div> <!--modal dialog -->
                    </div> <!--modal fade -->

                    <button type="button" class="btn btn-success add_btn" data-toggle="modal"
                        data-target="#add_coordinatorModal"
                        style="margin-bottom: 20px;"><i
                            class="fa fa-plus" aria-hidden="true"></i> Add Users</button>
                </td>


                <div class="card-body">
                    <div class="d-sm-flex align-items-center justify-content-between mb-2"
                        style="margin-top: 10px; margin-left: 10px;">
                        <h1 class="h5 mb-0 text-gray-800">User List</h1>
                    </div>
                    <?php
                    // Displaying data into tables
                    $query = "SELECT *
                            FROM users where user_type = 'registrar' order by user_id DESC";
                    $query_run = mysqli_query($conn, $query);
                    ?>

                    <table id="dataTableID" class="table table-bordered table table-striped" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th style="display:none;">coordinator_id </th>
                                <th>User Name</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>User Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_assoc($query_run)) {

                                    ?>
                                    <tr>

                                        <td style="display: none;">
                                            <?php echo $row['user_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['username']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['firstname']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['lastname']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['user_type']; ?>
                                        </td>
                                        <td>
                                            <!--Edit Pop Up Modal -->
                                            <div class="modal fade" id="editManageCoordinatorsModal<?php echo $row['user_id']; ?>" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit User Information
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <form action="manage-accounts-function.php" method="POST"  oninput='editpwd_rpt.setCustomValidity(editpwd_rpt.value != editpwd.value ? "Passwords do not match." : "")'>


                                                            <div class="modal-body">

                                                                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
                                                                    <div class="form-group">
                                                                        <label for="firstname">First Name </label>
                                                                        <input type="text" class="form-control" id="firstname" name="firstname"
                                                                            required placeholder="Enter First Name" value="<?php echo $row['firstname'];?>">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="lastname">Last Name </label>
                                                                        <input type="text" class="form-control" id="lastname" name="lastname"
                                                                            required placeholder="Enter Last Name" value="<?php echo $row['lastname'];?>">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="email">Username</label>
                                                                        <input type="text" class="form-control" id="" name="" disabled required
                                                                            placeholder="Enter Username" value="<?php echo $row['username'];?>">
                                                                            
                                                                        <input type="hidden" class="form-control" id="" name="username" required
                                                                            placeholder="Enter Username" value="<?php echo $row['username'];?>">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="email">Password</label>
                                                                        <input type="password" class="form-control" id="password1" name="editpwd" required value="<?php echo $row['password'];?>"
                                                                            placeholder="Enter Password" pattern="(?=.*[~!@#$.,:<>=])(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, atleast 1 symbol ( ~!@#$.,:<>= ) and at least 8 or more characters">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="email">Repeat Password</label>
                                                                        <input type="password" class="form-control" id="password1" name="editpwd_rpt" required value="<?php echo $row['password'];?>"
                                                                            placeholder="Enter Password" pattern="(?=.*[~!@#$.,:<>=])(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, atleast 1 symbol ( ~!@#$.,:<>= ) and at least 8 or more characters">
                                                                    </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" name="edit_coordinators"
                                                                    class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-success edit_btn" data-toggle="modal"
                                                data-target="#editManageCoordinatorsModal<?php echo $row['user_id']; ?>"
                                                >Edit</button>
                                        
                        </div>
                        <!--Delete Pop Up Modal -->
                        <div class="modal fade" id="delete_instructors<?php echo $row['user_id']; ?>" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form action="manage-accounts-function.php" method="POST">


                                        <div class="modal-body">

                                            <input type="hidden" name="delete_ID" id="delete_ID" value="<?php echo $row['user_id']; ?>">
                                            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
                                            <h5>Do you want to delete this User?</h5>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" name="delete_coordinators"
                                                class="btn btn-primary">Confirm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!--  <form action="manage-users-function.php" method = "post"> -->
                        <!--  <input type = "hidden" name = "delete_id" value="<?php echo $row['teacher_id']; ?>"> -->
                        <button type="submit" name="delete_btn" class="btn btn-danger delete_btn" data-toggle="modal"
                                                data-target="#delete_instructors<?php echo $row['user_id']; ?>"
                            >Delete</button>
                        <!-- </form> -->
                        </td>
                        </tr>
                        <?php
                                }
                            } else {
                                echo "No Record Found";
                            }
                            ?>
                </tbody>
                </table>
            </div>
        </div>


        <?php
        include('includes/scripts.php');
        include('includes/footer.php');
        ?>