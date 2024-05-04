<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
$component_charge_id = $_GET['component_charge_id'];

$querydept = "SELECT *   FROM  component_charge  where component_charge_id  = $component_charge_id";
$query_rundept = mysqli_query($conn, $querydept);

if (mysqli_num_rows($query_rundept) > 0) {
    while ($row = mysqli_fetch_assoc($query_rundept)) {
                    
            $componenttitle = $row["title"];
            $componentdescription= $row["description"];
            $componentdate= $row["created_date"];
    }
}

$query ="SELECT SUM(ct.amount) AS totals FROM component_charge_fees ccf INNER JOIN charge_types ct ON ccf.chargetype_id = ct.chargetype_id where component_charge_id = $component_charge_id ";
$query_rundept = mysqli_query($conn, $query);

if (mysqli_num_rows($query_rundept) > 0) {
    while ($rowz = mysqli_fetch_assoc($query_rundept)) {
            $componenttotal = $rowz["totals"];
    }
}


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

                                            <form action="manage-componentfees-func_bundle.php" method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name= "component_charge_id" id ="component_charge_id" value="<?php echo $component_charge_id; ?>">

                                                    <select class='form-control' name="ccid" id="ccid" required>
                                                        <option value="" >-- Select Fees --</option>
                                                        <?php 
                                                            $querydept = "SELECT *
                                                            FROM  charge_types ";
                                                            $query_rundept = mysqli_query($conn, $querydept);

                                                            if (mysqli_num_rows($query_rundept) > 0) {
                                                                while ($rowdept = mysqli_fetch_assoc($query_rundept)) {
                                                                    echo "<option  value='".$rowdept['chargetype_id']."'>".$rowdept['title']."</option>";
                                                                }
                                                            }
                                                        ?>
                                                    </select>

                                                    <div class="form-group">
                                                        <label for="department_name">Title</label>
                                                        <input type="text" disabled class="form-control" id="intitle" name="intitle" required placeholder="Enter title.">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtdescription">Description</label>
                                                        <textarea id="txtdescription" disabled name="txtdescription" class="form-control" required placeholder="Enter Description."></textarea>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="department_name">Amount</label>
                                                        <input type="text" disabled class="form-control" id="amount" name="amount" required placeholder="Enter title.">
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
            </td>
        
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                <div class="form-group">
                    <label for="department_name">Component Title:</label>
                    <input type="text" disabled class="form-control" value="<?php echo $componenttitle; ?>">
                </div>
            </div>
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                <div class="form-group">
                    <label for="department_name">Description:</label>
                    <textarea disabled class="form-control" cols="50%"><?php echo $componentdescription; ?></textarea>
                </div>
            </div>
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                <div class="form-group">
                    <label for="department_name">Total Fees:</label>
                    <input type="text" disabled class="form-control" value="₱<?php echo $componenttotal; ?>">
                </div>
            </div>
        
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                        <h1 class="h5 mb-0 text-gray-800">List of Fees under Component</h1>                     
                        <button type="button" class="btn btn-success " data-toggle="modal" data-target="#adddepartment" 
                            style="margin-bottom: 0;"><i class="fa fa-plus" aria-hidden="true"></i> Include Another Fee</button>
            </div>

            <?php
            //Displaying data into tables
            $query ="SELECT * FROM component_charge_fees ccf INNER JOIN charge_types ct ON ccf.chargetype_id = ct.chargetype_id where component_charge_id = $component_charge_id ORDER BY ccharge_fees_id DESC";
            $query_run=mysqli_query($conn, $query);
            ?>
            <table id = "dataTableID" class="table table-bordered table table-striped" width = "100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Amount</th>
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
                        <td><?php echo $row['ccharge_fees_id']; ?></td>   
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['purpose']; ?></td>
                        <td> ₱<?php echo $row['amount']; ?></td>
<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

                        <td>
                        </div>
                        <!--Delete Pop Up Modal -->
                        <div class="modal fade" id="delete<?php echo $row['ccharge_fees_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete Fee</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <form action="manage-componentfees-func_bundle.php" method = "POST"> 


                                        <div class="modal-body">
                                        
                                            <input type="hidden" name= "delete_ID" id ="" value="<?php echo $row['ccharge_fees_id']; ?>">
                                            <input type="hidden" name= "component_charge_id" id ="" value="<?php echo $component_charge_id; ?>">

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
                                <button type ="submit" name = "delete_btn" class = "btn btn-danger " data-toggle="modal" data-target="#delete<?php echo $row['ccharge_fees_id'];?>">Delete</button>
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



<script>

    //component_charge_id
    $(document).ready(function () {

        document.getElementById("ccid").onchange = previewfee;
        function previewfee(){

            //parse-fees-info.php
            //alert(this.value);

            if(this.value == ""){
                
                $('#intitle').val("");
                $('#amount').val("");
                $('#txtdescription').val("");
            }else{
                $.ajax({
                url: 'parse-fees-info.php?ccid='+this.value,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                        $('#intitle').val(data.title);
                        $('#amount').val(data.amount);
                        $('#txtdescription').val(data.purpose);

                }});
               
            } 
                
            
        }

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
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>







