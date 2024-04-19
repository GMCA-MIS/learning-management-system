<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');



?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<!--  -->



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
                <h1 class="h3 mb-0 text-gray-800">Manage TOR Requests</h1>
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



                <div class="card-body">
                    <div class="d-sm-flex align-items-center justify-content-between mb-2"
                        style="margin-top: 10px; margin-left: 10px;">
                        <h1 class="h5 mb-0 text-gray-800">TOR Requests List</h1>
                    </div>
                    <form action="tor_search.php" method="post">
                        <div class="justify-content-end">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search" placeholder="search" >
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" name="refresh"><i class='bx bx-refresh'></i></button>
                                    <button class="btn btn-outline-secondary" type="submit" name="submit" >Search</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    // Displaying data into tables
                    $query = "SELECT *
                            FROM tor where status = ''";
                    $query_run = mysqli_query($conn, $query);
                    ?>

                    <table id="" class="table table-responsive table-bordered table-striped " width="100%"
                        cellspacing="0" style="font-size:12px;">
                        <thead>
                            <tr>
                             <th>OR Number</th>
                                <th>Name</th>
                                <th>Purpose</th>
                                <th>Credentials</th>
                                <!-- <th>Request Date</th> -->
                                <!-- <th>Claiming Date</th> -->
                                <th>Document</th>
                                <th>Email</th>
                                <th>status</th>
                                <th style="width: 200px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_assoc($query_run)) {

                                    ?>
                                    <tr>
                                        
                                      
                                        <td>
                                            <a href="tor_profile.php?or_number=<?php echo $row['or_number']; ?>">
                                            <?php echo $row['or_number']; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $row['firstname'] . " " . $row['lastname'] ; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['tor_purpose']; ?>
                                        </td>
                                        <td>
                                        <?php
                                        // Get the file path from the database
                                        $filePath = $row['creds_submitted'];
                                        
                                        // Extract the file name from the file path
                                        $fileName = basename($filePath);
                                        
                                        // Display a link to view the file
                                        echo "<a href='$filePath' target='_blank'>$fileName</a>";
                                        ?>
                                    </td>
                                    <td>
                                            <?php echo $row['doc_type']; ?>
                                    </td>
                                    
                                        <td>
                                            <?php echo $row['email']; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if( empty( $row['status'] )){

                                                    echo "<b style='color:gray'> pending </b>";
                                                    
                                                }elseif($row['status'] == 'approved'){
                                                    echo "<b style='color:#FF8C00'> ".$row['status'] ." </b>";


                                                }elseif($row['status'] == 'confirmed'){
                                                    echo "<b style='color:green'> ".$row['status'] ."</b>";

                                                    
                                                }else{
                                                    echo "<b style='color:red'> ".$row['status'] ." </b>";

                                                }
                                            ?>
                                        </td>
                                        <td>
                                        <button type="button" name="edit_bttn" class="btn btn-success edit_btn btn-sm mb-2" onclick="confirmApprove('<?php echo $row['or_number']; ?>')" style="font-size:12px">Approve</button>
                                        <button type="button" name="delete_bttn" class="btn btn-danger delete_btn btn-sm mb-2" onclick="confirmReject('<?php echo $row['or_number']; ?>')" style="font-size:12px">
                                        Reject
                                      </button>
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

<!--  -->

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
            <script>
                $(document).ready(function(){
                    $("#section").on('change', function(){
                        var value = $(this).val();
                        $.ajax({
                            url:"filter.php",
                            type:"POST",
                            data:'request=' + value,
                            beforeSend:function(){
                                $(".modal-body").html("<span>Loading...</span>");
                            },
                            success:function(data){
                                $(".modal-body").html(data);
                            }
                        });
                    });
                });

                $(document).ready(function(){
                    $("#Type").on('change', function(){
                        var value = $(this).val();
                        $.ajax({
                            url:"filter.php",
                            type:"POST",
                            data:'requestType=' + value,
                            beforeSend:function(){
                                $(".modal-body").html("<span>Loading...</span>");
                            },
                            success:function(data){
                                $(".modal-body").html(data);
                            }
                        });
                    });
                });
            </script>
            <!-- script for reject validation -->
            <script>
                
                function confirmReject(id) {
                    // Generate select options
                    var selectOptions = '<option value="requirements">did not meet the specified requirements</option>';

                    // Create HTML for select input
                    var selectHtml = '<select id="reasonSelect" class="form-control">' + selectOptions + '</select>';

                    Swal.fire({
                        title: 'Are you sure?',
                        html: 'You want to reject this Request?' + '<br>Select Reason: ' + selectHtml,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, reject it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Get the selected reason
                            var reason = document.getElementById('reasonSelect').value;

                            // Use AJAX to send the reject request
                            $.ajax({
                                url: 'tor_admin_reject.php?id=' + id + '&reason=' + reason,
                                type: 'GET',
                                success: function (data) {
                                    // Update the table content or perform any necessary actions
                                    // For example, you can reload only the tbody section of the table
                                    Swal.fire({
                                        title: "Success",
                                        text: "Request rejected. TOR request status update has been sent to User",
                                        icon: "success",
                                        confirmButtonText: "OK"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "tor_admin.php";
                                        }
                                    });
                                },
                                error: function (error) {
                                    console.error('Error rejecting request:', error);
                                }
                            });
                        }
                    });
                }
            </script>
          <!-- script for req approval Validation -->
<script>
    function confirmApprove(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to approve this request? ' + id ,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!',
            input: 'number',
            inputLabel: 'Amount to Pay for document request', // Label for the input field
            inputPlaceholder: 'Enter amount', // Placeholder text for the input field
            inputAttributes: {
                min: 0, // Minimum value for the input
                step: 0.01 // Step value for the input (e.g., 0.01 for decimals)
            },
            inputValue: 0, // Initial value for the input field
            showLoaderOnConfirm: true,
            preConfirm: (amount) => {
                return new Promise((resolve) => {
                    // Use AJAX to send the approve request with amount
                    $.ajax({
                        url: 'tor_admin_approve.php?id=' + id + '&amount=' + amount,
                        type: 'GET',
                        success: function (data) {
                            resolve();
                        },
                        error: function (error) {
                            console.error('Error approving request:', error);
                        }
                    });
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Success",
                    text: "Request approved. TOR request status updated.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "tor_admin.php";
                    }
                });
            }
        });
    }
</script>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>