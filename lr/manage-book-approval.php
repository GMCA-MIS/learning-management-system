<?php 
include('includes/lr_session.php');
include('includes/header.php');
include('includes/navbar.php');
include('dbcon.php');
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
                <h1 class="h3 mb-0 text-gray-800">Approve Books</h1>
            </div>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - User Information -->
                <?php include('includes/lr_name.php'); ?>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="card-body">

            <div class="table-responsive">

                <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                    <h1 class="h5 mb-0 text-gray-800">Pending Book List</h1>
                </div>
                <?php
                // Displaying data into tables
                $query = "SELECT * FROM booklist WHERE book_status = '2' ORDER BY  category_id ASC";
                $query_run = mysqli_query($conn, $query);
                ?>
                <table id="dataTableID" class="table table-bordered table table-striped" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="display:none;">Book_id</th>
                            <th>Book Cover</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Publication Year</th>
                            <th>Call Number</th>
                            <th>Approve</th>
                            <th>Deny</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($query_run) > 0) {
                            while ($row = mysqli_fetch_assoc($query_run)) {
                                $book_id = $row['book_id'];
                        ?>
                                <tr>
                                    <td style="display:none;"><?php echo $row['book_id']; ?></td>
                                    <td>
                                        <center>
                                            <img src="<?php echo $row['book_cover']; ?>" class="img-fluid" alt="Book Photo" style="width: 50px; height: auto;">
                                        </center>
                                    </td>
                                    <td> <?php echo $row['book_title']; ?> </td>
                                    <td> <?php echo $row['author']; ?> </td>
                                    <td> <?php echo $row['publication_year']; ?> </td>
                                    <td> <?php echo $row['call_number']; ?> </td>

                                    <!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                                    <td>
                                        <!--Approve Pop Up Modal -->
                                        <div class="modal fade" id="approve_bookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Approve Book</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form class="" action="library-function.php" method="post" enctype="multipart/form-data" name="upload">
                                                        <div class="modal-body">
                                                        <input type = "hidden" name = "book_id" id = "book_id">
                                                        <h3> Are you sure you want to approve this book? </h3> 
                                                        <h6> It will be available on the E-Library once you click confirm." </h6>
                                                        
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                                            <button type="submit" name="approve_book" class="btn btn-success approve-button">Confirm</button>
                                                        </div>
                                                    </form>
                                            </div> <!--modal content -->
                                        </div> <!--modal dialog -->
                                     </div>  <!--modal fade -->
                            
                                     <button type="button" class="btn btn-success " data-toggle="modal" data-target="#approve_bookModal" onclick="setBookId(<?php echo $book_id; ?>)">Approve</button>
                                     <script>
    function setBookId(bookId) {
        document.getElementById("book_id").value = bookId;
    }
</script>
                        </td>

                     
                     
                        </div>
<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<td>
                        <!--Delete Pop Up Modal -->
                        <div class="modal fade" id="deny_bookApproval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <form action="library-function.php" method = "POST"> 


                                        <div class="modal-body">
                                        
                                                <input type="hidden" name= "delete_ID" id ="delete_ID">
                                            <h5>Do you want to delete this data?</h5>
                                        </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                                                <button type="submit" name="deny_book" class="btn btn-danger">Confirm</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                
                                <button type ="submit" name = "delete_btn" class = "btn btn-warning delete_btn">Deny</button>
                        </td>
                    </tr>
                    <?php
                            }
                        }
                        else 
                        {
                            echo "No Books Found";
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





<script>
    $(document).ready(function () {

        $('.edit_btn').on('click', function () {

            $('#edit_bookModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#edit_ID').val(data[0]);
            $('#o_ID').val(data[1]);
            $('#edit_Process_Name').val(data[2]);
            $('#edit_Process_Description').val(data[3]);
            $('#edit_Process_Type').val(data[4]);
        });
    });
</script>


