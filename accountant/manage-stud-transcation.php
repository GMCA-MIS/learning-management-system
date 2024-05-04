<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
$student_id = $_GET['student_id'];


$querydept = "SELECT *   FROM  student  s INNER JOIN strand st ON s.strand_id = st.id where student_id  = $student_id";
$query_rundept = mysqli_query($conn, $querydept);

if (mysqli_num_rows($query_rundept) > 0) {
    while ($row = mysqli_fetch_assoc($query_rundept)) {
                    
            $firstnamestud = $row["firstname"];
            $lastnamestud= $row["lastname"];
            $usernamestud= $row["username"];
            $strandname= $row["name"];
            $grade_levelstud= $row["grade_level"];
            $semesterstud= $row["semester"];
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
                        <h1 class="h3 mb-0 text-gray-800">Student Transactions</h1>
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
        
            <div class="container-fluid " style="margin-top: 10px; margin-left: 10px;">
                <div class="row">
                    <div class="col-5">
                        <!-- -->
                        <div class="row mb-2">
                            <div class="col-4">
                                <label>LRN:</label>
                            </div>
                            <div class="col-5">
                                <input class="form-control" type="text" value="<?php echo $usernamestud ; ?>" disabled/>
                            </div>
                        </div>
                        <!-- -->
                        <div class="row mb-2">
                            <div class="col-4">
                                <label>Student Name:</label>
                            </div>
                            <div class="col-5">
                                <input class="form-control" type="text" value="<?php echo $firstnamestud ." ". $lastnamestud ; ?>" disabled/>
                            </div>
                        </div>
                        <!-- -->
                        <div class="row mb-2">
                            <div class="col-4">
                                <label>Grade:</label>
                            </div>
                            <div class="col-5">
                                <input class="form-control" type="text" value="<?php echo $grade_levelstud ; ?>" disabled/>
                            </div>
                        </div>
                        <!-- -->
                        <div class="row mb-2">
                            <div class="col-4">
                                <label>Semester:</label>
                            </div>
                            <div class="col-5">
                                <input class="form-control" type="text" value="<?php echo $semesterstud ; ?>" disabled/>
                            </div>
                        </div>
                        <!-- -->
                    </div>
                    <div class="col" style="border:1px solid gray;padding:20px;border-radius:5px">
                        Panel for Component List
                    </div>                              
                </div>
            </div>
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                
            </div>
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                
            </div>
        
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                        <h1 class="h5 mb-0 text-gray-800">List of Fees under Component</h1>     
                        <div>                
                        <button type="button" class="btn btn-danger " data-toggle="modal" data-target="#adddepartment" 
                            style="margin-bottom: 0;"><i class="fa fa-plus" aria-hidden="true"></i> Additional Fee</button>
                        <button type="button" class="btn bg-success text-white " data-toggle="modal" data-target="#adddepartment" 
                            style="margin-bottom: 0;"><i class="fa fa-plus" aria-hidden="true"></i> Submit Payment</button>
                        </div>
            </div>

            <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Charges</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Payment</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>
            </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                    <?php
                    //Displaying data into tables
                    $query ="SELECT * FROM student_charge sc INNER JOIN charge_types ct ON sc.chargetype_id = ct.chargetype_id WHERE student_id = $student_id ORDER BY stud_charge_id  DESC";
                    $query_run=mysqli_query($conn, $query);
                    ?>
                    <table id = "dataTableID" class="table table-bordered table table-striped" width = "100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fees</th>
                                <th>Amount</th>                             
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(mysqli_num_rows($query_run) > 0) {
                                    while($row=mysqli_fetch_assoc($query_run))
                                    {
                                        ?>
                            <tr>
                                <td><?php echo $row['stud_charge_id']; ?></td>   
                                <td><?php echo $row['title']; ?></td>
                                <td> ₱<?php echo $row['amount']; ?></td>
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
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <?php
                    //Displaying data into tables
                    $query ="SELECT * FROM student_payment WHERE student_id = $student_id ORDER BY stud_payment_id  DESC";
                    $query_run=mysqli_query($conn, $query);
                    ?>
                    <table id = "dataTableID" class="table table-bordered table table-striped" width = "100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Submitted Date</th>
                                <th>Amount</th>        
                                <th>Status</th>         
                                <th>Remarks</th>                     
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(mysqli_num_rows($query_run) > 0) {
                                    while($row=mysqli_fetch_assoc($query_run))
                                    {
                                        ?>
                            <tr>
                                <td><?php echo $row['stud_payment_id ']; ?></td>   
                                <td><?php echo $row['payment_date']; ?></td>
                                <td> ₱<?php echo $row['payment_amount']; ?></td>
                                <td> ₱<?php echo $row['status']; ?></td>
                                <td> ₱<?php echo $row['remarks']; ?></td>
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
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
            </div>

           
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script>

    //component_charge_id
    $(document).ready(function () {

        
        $('pills-tab').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
        })
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







