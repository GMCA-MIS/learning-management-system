<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
?>
<link rel="stylesheet" href="@sweetalert2/themes/dark/dark.css">
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
                <h1 class="h3 mb-0 text-gray-800">Sections</h1>
                
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
                    <div class="modal fade" id="add_class" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Section</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form action="" method="POST">
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label for="strand">Grade</label>
                                            <select type="text" class="form-control" id="grade_level" name="grade_level" required placeholder="Enter Strand Type">
                                                <option class="form-control" disabled value="" selected> Select Grade </Option>
                                                <option class="form-control" value="11">11</Option>
                                                <option class="form-control" value="12">12</Option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" onclick="addsection();" name="add_class" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                            </div> <!--modal content -->
                        </div> <!--modal dialog -->
                    </div> <!--modal fade -->

                </td>



                <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                    <h1 class="h5 mb-0 text-gray-800">Section List</h1>
                </div>
                <?php
                //Displaying data into tables
                if (isset($_GET['class_name'])) {
                    $class_name_name = $_GET['class_name'];
                }
                $query = "SELECT * FROM class where strand = '$class_name_name'";
                $query_run = mysqli_query($conn, $query);
                ?>
        <table id="dataTableID" class="table table-bordered table table-striped" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Section Number</th>
                <th>Section</th>
                <th>Track-Strand</th>
                <th>Status</th>
                <th>View</th>
            </tr>
        </thead>
            <tbody>
            <?php
            if (mysqli_num_rows($query_run) > 0) {
                while ($row = mysqli_fetch_assoc($query_run)) {
            ?>
                <tr>
                    <td><?php echo $row['class_id']; ?></td>
                    <td><?php echo $row['class_name']; ?></td>
                    <td><?php echo $row['strand']; ?></td> 
                    <td><?php if ($row['status'] == 1) { ?>
                            <p>Active</p>
                        <?php
                        } else { ?>
                            <p>Inactive</p>
                        <?php
                        } ?>
                    </td>
                    <td width="15%">
                        <a href="classprofile.php?class_id=<?php echo $row['class_id']; ?>" class="btn btn-secondary">View Student List</a>
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




    <script src="sweetalert2/dist/sweetalert2.min.js"></script>
    <script>
        
        function addsection(){
            var classname = "<?php  echo $_GET['class_name'] ?>";
            var dropdown = document.getElementById("grade_level");
            var value = dropdown.options[dropdown.selectedIndex].value;
            if(value == ""){
                Swal.fire({
                    title: "Error",
                    text: "Select Grade",
                    icon: "error",
                    confirmButtonText: "OK"
                }).then(function() {
                    // response
                });
            }else{
           
                Swal.fire({
                    title: "Please confirm to Generate New Class",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Confirm"
                    }).then((result) => {

                        if (result.isConfirmed) {
                            // PHP get paramater
                            // send ajax
                            $.ajax({
                                url: 'manage-class-generateclass.php?classname=' + classname +"&grade_level=" + value,
                                method: 'GET',
                                success: function(response) {
                                    
                                    if(response == "New Class"){
                                        Swal.fire({
                                                title: "Success",
                                                text: "New Class Added!",
                                                icon: "success",
                                                confirmButtonText: "OK",
                                            }).then(function() {
                                                window.location.reload();
                                            });
                                    }else if(response == "Found a Class with below 50 students" ){
                                        Swal.fire({
                                                title: "Warning",
                                                text: "Cannot Create, Found a Class with below 50 students",
                                                icon: "warning",
                                                confirmButtonText: "OK"
                                            }).then(function() {
                                                // response
                                            });
                                    }else{
                                        alert(response);
                                    }
                                    
                                }
                            });
                        }
                });
            }
        }




        $(document).ready(function() {

            $('.edit_btn').on('click', function() {

                $('#editProcessModal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
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