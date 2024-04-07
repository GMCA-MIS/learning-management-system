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
            <!-- <ul class="nav nav-tabs" id="assignmentTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="createTab" data-toggle="tab" href="#createAssignment" role="tab"
                        aria-controls="createAssignment" aria-selected="true"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="uploadTab" data-toggle="tab" href="#uploadAssignment" role="tab"
                        aria-controls="uploadAssignment" aria-selected="false"></a>
                </li>
            </ul>
            <hr> -->
            <div></div>
            <div class="tab-content" id="assignmentTabsContent">
                <div class="tab-pane fade" id="uploadAssignment" role="tabpanel" aria-labelledby="uploadTab">
                    <?php
                    // Displaying data into tables
                    $query = "SELECT booklist.*, category.category_name
                    FROM booklist
                    JOIN category ON booklist.category_id = category.category_id
                    WHERE booklist.book_status =  'Archived'
                    ORDER BY booklist.book_id DESC";
                    $query_run = mysqli_query($conn, $query);
                    ?>
                            <table id="dataTableIDs" class="table table-bordered table table-striped" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Student Number</th>
                                        <th>Name</th>
                                        <th>ID Card Number</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc($query_run)) {
                                            $student_id = $row['student_id'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['name']; ?>
                                        </td>
                                        <td>
                                            <a href="view_book-all.php?book_id=<?php echo $book_id; ?>">
                                                <?php echo $row['id_card_number']; ?>
                                            </a>
                                        </td>
                                        <td style="display:none;">
                                            <?php echo $row['actions']; ?>
                                        </td>
                                        
                                        <?php 
                                            $sql = "SELECT * FROM `cards` order by 1 DESC";
                                            $result = mysqli_query($conn, $sql);
                                            $sno = 0;
                                                
                                                while($row = mysqli_fetch_assoc($result)){
                                            $sno = $sno + 1;
                                                echo "<tr>
                                                        <th scope='row'>". $sno . "</th>
                                                        <td>". $row['name'] . "</td>
                                                        <td>". $row['id_no'] . "</td>
                                                        <td> <button class='edit btn btn-sm btn-success col-5' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-danger col-5' id=d".$row['sno'].">Delete</button></td>
                                                        </tr>";
                                            } 
                                        ?>

                                        <!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                                        

                                        <td>


                                            <!--Restore Pop Up Modal -->
                                            <div class="modal fade" id="restore_bookModal" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Restore Book</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <form action="library-function.php" method="POST">


                                                            <div class="modal-body">

                                                                <input type="hidden" name="restore_ID" id="restore_ID">

                                                                <h5>Do you want to Restore this book? <br> <span
                                                                        style="font-size:15px;"> The book will not be
                                                                        available for other users to view. </span></h5>



                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit" name="restore_book"
                                                                    class="btn btn-success">Confirm</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" name="restore_btn" class="btn btn-success restore_btn">Restore</button>
                                        </td>
                                <!-- </div> -->
                                <!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
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
                            <?php
                            // Displaying data into tables
                            $query = "SELECT booklist.*, category.category_name
                            FROM booklist
                            JOIN category ON booklist.category_id = category.category_id
                            WHERE booklist.book_status = 'Available'
                            ORDER BY booklist.book_id DESC";
                            $query_run = mysqli_query($conn, $query);
                            ?>
                            <table id="dataTableID" class="table table-bordered table table-striped" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Student Number</th>
                                        <th>Name</th>
                                        <th>ID Card Number</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc($query_run)) {
                                            $book_id = $row['book_id'];
                                            ?>
                                            <tr>
                                                <td style="display:none;">
                                                    <?php echo $row['book_id']; ?>
                                                </td>
                                                <td>
                                                    <center>
                                                        <img src="<?php echo $row['book_cover']; ?>" class="img-fluid"
                                                            alt="Book Photo" style="width: 50px; height: auto;">
                                                    </center>
                                                </td>
                                                <td>
                                                    <a href="view_book-all.php?book_id=<?php echo $book_id; ?>">
                                                        <?php echo $row['book_title']; ?>
                                                    </a>
                                                </td>
                                                <td style="display:none;">
                                                    <?php echo $row['book_description']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['author']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['publication_year']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['category_name']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['book_status']; ?>
                                                </td>
                                                <td style="display:none;">
                                                    <?php echo $row['call_number']; ?>
                                                </td>

                                                <!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                                                <td>
                                                    <!--Edit Pop Up Modal -->
                                                    <div class="modal fade" id="edit_bookModal" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Book
                                                                        Information
                                                                    </h5>
                                                                </div>
                                                                <form method="POST">
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="snoEdit" id="snoEdit">
                                                                        <div class="form-group">
                                                                            <label for="name">Student Name</label>
                                                                            <input type="text" class="form-control" id="nameEdit" name="nameEdit">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="desc">ID Card Number:</label>
                                                                            <input class="form-control" id="id_noEdit" name="id_noEdit" rows="3"></input>
                                                                        </div> 
                                                                    </div>
                                                                    <div class="modal-footer d-block mr-auto">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                                    </div>
                                                                </form>
                                                            </div> <!--modal content -->
                                                        </div> <!--modal dialog -->
                                                    </div> <!--modal fade -->


                                                    <button type="submit" name="edit_btn"
                                                        class="btn btn-success edit_btn">Edit</button>
                                                </td>

                                                <td>


                                                    <!--Archive Pop Up Modal -->
                                                    <div class="modal fade" id="archive_bookModal" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Archive Book
                                                                    </h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <form action="library-function.php" method="POST">


                                                                    <div class="modal-body">

                                                                        <input type="hidden" name="archive_ID" id="archive_ID">

                                                                        <h5>Do you want to Archive this book? <br> <span
                                                                                style="font-size:15px;"> The book will not be
                                                                                available for other users to view. </span></h5>



                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-dismiss="modal">Cancel</button>
                                                                        <button type="submit" name="archive_book"
                                                                            class="btn btn-success">Confirm</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" name="archive_btn"
                                                        class="btn btn-warning archive_btn">Archive</button>
                                                </td>
                                </div>
                                <!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                                <td>
                                    <!--Delete Pop Up Modal -->
                                    <div class="modal fade" id="delete_bookModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form action="library-function.php" method="POST">


                                                    <div class="modal-body">

                                                        <input type="hidden" name="delete_ID" id="delete_ID">

                                                        <h5>Do you want to delete this book?</h5>



                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button type="submit" name="delete_book"
                                                            class="btn btn-success">Confirm</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <button type="submit" name="delete_btn" class="btn btn-warning delete_btn">Delete</button>
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
            </div>
        </div>



<?php
    include('includes/scripts.php');
    include('includes/footer.php');
?>