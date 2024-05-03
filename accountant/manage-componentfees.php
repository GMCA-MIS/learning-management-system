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
                        <h1 class="h3 mb-0 text-gray-800">Component Fees</h1>
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

                                            <form action="manage-componentfees-func.php" method="POST">
                                                <div class="modal-body">
                                                <div class="form-group">
                                                        <label for="department_name">Title</label>
                                                        <input type="text" class="form-control" id="intitle" name="intitle" required placeholder="Enter title.">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="txtdescription">Description</label>
                                                        <textarea id="txtdescription" name="txtdescription" class="form-control" required placeholder="Enter Description."></textarea>
                                                    </div>
                                                    
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="add_component" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                    </div> <!--modal content -->
                                </div> <!--modal dialog -->
                    </div>  <!--modal fade -->
                    
                            <button type="button" class="btn btn-success " data-toggle="modal" data-target="#adddepartment" 
                            style="margin-bottom: 20px;"><i class="fa fa-plus" aria-hidden="true"></i> Create Component Fees</button>
            </td>
        

        
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                        <h1 class="h5 mb-0 text-gray-800">Department List</h1>
                    </div>
            <?php
            //Displaying data into tables
            $query ="SELECT * FROM component_charge ORDER BY component_charge_id DESC";
            $query_run=mysqli_query($conn, $query);
            ?>
            <table id = "dataTableID" class="table table-bordered table table-striped" width = "100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Preview</th>
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
                        <td><?php echo $row['component_charge_id']; ?></td>   
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['description']; ?></td>

<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                        <td>
                            <!--Edit Pop Up Modal -->
                            <div class="modal fade" id="previewfees<?php echo $row['component_charge_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Component Fee's Summary</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" method = "POST"> 
                                            <div class="modal-body">
                                                <table>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Fees</th>
                                                        <th>Amount</th>
                                                    </tr>

                                                    <?php
                                                        $total_amount = 0;
                                                        $query2 ="SELECT * FROM component_charge_fees cf INNER JOIN charge_types ct ON cf.chargetype_id = ct.chargetype_id where component_charge_id = '". $row['component_charge_id'] . "' ORDER BY ccharge_fees_id DESC";
                                                        $query_run2=mysqli_query($conn, $query2);
                                                        if(mysqli_num_rows($query_run2) > 0) {
                                                            while($rowfees=mysqli_fetch_assoc($query_run2))
                                                            {
                                                                echo "<tr>";
                                                                echo "<th>".$rowfees['chargetype_id']."</th>";
                                                                echo "<th>".$rowfees['title']."</th>";
                                                                echo "<th> ₱".$rowfees['amount']."</th>";
                                                                echo "</tr>";
                                                                $total_amount = $total_amount + $rowfees['amount'];
                                                            }
                                                        }        
                                                    ?>
                                                </table>
                                                <hr style=" border: 2px solid gray">
                                                <div>
                                                     <b>Total Amount: </b>&nbsp;₱<?php echo $total_amount; ?>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>  

                            <button type="button" style="background:gray;color:white;" class="btn" data-toggle="modal" data-target="#previewfees<?php echo $row['component_charge_id'];?>" >Summary</button>
                        </td>

                        <td>
                            <button type ="submit" name = "delete_btn" class = "btn btn-success ">EDIT</button>

                        </td>
<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

                        <td>
                        </div>
                        <!--Delete Pop Up Modal -->
                        <div class="modal fade" id="delete<?php echo $row['component_charge_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        
                                                <input type="text" name= "delete_ID" id ="" value="<?php echo $row['component_charge_id']; ?>">

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
                                <button type ="submit" name = "delete_btn" class = "btn btn-danger " data-toggle="modal" data-target="#delete<?php echo $row['component_charge_id'];?>">Delete</button>
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


