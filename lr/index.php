<?php
include('includes/lr_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
?>

        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                
                 <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                  <!-- Topbar Search 
                  <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn primarybtn-new" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>-->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) 
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            Dropdown - Messages 
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>-->

                        

                        <!-- Nav Item - User Information -->
                        <?php include ('includes/lr_name.php'); ?>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Total Books Card-->
                        <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-sector shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div style = "color: rgba(23, 24, 32, 0.95); font-weight: bold;" class="text-m  text-uppercase mb-1">
                                                    Total Books</div>
                                                <div  class="h5 mb-0 font-weight-bold ">
                                                <?php
                                                  $total_books_query = "SELECT COUNT(*) AS total_books FROM booklist WHERE book_status IN ('Available', 'Archived')";
                                                    $total_books_result = mysqli_query($conn, $total_books_query);

                                                    if(mysqli_num_rows($total_books_result) > 0){
                                                        while($row = mysqli_fetch_assoc($total_books_result)){
                                                            echo '<div class="h1 mb-0 text-gray-800">'.$row['total_books'].'</div>';
                                                        }
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                           <i class="fa fa-book" aria-hidden="true" style="font-size:50px; color: black;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                             <!-- Total Pending Card-->
                        <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-sector shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                            <div style = "color: rgba(23, 24, 32, 0.95); font-weight: bold;" class="text-m  text-uppercase mb-1">
                                                    Pending for Approval</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $total_books_query = "SELECT COUNT(*) AS total_books FROM booklist WHERE book_status = '2' ";
                                                    $total_books_result = mysqli_query($conn, $total_books_query);

                                                    if(mysqli_num_rows($total_books_result) > 0){
                                                        while($row = mysqli_fetch_assoc($total_books_result)){
                                                            echo '<div class="h1 mb-0 text-gray-800">'.$row['total_books'].'</div>';
                                                        }
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fa fa-clock" aria-hidden="true" style="font-size:50px; color: black;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                             <!-- Total Archived Card-->
                        <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-sector shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                            <div style = "color: rgba(23, 24, 32, 0.95); font-weight: bold;" class="text-m  text-uppercase mb-1">
                                                    Available Books</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $total_books_query = "SELECT COUNT(*) AS total_books FROM booklist WHERE book_status = 'Available' ";
                                                    $total_books_result = mysqli_query($conn, $total_books_query);

                                                    if(mysqli_num_rows($total_books_result) > 0){
                                                        while($row = mysqli_fetch_assoc($total_books_result)){
                                                            echo '<div class="h1 mb-0 text-gray-800">'.$row['total_books'].'</div>';
                                                        }
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fa fa-check-circle" aria-hidden="true" style="font-size:50px; color: black;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                         <!-- Total Archived Card-->
                        <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-sector shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                            <div style = "color: rgba(23, 24, 32, 0.95); font-weight: bold;" class="text-m  text-uppercase mb-1">
                                                    Archived Books</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $total_books_query = "SELECT COUNT(*) AS total_books FROM booklist WHERE book_status = 'Archived' ";
                                                    $total_books_result = mysqli_query($conn, $total_books_query);

                                                    if(mysqli_num_rows($total_books_result) > 0){
                                                        while($row = mysqli_fetch_assoc($total_books_result)){
                                                            echo '<div class="h1 mb-0 text-gray-800">'.$row['total_books'].'</div>';
                                                        }
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fa fa-archive" aria-hidden="true" style="font-size:50px; color: black;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            
                           
<style>
    /* Custom CSS for Circular Progress Indicator */
.progress-circle {
    width: 100px; /* Adjust the width as needed */
    height: 100px; /* Adjust the height as needed */
    border: 6px solid #f3f3f3; /* Circle border color */
    border-top: 6px solid blue; /* Progress color (green in this example) */
    border-radius: 50%;
    display: inline-block;
    text-align: center;
    line-height: 100px; /* Center the number vertically */
}

.progress-circle-number {
    font-size: 24px; /* Adjust the font size as needed */
    font-weight: bold;
    color: black; /* Number color (green in this example) */
}

    </style>


                    </div>                       

                    <!-- Content Row -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

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

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>



    