<?php

include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');

?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


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
<div class="card-body">
    <div class="table-responsive">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                <h1 class="h5 mb-0 text-gray-800">TOR Requests List</h1>
            </div>
            <form action="tor_search.php" method="post">
                <div class="justify-content-end">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" placeholder="search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" name="refresh"><a href="tor_admin.php"><i class='bx bx-refresh'></i></a></button>
                            <button class="btn btn-outline-secondary" type="submit" name="submit">Search</button>
                        </div>
                    </div>
                </div>
            </form>

            <table id="" class="table table-responsive table-bordered table-striped" width="100%" cellspacing="0" style="font-size:12px;">
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
                    if (isset($_POST['submit'])) {
                        $searchTerm = mysqli_real_escape_string($conn, $_POST['search']);
                        $sql = "SELECT * FROM tor WHERE 
                        (firstname LIKE '%$searchTerm%' OR
                        lastname LIKE '%$searchTerm%' OR
                        email LIKE '%$searchTerm%' OR
                        or_number LIKE '%$searchTerm%') AND
                        status = ''";

                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
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
                                            <?php echo $row['status']; ?>
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
                            echo "<tr><td colspan='8'>No Record Found</td></tr>";
                        }
                        mysqli_free_result($result);
                        mysqli_close($conn);
                    }
                    ?>
                </tbody>
            </table>
        </div>
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
                        text: 'You want to approve this request? ' ,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, approve it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Use AJAX to send the approve request
                            $.ajax({
                                url: 'tor_admin_approve.php?id=' + id,
                                type: 'GET',
                                success: function (data) {
                                    // Update the table content or perform any necessary actions
                                    // For example, you can reload only the tbody section of the table
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
                                },
                                error: function (error) {
                                    console.error('Error approving request:', error);
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
