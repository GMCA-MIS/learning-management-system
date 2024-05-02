<?php
include('dbcon.php');
$sql = "SELECT * FROM strand";


$result = mysqli_query($conn, $sql);

$options = "";
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='" . $row["id"] . "'>" . $row["full_name_strand"] . " (" . $row["name"] . ")" ."</option>";
    }
} else {
    $options = "<option value=''>No options available</option>";
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Enrollment</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main_enroll.css" />
    <noscript>
        <link rel="stylesheet" href="assets/css/noscript.css" />
    </noscript>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }

    /* Target specific input fields by their IDs */
    #receiving_staff,
    #claiming_date,
    #contact,
    #requested_date,
    #or_number,
    #paid_amount {
        color: black !important;
        /* Change font color to black */
    }

    header.major::after {
        background: #e3a539 !important;
    }

    /* Target specific input types */
    input[type="email"],
    input[type="text"],
    input[type="date"],
    input[type="number"] {
        border-color: black !important;
        /* Change input border color to black */
        border-width: 1px;
        /* Set initial border width */
    }

    #tor_purpose {
        border-color: black !important;
        /* Change input border color to black */
        border-width: 1px;
        /* Set initial border width */
        color: black !important;
        font-weight: bold !important;
    }

    #tor_purpose:focus {
        border-color: rgb(127,
                98,
                61,
                0.5) !important;
        /* Change input border color to transparent blue */
        border-width: 2px;
        /* Set thicker border width when focused */
    }

    /* Change border color and width of input fields when they are focused */
    input[type="email"]:focus,
    input[type="text"]:focus,
    input[type="date"]:focus,
    input[type="number"]:focus {
        border-color: rgb(127,
                98,
                61,
                0.5) !important;
        /* Change input border color to transparent blue */
        border-width: 2px;
        /* Set thicker border width when focused */
    }

    /* Change the color of placeholder text */
    input[type="email"]::placeholder,
    input[type="text"]::placeholder,
    input[type="date"]::placeholder,
    input[type="number"]::placeholder {
        color: black !important;
        /* Change placeholder text color to black */
        font-weight: bold !important;
    }

    input[type="date"] {
        font-weight: bold !important;
        color: black !important;
    }

    label {
        color: black !important;
    }

    h2 {
        color: black !important;
    }

    .style1 {
        background: #f0f1f3 !important;
    }

    #header {
        background: #341c14 !important;
    }

    #footer {
        background: #341c14 !important;
    }

    #login_btn {
        background: #e3a539 !important;
        color: #fff !important;
    }

    #submit {
        background: #341c14 !important;
        color: #fff !important;
    }

    #login_btn:hover {
        background: #7f623d !important;
        color: #f0f1f3 !important;
    }

    #submit:hover {
        background: #7f623d !important;
        color: #f0f1f3 !important;
    }

    #header nav ul li a:hover {
        color: #e3a539 !important;
    }

    .logo-gm {
        vertical-align: middle;
        width: 100px;
        margin-left: -20px;
    }

    input {
        color: black !important;
        font-weight: bold;
    }

    
</style>

<body class="is-preload" onload="functionsload()">
    
    <div id="page-wrapper">
        <!-- Header -->
        <header id="header" class="hdr">
            <h1 id="logo">
                <a href="index.html"><img src="./images/gm-logo.png" alt="" class="logo-gm" />Golden
                    Minds Academy and Colleges</a>
            </h1>
            <nav id="nav">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li>
                        <a href="#">Menu</a>
                        <ul>
                            <li><a href="Announcements.html">Announcements</a></li>
                            <!-- <li><a href="school calendar.html">School Calendar</a></li> -->
                            <li><a href="courses.html">SHS Strands</a></li>
                            <!-- <li>
                                <a href="#">Resources</a>
                                <ul>
                                    <li><a href="#">Admission</a></li>
                                    <li><a href="#">Inquiries</a></li>
                                    <li><a href="tor.html">Transcript of Record</a></li>
                                    <li>
                                        <a href="enrollment.php">Enroll Now !</a>
                                    </li>
                                    <li><a href="#">Support</a></li>
                                    <li><a href="#">Feedbacks</a></li>
                                </ul>
                            </li>
                            -->
                            <li>
                                <a href="tor.html">Transcript of Record</a>
                            </li>
                            <li>
                                 <a href="enrollment.php">Enroll Now !</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="elements.html">Contact Us</a></li>
                    <li>
                        <a href="../newlogin.php" class="button primary" id="login_btn">Log in</a>
                    </li>
                </ul>
            </nav>
        </header>

        <!-- Main -->
        <div id="main" class="wrapper style1">
            <div class="container">
                <header class="major">
                    <h2>Enrollment Form</h2>
                </header>
                <section>
                    <form action="register.php" method="post" enctype="multipart/form-data">
                       
                        <!-- Personal Information -->

                        <div class="row gtr-uniform gtr-50">
                            <div class="col-3">
                                <label for="" style="background:#341C14;padding: 10px 20px 10px 10px;margin: 0px 0px 20px 0px; border-radius: 0 20px 20px 0
                                    "><b style="color:white;font-weight:bold;font-size:25px;">Personal Information</b></label>
                            </div>
                        </div>
                        <br />
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-6 col-12-xsmall">
                                <input type="text"  name="lastname" id="lastname" value="" autocomplete="off" placeholder="Last Name" required />
                            </div>
                            <div class="col-6 col-12-xsmall">
                                <input type="text" name="firstname" id="firstname" value="" autocomplete="off" placeholder="First Name" required />
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-6 col-12-xsmall">
                                <label for="lastname">Last Name <b style="color:red;font-weight:bold;">*</b></label>
                            </div>
                            <div class="col-6 col-12-xsmall">
                                <label for="firstname">First Name <b style="color:red;font-weight:bold;">*</b></label>
                            </div>
                        </div>
                        <br />
                        <div class="row gtr-uniform gtr-50" >
                            <div class="col-6 col-12-xsmall">
                                <input type="text" name="middle_initial" id="middle_initial" value="" autocomplete="off" placeholder="Middle Name"  />
                            </div>
                            <div class="col-6 col-12-xsmall">
                                <input type="text"  name="extended_name" id="extended_name" value="" autocomplete="off" placeholder="Extended Name"  />
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-6 col-12-xsmall">
                                <label for="middle_initial">Middle Name [ optional ]</label>
                            </div>
                            <div class="col-6 col-12-xsmall">
                                <label for="extended_name">Extended Name [ optional ]</label>
                            </div>
                        </div>

                        <br />

                        <div class="row gtr-uniform gtr-50" >
                            <div class="col-6 col-12-xsmall" >
                                <input type="radio" id="gender1" name="gender" value="male" checked>
                                <label for="gender1" style="margin-right:30px;  ">Male</label>
                                <input type="radio" id="gender2" name="gender" value="female" >
                                <label for="gender2">Female</label>    
                            </div>
                            <div class="col-6 col-12-xsmall">
                                <input type="text"  name="nationality" id="nationality" value="" autocomplete="off" placeholder="Nationality" required />
                            </div>
                        </div>
                        
                        
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-6 col-12-xsmall">
                                <label for="gender">Gender <b style="color:red;font-weight:bold;">*</b></label>
                            </div>
                            <div class="col-6 col-12-xsmall">
                                <label for="nationality">Nationality <b style="color:red;font-weight:bold;">*</b></label>
                            </div>
                        </div>
                        <br />

                        <div class="row gtr-uniform gtr-50">
                            <div class="col-4 col-12-xmall">
                                <input type="date" name="dob" id="dob" value="" autocomplete="off"  placeholder="Date of Birth" title="Please enter correct Birth date Range" required />
                            </div>
                            <div class="col-8 col-12-xsmall">
                                <input type="text" name="pob" id="pob" value="" autocomplete="off"  placeholder="Place of Birth" required />
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-4 col-12-xsmall">
                                <label for="dob">Date of Birth <b style="color:red;font-weight:bold;">*</b></label>
                            </div>
                            <div class="col-8 col-12-xsmall">
                                <label for="pob">Place of Birth <b style="color:red;font-weight:bold;">*</b></label>
                            </div>
                        </div>
                        <br />
                        <br />

                        <!-- Contact Details  -->

                        <div class="row gtr-uniform gtr-50">
                            <div class="col-3">
                                <label for="" style="background:#341C14;padding: 10px 20px 10px 10px;margin: 0px 0px 20px 0px; border-radius: 0 20px 20px 0
                                    "><b style="color:white;font-weight:bold;font-size:25px;">Contact Information</b></label>
                            </div>
                        </div>
                        <br />
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-3">
                                <input type="text" name="streetaddress" id="streetaddress" value="" autocomplete="off" placeholder="House No. & Street" required />
                            </div>
                            <div class="col-3">
                                <select name="dropregion" value="" id="dropregion" required>
                                        <option value="" selected>
                                            -- Select Region --
                                        </option>
                                </select>   
                            </div>
                            <div class="col-3">
                                <select name="dropcities" value="" id="dropcities" required>
                                        <option value="" selected>
                                            -- Select City --
                                        </option>
                                </select>                               
                            </div>
                            <div class="col-3">
                                <select name="dropbrgy" value="" id="dropbrgy" required>
                                        <option value="" selected>
                                            -- Select Barangay --
                                        </option>
                                </select>                             
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-3">
                                <label for="address">House No. & Street <b style="color:red;font-weight:bold;">*</b></label>
                            </div>
                            <div class="col-3">
                                <label for="address">Province/Region <b style="color:red;font-weight:bold;">*</b></label>
                            </div>
                            <div class="col-3">
                                <label for="address">City <b style="color:red;font-weight:bold;">*</b></label>
                            </div>
                            <div class="col-3">
                                <label for="address">Barangay <b style="color:red;font-weight:bold;">*</b></label>
                            </div>
                        </div>
                        <br />
                        <div class="row gtr-uniform gtr-50">
                            
                            <div class="col-4">
                                <input type="text" name="contact" id="contact" minlength="11" maxlength="11" autocomplete="off" placeholder="09XXXXXXX" required />
                            </div>
                            <div class="col-8">
                                <input type="email" style="width:100%;height:100%;padding:10px;border: 1px solid black;border-radius: 3px;" name="email" id="email" value="" autocomplete="off" placeholder="sample@gmail.com"  title="Not an email format" required />
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            
                            <div class="col-4">
                                <label for="address">Contact <b style="color:red;font-weight:bold;">*</b></label>
                            </div>
                            <div class="col-8">
                                <label for="address">Email <b style="color:red;font-weight:bold;">*</b></label>
                            </div> 
                        </div>
                        <br />
                        <div class="row gtr-uniform gtr-50">
                            
                            <div class="col-6   ">
                                <input type="text" name="guardianname" placeholder="Guardian Name" required />
                            </div>
                            <div class="col-3">
                                <input type="text" name="guardianrelation" id=""  placeholder="Relationship" required />
                            </div>
                            <div class="col-3">
                                <input type="text" name="guardiancontact" id="" minlength="11" maxlength="11" autocomplete="off" placeholder="09XXXXXXX" required />
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            
                            <div class="col-6">
                                <label for="address">Guardian Name</label>
                            </div> 
                            <div class="col-3">
                                <label for="address">Relationship</label>
                            </div> 
                            <div class="col-3">
                                <label for="address">Contact</label>
                            </div>
                        </div>
                        <br />
                        <br />

                        <!-- Contact Details  -->

                        <div class="row gtr-uniform gtr-50">
                            <div class="col-3">
                                <label for="" style="background:#341C14;padding: 10px 20px 10px 10px;margin: 0px 0px 20px 0px; border-radius: 0 20px 20px 0
                                    "><b style="color:white;font-weight:bold;font-size:25px;">Application For</b></label>
                            </div>
                        </div>
                        <br />

                        <div class="row gtr-uniform gtr-50" >
                            <div class="col-6 col-12-xsmall" >
                                <input type="radio" id="grade11" name="grade_level" value="11" checked>
                                <label for="grade11" style="margin-right:30px;">Grade 11</label>
                                <input type="radio" id="grade12" name="grade_level" value="12" >
                                <label for="grade12">Grade 12</label>    
                            </div>
                            <div class="col-6 col-12-xsmall" >
                                <input type="radio" id="semester1" name="semester" value="1st semester" checked>
                                <label for="semester1" style="margin-right:30px;  ">1st Semester</label>
                                <input type="radio" id="semester2" name="semester" value="2nd semester" >
                                <label for="semester2">2nd Semester</label>    
                            </div>
                        </div>
                        
                        
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-6 col-12-xsmall">
                                <label for="middle_initial">Grade Level <b style="color:red;font-weight:bold;">*</b></label>
                            </div>
                            <div class="col-6 col-12-xsmall">
                                <label for="middle_initial">Semester <b style="color:red;font-weight:bold;">*</b></label>
                            </div>
                        </div>
                        <br />

                        <div class="row gtr-uniform gtr-50">

                            <div class="col-12 col-12-xsmall">
                                     <input type="text" name="username" id="email" value="" autocomplete="off"  placeholder="LRN No." maxlength="12" pattern= "[0-9]+" title="Only numbers allowed" required />

                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-12 col-12-xsmall">
                                <label for="address">LRN No.</label>
                            </div>
                        </div>

                        <br />

                        <div class="row gtr-uniform gtr-50">
                            <div class="col-12">
                                <select name="course" value="" id="tor_purpose" required>
                                    <option value="" selected>
                                        -- Select Strand --
                                    </option>
                                    <?php echo $options; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-12">
                                <label for="course">Course/Program</label>
                            </div>
                        </div>
                        <br />
                        <br />

                        <!-- Other Information  -->

                        <div class="row gtr-uniform gtr-50">
                            <div class="col-3">
                                <label for="" style="background:#341C14;padding: 10px 20px 10px 10px;margin: 0px 0px 20px 0px; border-radius: 0 20px 20px 0
                                    "><b style="color:white;font-weight:bold;font-size:25px;">Other Information</b></label>
                            </div>
                        </div>
                        <br />

                        <!--  -->
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-6">
                                <input type="text" name="highschool" id="highschool" value="" autocomplete="off" placeholder="Highschool" required />
                            </div>
                            
                            <div class="col-6">
                                <input type="text" name="highschool_address" id="highschool_address" value="" autocomplete="off" placeholder="Address of Highschool" required />
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-6 col-12-xsmall">
                                <label for="highschool">Highschool</label>
                            </div>
                            <div class="col-6">
                                <label for="highschool_address">Address of Highschool</label>
                            </div>
                        </div>
                        <br />
                        <br />
                        <br />
                        
                        <!-- Documents  -->

                        <div class="row gtr-uniform gtr-50">
                            <div class="col-3">
                                <label for="" style="background:#341C14;padding: 10px 20px 10px 10px;margin: 0px 0px 20px 0px; border-radius: 0 20px 20px 0
                                    "><b style="color:white;font-weight:bold;font-size:25px;">Documents</b></label>
                            </div>
                        </div>
                        <br />

                        <div class="row gtr-uniform gtr-50">
                            <div class="col-4" for="creds_submitted1">
                                <input type="file" class="form-control" id="creds_submitted1" name="grade_slip" accept="application/pdf,  image/jpeg, image/jpg" required />
                            </div>
                            <div class="col-4" for="creds_submitted2">
                                <input type="file" id="creds_submitted2" name="cor" accept="application/pdf,  image/jpeg, image/jpg" />
                            </div>

                            <div class="col-4" for="creds_submitted3">
                                <input type="file" id="creds_submitted3" name="good_moral" accept="application/pdf,  image/jpeg, image/jpg" />
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">

                            <div class="col-4">
                                <label for="creds_submitted1">Upload Gradeslip (PDF, JPG, JPEG)</label>
                            </div>
                            <div class="col-4">
                                <label for="creds_submitted2">Upload Certificate of Recognition (PDF, JPG, JPEG)</label>
                            </div>
                            <div class="col-4">
                                <label for="creds_submitted3">Upload Good Moral (PDF, JPG, JPEG)</label>
                            </div>
                        </div>
                        <br>

                        <!--
                        <div class="row gtr-uniform gtr-50">

                            <div class="col-4">
                                <p style="color: red;">* For Transferee Only</p>
                            </div>
                        </div>
                        <br>
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-4" for="creds_submitted4">
                                <input type="file" id="creds_submitted4" name="tor" accept="application/pdf,  image/jpeg, image/jpg" />
                            </div>

                            <div class="col-4" for="creds_submitted5">
                                <input type="file" id="creds_submitted5" name="others" accept="application/pdf,  image/jpeg, image/jpg" />
                            </div>

                        </div>
                        <div class="row gtr-uniform gtr-50" >

                            <div class="col-4" >
                                <label for="creds_submitted4">TOR (PDF, JPG, JPEG)</label>
                            </div>
                            <div class="col-4" >
                                <label for="creds_submitted5">Other (PDF, JPG, JPEG)</label>
                            </div>
                        </div>
                        -->

                        <br />
                        <div class="col-12">
                            <ul class="actions">
                                <li>
                                    <input type="submit" name="submit" id="submit" class="primary" />
                                </li>
                            </ul>
                        </div>
                    </form>
                </section>
            </div>
        </div>

        <!-- Footer -->
        <footer id="footer" style="padding: 50px">
            <ul class="social-icons" style="list-style: none; padding: 0; margin: 0">
                <li style="display: inline-block; margin-right: 10px">
                    <a href="https://www.facebook.com/profile.php/?id=100070550542307" style="
                text-decoration: none;
                color: #ffffff;
                font-size: 30px;
                border-bottom: none;
              ">
                        <i class="bx bxl-facebook"></i>
                    </a>
                </li>

                <li style="display: inline-block; margin-right: 10px">
                    <a href="#" style="
                text-decoration: none;
                color: #ffffff;
                font-size: 30px;
                border-bottom: none;
              ">
                        <i class="bx bxl-linkedin"></i>
                    </a>
                </li>
                <li style="display: inline-block; margin-right: 10px">
                    <a href="https://l.facebook.com/l.php?u=https%3A%2F%2Fyoutube.com%2F%40goldenmindscolleges7588%3Ffeature%3Dshared%26fbclid%3DIwAR0hJIgq-HJrEXbyxVQiTKdvNoI-jFAvItV7M0KoZWHPM4pJLCs-AmExVfw&h=AT0K3oXYIb5WCvCvMmGAEJwdXqar7Je0QKml_yx5f0C5Aphe7ch6Med2TE8OUiOKQtnstTvCnW6s4Yg2q5AWD1lJgQH8xBiiLZcNm0Y5S0OivyXRzLJo3SLLS-x5ZGea05IJAA" style="
                text-decoration: none;
                color: #ffffff;
                font-size: 30px;
                border-bottom: none;
              ">
                        <i class="bx bxl-youtube"></i>
                    </a>
                </li>
            </ul>
            <ul class="copyright">
                <li style="display: inline-block">
                    &copy; Copyright 2024 WeDev Enthusiast All rights reserved.
                </li>
                <li style="display: inline-block">
                    EMAIL: inquire@goldenmindsbulacan.com
                </li>
                <li style="display: inline-block">contact us: +639394499844</li>
            </ul>
        </footer>
    </div>

    <!-- Scripts -->
    <script>
        // Get today's date
        var today = new Date();
        // Set the maximum date 5 years ago
        today.setFullYear(today.getFullYear() - 5);
        // Format the date as YYYY-MM-DD
        var maxDate = today.toISOString().split("T")[0];

        // Get the date input element
        var dateInput = document.getElementById("dob");

        // Set the maximum date
        dateInput.max = maxDate;


        function functionsload(){
            var selectregion = document.getElementById("dropregion");
            var selectcities = document.getElementById("dropcities");
            var selectbrgy = document.getElementById("dropbrgy");

            
            document.getElementById("dropregion").onchange = listdowncities;
            function listdowncities(){
                document.getElementById("dropcities").innerHTML = "";

                var optcity = document.createElement('option');
                optcity.value = "";
                optcity.innerHTML = " -- Select City --";
                selectcities.appendChild(optcity);


                document.getElementById("dropbrgy").innerHTML = "";

                var optbrgy = document.createElement('option');
                optbrgy.value = "";
                optbrgy.innerHTML = " -- Select Barangay --";
                selectbrgy.appendChild(optbrgy);

                $.ajax({
                url: 'https://psgc.gitlab.io/api/regions/'+this.value+'/cities/',
                type: "GET",
                dataType: "text",
                success: function (data) {
                    console.log(data)
                    var cities = JSON.parse(data);

                    for(var a in cities) {
                        console.log(a, cities[a].name);

                        var opt = document.createElement('option');
                        opt.value = cities[a].code;
                        opt.setAttribute("data-cities",cities[a].name);
                        opt.innerHTML = cities[a].name;
                        selectcities.appendChild(opt);
                    }
                }
                });
            }
            

            document.getElementById("dropcities").onchange = listbrgy;
            function listbrgy(){

                
                document.getElementById("dropbrgy").innerHTML = "";

                var optbrgy = document.createElement('option');
                optbrgy.value = "";
                optbrgy.innerHTML = " -- Select Barangay --";
                selectbrgy.appendChild(optbrgy);

                $.ajax({
                url: 'https://psgc.gitlab.io/api/cities/'+this.value+'/barangays/',
                type: "GET",
                dataType: "text",
                success: function (data) {
                    console.log(data)
                    var brgy = JSON.parse(data);

                    for(var a in brgy) {
                        console.log(a, brgy[a].name);

                        var opt = document.createElement('option');
                        opt.value = brgy[a].code;
                        opt.setAttribute("data-brgy",brgy[a].name);
                        opt.innerHTML = brgy[a].name;
                        selectbrgy.appendChild(opt);
                    }
                }
                });
            }

            $.ajax({
            url: 'https://psgc.gitlab.io/api/regions/',
            type: "GET",
            dataType: "text",
            success: function (data) {
                console.log(data)
                var region = JSON.parse(data);

                for(var a in region) {
                    console.log(a, region[a].name);

                    var opt = document.createElement('option');
                    opt.value = region[a].code;
                    opt.setAttribute("data-region",region[a].name);
                    opt.innerHTML = region[a].name;
                    selectregion.appendChild(opt);
                }
            }
            });


        }

        
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/jquery.dropotron.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>