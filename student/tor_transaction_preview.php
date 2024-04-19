<?php
include('student_session.php');
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('dbcon.php');


$query = "SELECT * FROM student
          WHERE student_id = $student_id";

// Execute the query and get the result
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];

}

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
                <h1 class="h3 mb-0 text-gray-800">TOR Preview</h1>
            </div>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="card-body">

            <div class="table-responsive">



                <div class="card-body">
                    <div class="d-sm-flex align-items-center justify-content-between mb-2"
                        style="margin-top: 10px; margin-left: 10px;">
                        <h1 class="h5 mb-0 text-gray-800">TOR Transaction List</h1>
                    </div>
                    <form action="tor_transaction_search.php" method="post">
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
                            FROM tor where email = '" . $email. "'";
                    $query_run = mysqli_query($conn, $query);
                    ?>

                    <table id="" class="table table-responsive table-bordered table-striped " width="100%"
                        cellspacing="0" style="font-size:12px;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Purpose</th>
                                <!-- <th>Request Date</th> -->
                                <!-- <th>Claiming Date</th> -->
                                <th>Document</th>
                                <th>Email</th>
                                <th>Amount to Pay</th>
                                <th>Paid Amount</th>
                                <th>Claiming Date</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_assoc($query_run)) {

                                    ?>
                                    <tr>
                                        
                                      
                                        <td>
                                            <?php echo $row['firstname'] . " " . $row['lastname'] ; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['tor_purpose']; ?>
                                        </td>
                                        
                                        <td>
                                            <?php echo $row['doc_type']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['email']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['amt_to_pay']; ?>
                                        </td>
                                        
                                        <td>
                                            <?php echo $row['claiming_date']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['amt_paid']; ?>
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

<style>
    .swal2-title {
        font-size: 20px; /* Adjust the font size as needed */
    }
</style>
    <script>
    function confirmReq(id) {
        // Create a div element to hold the datepicker
        const wrapper = document.createElement('div');
        wrapper.innerHTML = `
            <input id="datepicker" type="date" placeholder="Select date" class="swal2-input">
        `;

        // Show the SweetAlert dialog with the datepicker
        Swal.fire({
            title: 'Confirm Payment Transaction OR No. '+id +'?\n\nplease select claiming date for document',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, confirm it!',
            html: wrapper, // Inject the datepicker here
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    const date = document.getElementById('datepicker').value;
                    // Use AJAX to send the approve request with date
                    $.ajax({
                        url: 'tor_transaction_confirm_func.php',
                        type: 'GET',
                        data: { id: id, date: date },
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
                    text: "Transaction Confirmed. TOR request status updated.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "tor_transaction_confirm.php";
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