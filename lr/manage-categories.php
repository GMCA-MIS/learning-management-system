<?php
include('includes/lr_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<style>
    a {
        text-decoration: underline; /* Add underline to the anchor text */
        color: black; /* Set the text color to blue */
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
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow newtopbar" style="margin-bottom:0;">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                
                 <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                        <h1 class="h3 mb-0 text-gray-800">Categories</h1>
                    </div>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <?php include ('includes/lr_name.php'); ?>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="card-body">

                    <div class="table-responsive">

                    <td>
                    <!--Add Pop Up Modal -->
                    <div class="modal fade" id="add_class" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form action="manage-categories-function.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <input type="hidden" name="add_ID" id="add_ID">

                                                    <div class="form-group">
                                                        <label for="category_name">Category Name</label>
                                                        <input type="text" class="form-control" id="category_name" name="category_name" required placeholder="Enter Category Name">
                                                    </div>

                                                    
                                                    <div class="form-group">
                                                        <label for="image">Thumbnail</label>
                                                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required placeholder="Select Image">
                                                    </div>


                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="add_category" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                    </div> <!--modal content -->
                                </div> <!--modal dialog -->
                    </div>  <!--modal fade -->
                    
                            <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_class" >
                                <i class="fa fa-plus" aria-hidden="true"></i> Add Category</button>
            </td>
        

        
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                        <h1 class="h5 mb-0 text-gray-800">Category List</h1>
                    </div>
            <?php
            //Displaying data into tables
            $query = "SELECT * FROM category ORDER BY category_id ASC";
            $query_run=mysqli_query($conn, $query);
            ?>
            <table id = "dataTableID" class="table table-bordered table table-striped" width = "100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style = "display:none;">category_id</th>   
                        <th>Thumbnail</th>
                        <th>Category Name</th>
                        <th>Edit</th>
                        <th>Delete</th>  
                                            
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(mysqli_num_rows($query_run) > 0) {
                            while($row=mysqli_fetch_assoc($query_run))
                            {
                            $category_id = $row['category_id'];
                                ?>
                    <tr>
                    <td style="display:none;"><?php echo $row['category_id']; ?></td> 
                        <td><center>
                        <img src="<?php echo $row['image']; ?>" class="rounded-circle img-fluid" alt="Category Photo" style="width: 50px; height: auto;"> </center>
                        </td>
                        <td>
                            <a href="category.php?id=<?php echo $row['category_id']; ?>">
                                <?php echo $row['category_name']; ?>
                            </a>
                        </td>

              
                

                       

<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                        <td>
                            <!--Edit Pop Up Modal -->
                            <div class="modal fade" id="edit_categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Category Information</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                    <form action="manage-categories-function.php" method = "POST"> 

                                        <div class="modal-body">

                                                <input type="hidden" name= "edit_ID" id ="edit_ID">

                                                <div class="form-group">
                                                    <label for="#">Category Name</label>
                                                    <input type="text" class="form-control" id="edit_Class_Name" name="category_name" required>
                                                </div>
                                                    
                                        </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="edit_category" class="btn btn-success">Update</button>
                                                </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                            <button type="button" class="btn btn-success edit_btn" data-toggle="modal" data-target="#edit_categoryModal">Edit</button>
                        </td>

                        <td>
                        </div>
                        

<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

                        <!--Delete Pop Up Modal -->
                        <div class="modal fade" id="delete_categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <form action="manage-categories-function.php" method = "POST"> 


                                        <div class="modal-body">
                                        
                                                <input type="hidden" name= "delete_ID" id ="delete_ID">

                                            <h5>Do you want to delete this data?</h5>

                
                                        
                                        </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                <button type="submit" name="delete_category" class="btn btn-success">Confirm</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                
                                <button type ="submit" name = "delete_btn" class = "btn btn-warning delete_btn">Delete</button>
                        <!-- </form> -->
                        </td>
                    </tr>
                    <?php
                            }
                        }
                        else 
                        {
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





<script>
    $(document).ready(function () {

        $('.edit_btn').on('click', function () {

            $('#editProcessModal').modal('show');

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


