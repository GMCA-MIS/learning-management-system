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
                        <h1 class="h3 mb-0 text-gray-800">Type of Fees</h1>
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

                    <div class="table-responsive">

                    <td>
                    <!--Add Pop Up Modal -->
                    <div class="modal fade" id="adddepartment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Create New Fee</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form action="manage-typeoffees-func.php" method="POST">
                                                <div class="modal-body">
                                                <div class="form-group">
                                                        <label for="department_name">Title</label>
                                                        <input type="text" class="form-control" id="intitle" name="intitle" required placeholder="Enter Fee's title.">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="txtpurpose">Purpose</label>
                                                        <textarea id="txtpurpose" name="txtpurpose" class="form-control" required placeholder="Enter Fee's purpose."></textarea>

                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="amountfee">Amount</label>
                                                        <input type="text" class="form-control" min="1" id="amountfee" name="amountfee" required placeholder="Enter Fee's amount" pattern="^[1-9]\d*(\.\d+)?$">
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="add_fee" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                    </div> <!--modal content -->
                                </div> <!--modal dialog -->
                    </div>  <!--modal fade -->
                    
                            <button type="button" class="btn btn-success " data-toggle="modal" data-target="#adddepartment" 
                            style="margin-bottom: 20px;"><i class="fa fa-plus" aria-hidden="true"></i> Create Type of Fee</button>
            </td>
        

        
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                        <h1 class="h5 mb-0 text-gray-800">Department List</h1>
                    </div>
            <?php
            //Displaying data into tables
            $query ="SELECT * FROM charge_types ORDER BY chargetype_id DESC";
            $query_run=mysqli_query($conn, $query);
            ?>
            <table id = "dataTableID" class="table table-bordered table table-striped" width = "100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="display:none;">Department ID</th>
                        <th>Fee ID</th>
                        <th>Title</th>
                        <th>Purpose</th>
                        <th>Charge Amount</th>
                        <th>Edit</th>      
                        <th>Delete</th>                             
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(mysqli_num_rows($query_run) > 0) {
                            while($row=mysqli_fetch_assoc($query_run))
                            {
                                ?>
                    <tr>
                        <td style="display:none;"><?php echo $row['department_id']; ?></td>      
                        <td><?php echo $row['chargetype_id']; ?></td>   
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['purpose']; ?></td>
                        <td><?php echo $row['amount']; ?></td>

                       

<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                        <td>
                            <!--Edit Pop Up Modal -->
                            <div class="modal fade" id="editfee<?php echo $row['chargetype_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Fee Information</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                    <form action="manage-typeoffees-func.php" method = "POST"> 

                                        <div class="modal-body">
                                                        <input type="hidden" name="edit_ID" value="<?php echo $row['chargetype_id'];?>">


                                                        <div class="form-group">
                                                            <label for="department_name">Title</label>
                                                            <input type="text" class="form-control" id="intitle" name="intitle" required placeholder="Enter Fee's title." value="<?php echo $row['title'];?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="txtpurpose">Purpose</label>
                                                            <textarea id="txtpurpose" name="txtpurpose" class="form-control" required placeholder="Enter Fee's purpose." ><?php echo $row['purpose'];?></textarea>

                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="amountfee">Amount</label>
                                                            <input type="text" class="form-control" id="amountfee" name="amountfee" required placeholder="Enter Fee's amount" value="<?php echo $row['amount'];?>" min="1" pattern="^[1-9]\d*(\.\d+)?$">
                                                        </div>

                                        </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="update_fees" class="btn btn-primary">Update</button>
                                                </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editfee<?php echo $row['chargetype_id'];?>" >Edit</button>
                        </td>

                        <td>
                        </div>
                        

<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

                        <!--Delete Pop Up Modal -->
                        <div class="modal fade" id="deleteDepartment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete Fee</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <form action="manage-typeoffees-func.php" method = "POST"> 


                                        <div class="modal-body">
                                        
                                                <input type="hidden" name= "delete_ID" id ="" value="<?php echo $row['chargetype_id']; ?>">

                                            <h5>Do you want to delete this Fee?</h5>

                
                                        
                                        </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" name="deleted_fee" class="btn btn-primary">Confirm</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                        <!--  <form action="manage-users-function.php" method = "post"> -->
                            <!--  <input type = "hidden" name = "delete_id" value="<?php echo $row['Reg_ID']; ?>"> -->
                                <button type ="submit" name = "delete_btn" class = "btn btn-danger delete_btn">Delete</button>
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


