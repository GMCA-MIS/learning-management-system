<?php
    include('includes/lr_session.php');
    include('includes/header.php');
    include('includes/navbar.php');
    include('dbcon.php');
?>
<style>
    a {
        text-decoration: none;
        /* Remove underline to the anchor text */
        color: black;
        /* Set the text color to blue */
    }

    a:hover {
        color: brown;
    }
    label {
        margin-top: 5%;
    }
</style>

<!--Code for queries-->
<?php 

    $insert = false;
    $update = false;
    $empty = false;
    $delete = false;
    $already_card = false;


    if(isset($_GET['delete'])) {

    $stud_no = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `cards` WHERE `stud_no` = $stud_no";
    $result = mysqli_query($conn, $sql);

    }
      
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset( $_POST['stud_no_edit'])){
      

    //Update the records
    $stud_no = $_POST["stud_no_edit"];
    $name = $_POST["edit_name"];
    $id_no = $_POST["id_no_edit"];
      

    //SQL query
    $sql = "UPDATE `cards` SET `name` = '$name' , `id_no` = '$id_no' WHERE `cards`.`stud_no` = $stud_no";
    $result = mysqli_query($conn, $sql);
    
    if($result) {
    
        $update = true;

    }

    else {
        echo "Sorry, we could not update your record.";

    }
    }
      
    else {
      
        $name = $_POST["name"];
        $dept = $_POST["dept"];
        $cat = $_POST["cat"];
        $address = $_POST["address"];
        $email = $_POST["email"];
        $dob = $_POST["dob"];
        $id_no = $_POST["id_no"];
        $phone = $_POST["phone"];
      
    if($name == '' || $id_no == '') {

        $empty = true;

    }
      
    else {
              
    //Check if the card no. is already registered or not
    $querry = mysqli_query($conn, "SELECT * FROM cards WHERE id_no= '$id_no' ");
            
        if(mysqli_num_rows($querry)>0)
        {
        $already_card = true;
        }
    
        else {
      
        // Image upload 
        $uploaddir = 'lr/img';
        $uploadfile = $uploaddir . basename($_FILES['image']['name']);
    
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
        } 

        else {
            echo "Possible file upload attack!\n";
        }
      
    // Sql query to be executed
    $sql = "INSERT INTO `cards`(`name`, `dept`, `cat`, `address`,`email`, `dob`, `id_no`, `phone`, `image`) VALUES ('$name','$dept','$cat','$address','$email','$dob','$id_no', '$phone', '$uploadfile')"; 
      
    // $sql = "INSERT INTO `cards` (`name`, `id_no`) VALUES ('$name', '$id_no')";
    $result = mysqli_query($conn, $sql);
         
        if($result) { 
            $insert = true;
        }

        else {
            echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
    } 
    }
    }
    }
    }

?>
<!--End of query-->

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
                <h1 class="h3 mb-0 text-gray-800">Library Card</h1>
            </div>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - User Information -->
                <?php include('includes/lr_name.php'); ?>

            </ul>

        </nav>
        <!-- End of Topbar -->


        <!--Alert Messages-->
        <!--Insert-->
        <?php
        if($insert){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> Your card has been inserted successfully.
                
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
              </div>";
        }
        ?>
        <!--Delete-->
        <?php
        if($delete){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> Your card has been deleted successfully.
                    
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
              </div>";
        }
        ?>
        <!--Update-->
        <?php
        if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> Your Card has been updated successfully
                    
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
              </div>";
        }
        ?>
        <!--If Empty-->
        <?php
        if($empty){
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Error!</strong> The Fields Cannot Be Empty! Please Give Some Values.
                    
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
              </div>";
        }
        ?>
        <!--If already have a card-->
        <?php
        if($already_card){
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Error!</strong> This Card is Already Added.
                    
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
              </div>";
        }
        ?>

        <!-- Begin Page Content -->
        <div class="modal-body">
            <!-- <ul class="nav nav-tabs" id="assignmentTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="createTab" data-toggle="tab" href="#createAssignment" role="tab"
                        aria-controls="createAssignment" aria-selected="true"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="uploadTab" data-toggle="tab" href="#uploadAssignment" role="tab"
                        aria-controls="uploadAssignment" aria-selected="false"></a>
                </li>
            </ul>
            -->
            <div></div>
            <div class="tab-content" id="assignmentTabsContent">
                <div class="tab-pane fade" id="uploadAssignment" role="tabpanel" aria-labelledby="uploadTab">
                    <?php
                    // Displaying data into tables
                    $query = "SELECT booklist.*, category.category_name
                    FROM booklist
                    JOIN category ON booklist.category_id = category.category_id
                    WHERE booklist.book_status =  'Archived'
                    ORDER BY booklist.book_id DESC";
                    $query_run = mysqli_query($conn, $query);
                    ?>
                            <table id="dataTableIDs" class="table table-bordered table table-striped" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Student Number</th>
                                        <th>Name</th>
                                        <th>ID Card Number</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc($query_run)) {
                                            $student_id = $row['student_id'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['name']; ?>
                                        </td>
                                        <td>
                                            <a href="view_book-all.php?book_id=<?php echo $book_id; ?>">
                                                <?php echo $row['id_card_number']; ?>
                                            </a>
                                        </td>
                                        <td style="display:none;">
                                            <?php echo $row['actions']; ?>
                                        </td>
                                        
                                        <?php 
                                            $sql = "SELECT * FROM `cards` order by 1 DESC";
                                            $result = mysqli_query($conn, $sql);
                                            $sno = 0;
                                                
                                                while($row = mysqli_fetch_assoc($result)){
                                            $sno = $sno + 1;
                                                echo "<tr>
                                                        <th scope='row'>". $sno . "</th>
                                                        <td>". $row['name'] . "</td>
                                                        <td>". $row['id_no'] . "</td>
                                                        <td> <button class='edit btn btn-sm btn-success col-5' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-danger col-5' id=d".$row['sno'].">Delete</button></td>
                                                        </tr>";
                                            } 
                                        ?>

                                        <!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                                        

                                        <td>


                                            <!--Restore Pop Up Modal -->
                                            <div class="modal fade" id="restore_bookModal" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Restore Book</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <form action="library-function.php" method="POST">


                                                            <div class="modal-body">

                                                                <input type="hidden" name="restore_ID" id="restore_ID">

                                                                <h5>Do you want to Restore this book? <br> <span
                                                                        style="font-size:15px;"> The book will not be
                                                                        available for other users to view. </span></h5>



                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit" name="restore_book"
                                                                    class="btn btn-success">Confirm</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" name="restore_btn" class="btn btn-success restore_btn">Restore</button>
                                        </td>
                                <!-- </div> -->
                                <!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
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
            <div class="tab-pane fade show active" id="createAssignment" role="tabpanel" aria-labelledby="createTab">
            <div class="card-body">

                        <div class="table-responsive">

                            <td>
                                <!--Add Pop Up Modal -->
                                <div class="modal fade" id="add_lcardkModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">New ID Card
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="container">
                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label for="name">Full Name</label>
                                                            <input type="text" class="form-control" placeholder="Full name" name="name">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="department">Department</label>
                                                            <select name="dept" class="custom-select custom-select">
                                                                <option selected></option>
                                                                <option value="Computer Studies">Computer Studies</option>
                                                                <option value="Education">Education</option>
                                                                <option value="Agriculture">Agriculture</option>
                                                                <option value="Junior High School">Junior High School</option>
                                                                <option value="Senior High School">Senior High School</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="category">Category</label>
                                                            <select name="cat" class="custom-select custom-select">
                                                                <option selected></option>
                                                                <option value="Student">Student</option>
                                                                <option value="Faculty">Faculty</option>
                                                                <option value="Admin">Admin</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <label for="address">Address</label>
                                                            <input type="text" class="form-control" placeholder="Type your address" name="address">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label for="email">Email</label>
                                                            <input type="text" class="form-control" placeholder="Your email" name="email">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="birthdate">Birthdate</label>
                                                            <input type="date" class="form-control" id="birthdate" name="dob">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label for="id">ID Card No.</label>
                                                            <input type="text" class="form-control" placeholder="ID No." name="id_no">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="contact">Contact No.</label>
                                                            <input type="text" class="form-control" placeholder="Phone number" name="phone">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <label for="photo">Upload Photo</label>
                                                            <input type="file" class="form-control" name="image">
                                                        </div>
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                    <button type="submit" class="btn btn-warning">Submit</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                        <!--modal content -->
                                    </div>
                                    <!--modal dialog -->
                                </div>
                                <!--modal fade -->
                                <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_lcardkModal">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add New Card
                                </button>
                                <a href="generate-id.php">
                                    <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#gen_lcardModal">
                                        <i class="fa fa-address-card" aria-hidden="true"></i> Generate ID Card
                                    </button>
                                </a>
                                <a href="generate-qr.php">
                                    <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#gen_qrModal">  
                                        <i class="fa fa-qrcode" aria-hidden="true"></i> Generate QR Code
                                    </button>
                                </a>
                            </td>

                            <div class="d-sm-flex align-items-center justify-content-between mb-2"
                                style="margin-top: 10px; margin-left: 10px;">
                                <h1 class="h5 mb-0 text-gray-800"></h1>
                            </div>
                            
                            <?php
                            // Displaying data into tables
                            $query = "SELECT booklist.*, category.category_name
                            FROM booklist
                            JOIN category ON booklist.category_id = category.category_id
                            WHERE booklist.book_status = 'Available'
                            ORDER BY booklist.book_id DESC";
                            $query_run = mysqli_query($conn, $query);
                            ?>
                            <table id="dataTableID" class="table table-bordered table table-striped" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Student Number</th>
                                        <th>Name</th>
                                        <th>ID Card Number</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sql = "SELECT * FROM `cards` order by 1 DESC";
                                        $result = mysqli_query($conn, $sql);
                                        $stud_no = 0;
                                            
                                            while($row = mysqli_fetch_assoc($result)){
                                        $stud_no = $stud_no + 1;
                                            echo "<tr>
                                                    <th scope='row'>". $stud_no . "</th>
                                                    <td>". $row['name'] . "</td>
                                                    <td>". $row['id_no'] . "</td>
                                                    <td>
                                                        <button class='edit btn btn-sm btn-success col-5' id=".$row['stud_no'].">Edit</button>
                                                        <button class='delete btn btn-sm btn-danger col-5' id=d".$row['stud_no'].">Delete</button></td>
                                                  </tr>";
                                        } 
                                        ?>
                
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



<?php
    include('includes/scripts.php');
    include('includes/footer.php');
?>