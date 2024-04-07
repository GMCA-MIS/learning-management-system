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
            <ul class="nav nav-tabs" id="assignmentTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="createTab" data-toggle="tab" href="#createAssignment" role="tab"
                        aria-controls="createAssignment" aria-selected="true"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="uploadTab" data-toggle="tab" href="#uploadAssignment" role="tab"
                        aria-controls="uploadAssignment" aria-selected="false"></a>
                </li>
            </ul>
            <hr>
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
                                <div class="modal fade" id="add_bookModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Book for E-Library
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form class="" action="library-function.php" method="post"
                                                enctype="multipart/form-data" name="upload">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="title">Book Title</label>
                                                        <input type="text" class="form-control" id="title" name="title"
                                                            required placeholder="Enter Book Title">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="desc">Description</label>
                                                        <textarea class="form-control" id="description" name="desc"
                                                            rows="4" max-length="5000" required
                                                            placeholder="Enter Description"></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="author">Author</label>
                                                        <input type="text" class="form-control" id="author"
                                                            name="author" placeholder="Enter Author" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for "theme">Category</label>
                                                        <select name="category" id="category" class="form-control"
                                                            required>
                                                            <option value="" disabled selected>Select Category</option>
                                                            <?php
                                                            $query = "SELECT * FROM category ORDER BY category_name ASC";
                                                            $result = mysqli_query($conn, $query);

                                                            // Check if there are any results
                                                            if (mysqli_num_rows($result) > 0) {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $category_id = $row['category_id'];
                                                                    $category_name = $row['category_name'];
                                                                    // Create an option for each category
                                                                    echo '<option value="' . $category_id . '">' . $category_name . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="publication_year">Publication Year</label>
                                                        <input type="number" class="form-control" id="publication_year"
                                                            name="publication_year" placeholder="Enter Publication Year"
                                                            required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="call_number">Call Number</label>
                                                        <input type="number" class="form-control" id="call_number"
                                                            name="call_number" placeholder="Enter Call Number" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="book_cover" class="form-label">Book Cover
                                                            Photo:</label>
                                                        <input type="file" class="form-control" name="book_cover"
                                                            id="book_cover" accept="image/*" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="file_path" class="form-label">E-book File (PDF
                                                            only):</label>
                                                        <input type="file" class="form-control" name="file_path"
                                                            id="file_path" accept="application/pdf" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="book_status">Book Status</label>
                                                        <select class="form-control" id="book_status" name="book_status"
                                                            required>
                                                            <option value="" selected disabled>Select Book Status
                                                            </option>
                                                            <option value="Available">Available</option>
                                                            <option value="Archived">Archived</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-warning"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" name="add_book"
                                                        class="btn btn-success">Create</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!--modal content -->
                                    </div>
                                    <!--modal dialog -->
                                </div>
                                <!--modal fade -->
                                <button type="button" class="btn btn-success add_btn" data-toggle="modal"
                                    data-target="#add_bookModal">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add Book
                                </button>
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
                                        <th>Book_id</th>
                                        <th>Book Cover</th>
                                        <th>Title</th>
                                        <th>Description</th>
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
                                                                <form class="" action="library-function.php" method="post"
                                                                    enctype="multipart/form-data" name="upload">
                                                                    <div class="modal-body">
                                                                        <input type="hidden" class="form-control"
                                                                            id="edit_book_id" name="edit_book_id">
                                                                        <div class="form-group">
                                                                            <label for="edit_title">Book Title</label>
                                                                            <input type="text" class="form-control"
                                                                                id="edit_title" name="edit_title" required
                                                                                placeholder="Enter Book Title">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="edit_description">Description</label>
                                                                            <textarea class="form-control" id="edit_description"
                                                                                name="edit_description" rows="4"
                                                                                max-length="5000" required
                                                                                placeholder="Enter Description"></textarea>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="edit_author">Author</label>
                                                                            <input type="text" class="form-control"
                                                                                id="edit_author" name="edit_author"
                                                                                placeholder="Enter Author" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for "theme">Category</label>
                                                                            <select name="edit_category" id="edit_category"
                                                                                class="form-control">
                                                                                <option value="" disabled selected>Select
                                                                                    Category</option>
                                                                                <?php
                                                                                $query = "SELECT * FROM category ORDER BY category_name ASC";
                                                                                $result = mysqli_query($conn, $query);
                                                                                // Check if there are any results
                                                                                if (mysqli_num_rows($result) > 0) {
                                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                                        $category_id = $row['category_id'];
                                                                                        $category_name = $row['category_name'];
                                                                                        // Create an option for each category
                                                                                        echo '<option value="' . $category_id . '">' . $category_name . '</option>';
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="edit_publication_year">Publication
                                                                                Year</label>
                                                                            <input type="number" class="form-control"
                                                                                id="edit_publication_year"
                                                                                name="edit_publication_year"
                                                                                placeholder="Enter Publication Year" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="edit_call_number">Call Number</label>
                                                                            <input type="number" class="form-control"
                                                                                id="edit_call_number" name="edit_call_number"
                                                                                placeholder="Enter Call Number" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="edit_book_cover" class="form-label">Book
                                                                                Cover
                                                                                Photo:</label>
                                                                            <input type="file" class="form-control"
                                                                                name="edit_book_cover" id="edit_book_cover"
                                                                                accept="image/*" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="file_path" class="form-label">E-book
                                                                                File (PDF
                                                                                only):</ <input type="file" class="form-control"
                                                                                    name="edit_file_path" id="edit_file_path"
                                                                                    accept="application/pdf" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="edit_book_status">Book Status</label>
                                                                            <select class="form-control" id="edit_book_status"
                                                                                name="edit_book_status" required>
                                                                                <option value="" selected disabled>Select Book
                                                                                    Status
                                                                                </option>
                                                                                <option value="Available">Available</option>
                                                                                <option value="Archived">Archived</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-warning"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="edit_book"
                                                                            class="btn btn-primary">Update</button>
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