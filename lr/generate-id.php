<?php
    include('includes/lr_session.php');
    include('includes/header.php');
    include('includes/navbar.php');
    include('dbcon.php');


$notfound = false;  
$html = '';
      
    if(isset($_POST['search'])) {

$stud_no = $_POST['stud_no'];
$sql = "Select * from cards where stud_no= '$stud_no' ";
$result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)>0) {
  

$html="";

    while($row=mysqli_fetch_assoc($result)) {
                           
$firstname = $row["name"];
$stud_no = $row["stud_no"];
$dob = $row["dob"];
$dept = $row['dept'];
$cat = $row['cat'];
$image = $row['image'];
$phone = $row['phone'];
$address = $row['address'];

//ID design
$html.="
    <!--Department-->
    <div class='row justify-content-center' style='height: 60px;'>
            <span class='font-weight-bold pt-5 mt-1' style='color: #e3a539; font-family: Poppins; font-size: 11px;'>
            $dept
            </span>
    </div>

    <!--ID Photo-->
    <div class='row mt-3'>
        <div class='col-3 pl-4'>
            <img class='mx-auto d-block' src='$image' style='width: 100px; height: 100px; background-size: 100px 100px; background-repeat: no-repeat;'/>
            
            </img>
        </div>

        <!--Full Name-->
        <div class='col-5'>
            <span class='font-weight-bold mx-auto' style='color: #FFF; font-family: Poppins; font-size: 25px;'>$firstname</br>
        </div>

        <!--Signature-->
        <div class='col-4'>
            <img src='img/signature.png' style='width: 100px; height: 100px;'>
        </div>
    </div>

    <!--Student Information-->
    <div class='row mt-1'>
        <!--ID No.-->
        <div class='col-3'>
        <span class='font-weight-bold ml-4' style='color: #fff; font-family: Poppins; font-size: 11px;'>$stud_no</span>
        </div>
        <div class='col-3'>
        <span class='font-weight-bold ml-1' style='color: #e3a539; font-family: Poppins; font-size: 12px;'>Category</span>
        </div>
        <div class='col-6'>
        <span  class='font-weight-bold ml-1' style='color: #e3a539; font-family: Poppins; font-size: 12px;'>Address</span>
        </div>
    </div>

    <!--Second Row-->
    <div class='row'>

        <div class='col-3'>
        <span class='font-weight-bold ml-5' style='color: #fff; font-family: Poppins; font-size: 11px;'></span>
        </div>
        <div class='col-3'>
        <span class='font-weight-normal' style='color: #fff; font-family: Poppins; font-size: 11px;'>$cat</span>
        </div>
        <div class='col-6'>
        <span  class='font-weight-normal' style='color: #fff; font-family: Poppins; font-size: 11px;'>$address</span>
        </div>
    </div>

    <!--Third Row-->
    <div class='row mt-1'>

        <div class='col-3 mx-auto'>
        <span class='font-weight-bold ml-5' style='color: #fff; font-family: Poppins; font-size: 12px;'></span>
        </div>
        <div class='col-3'>
        <span class='font-weight-bold ml-1' style='color: #e3a539; font-family: Poppins; font-size: 12px;'>Phone</span>
        </div>
        <div class='col-6'>
        <span  class='font-weight-bold ml-1' style='color: #e3a539; font-family: Poppins; font-size: 12px;'>Birthdate</span>
        </div>
    </div>

    <!--Last Row-->
    <div class='row'>

        <div class='col-3'>
        <span class='font-weight-bold ml-5' style='color: #fff; font-family: Poppins; font-size: 11px;'></span>
        </div>
        <div class='col-3'>
        <span class='font-weight-normal' style='color: #fff; font-family: Poppins; font-size: 11px;'>$phone</span>
        </div>
        <div class='col-6'>
        <span  class='font-weight-normal' style='color: #fff; font-family: Poppins; font-size: 11px;'>$dob</span>
        </div>
    </div>
    ";

}
}
}

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

        <!-- Begin Page Content -->
        <div class="modal-body">
            
            <div></div>
            <div class="tab-content" id="assignmentTabsContent">
                <div class="tab-pane fade" id="uploadAssignment" role="tabpanel" aria-labelledby="uploadTab">
            </div>
            <div class="tab-pane fade show active" id="createAssignment" role="tabpanel" aria-labelledby="createTab">
                <div class="card-body">

                    <div class="table-responsive">

                            <a href="manage-id-card.php">
                            <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_lcardkModal">
                                <i class="fa fa-eye" aria-hidden="true"></i> View Users
                            </button>
                            </a>
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
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content: ID Generator -->
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <label for="generate">Student ID Card No.</label>
                    <form class="form-group" action="generate-id.php" method="post">
                        <input type="search" class="form-control col-10" placeholder="Type your ID No. here" name="stud_no"><br>
                        <button type="submit" class="btn btn-success" name="search"><span class="fa fa-cog mr-3"></span>Generate</button>
                    </form>
                </div>
            
                <div class="preview-card col-6">
                    <div class="id-preview card mt-2" id="mycard" style="background: url('img/id-background.png'); background-size: contain; background-repeat: no-repeat; ">
                        <?php echo $html ?>
                    </div></br>
                    <center>
                        <button type="submit" class="btn btn-warning" onclick="kingDownload()">
                        <span class="fa-solid fa-download mr-3"></span>Download
                        </button>
                    </center>
                </div>
            </div>
        </div>

        <!--Download button script-->
    <script>

        function kingDownload() {

            var node = document.getElementById('mycard');

            domtoimage.toPng(node)
                .then(function (dataUrl) {
                    var img = new Image();
                    img.src = dataUrl;
                    downloadURI(dataUrl, 'id-card.png')
                })
                .catch(function (error) {
                    alert('Oops, something went wrong.', error);
                });

        }



        function downloadURI(uri, name) {
            var link = document.createElement("a");
            link.download = name;
            link.href = uri;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            delete link;
        }

        </script>

<?php
    include('includes/scripts.php');
    include('includes/footer.php');
?>
