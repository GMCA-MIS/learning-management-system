<?php
    include('includes/lr_session.php');
    include('includes/header.php');
    include('includes/navbar.php');
    include('dbcon.php');
?>
<style>
    a {
        text-decoration: underline;
        /* Add underline to the anchor text */
        color: black;
        /* Set the text color to blue */
    }

    a:hover {
        color: brown;
    }
    label {
        margin-top: 5%;
    }
</style>

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

        <!-- Begin Page Content -->
        <div class="modal-body">
            
            <div></div>
            <div class="tab-content" id="assignmentTabsContent">
                <div class="tab-pane fade" id="uploadAssignment" role="tabpanel" aria-labelledby="uploadTab">
            </div>
            <div class="tab-pane fade show active" id="createAssignment" role="tabpanel" aria-labelledby="createTab">
                <div class="card-body">

                    <div class="table-responsive">

                        <td>
                            <!--Add Pop Up Modal -->
                            <div class="modal fade" id="add_lcardkModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">New ID Card
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="container">
                                            <form method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label for="name">Full Name</label>
                                                        <input type="text" class="form-control" placeholder="Full name" name="name">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="department">Department</label>
                                                        <select name="dept" class="custom-select custom-select">
                                                            <option selected></option>
                                                            <option value="Computer Studies">Computer Studies</option>
                                                            <option value="Education">Education</option>
                                                            <option value="Agriculture">Agriculture</option>
                                                            <option value="Junior High School">Junior High School</option>
                                                            <option value="Senior High School">Senior High School</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="category">Category</label>
                                                        <select name="cat" class="custom-select custom-select">
                                                            <option selected></option>
                                                            <option value="Student">Student</option>
                                                            <option value="Faculty">Faculty</option>
                                                            <option value="Admin">Admin</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label for="address">Address</label>
                                                        <input type="text" class="form-control" placeholder="Type your address" name="address">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label for="email">Email</label>
                                                        <input type="text" class="form-control" placeholder="Your email" name="email">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="birthdate">Birthdate</label>
                                                        <input type="date" class="form-control" id="birthdate" name="dob">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label for="id">ID Card No.</label>
                                                        <input type="text" class="form-control" placeholder="ID No." name="id_no">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="contact">Contact No.</label>
                                                        <input type="text" class="form-control" placeholder="Phone number" name="phone">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label for="photo">Upload Photo</label>
                                                        <input type="file" class="form-control" name="image">
                                                    </div>
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                <button type="submit" class="btn btn-warning">Submit</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                    <!--modal content -->
                                </div>
                                <!--modal dialog -->
                            </div>
                            <!--modal fade -->
                            <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_lcardkModal">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add New Card
                            </button>
                            <a href="generate-id.php">
                                <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#gen_lcardModal">
                                    <i class="fa fa-address-card" aria-hidden="true"></i> Generate ID Card
                                </button>
                            </a>
                            <a href="generate-qr.php">
                                <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#gen_qrModal">  
                                    <i class="fa fa-qrcode" aria-hidden="true"></i> Generate QR Code
                                </button>
                            </a>
                        </td>

                        <div class="d-sm-flex align-items-center justify-content-between mb-2"
                            style="margin-top: 10px; margin-left: 10px;">
                            <h1 class="h5 mb-0 text-gray-800"></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>



<?php
    include('includes/scripts.php');
    include('includes/footer.php');
?>