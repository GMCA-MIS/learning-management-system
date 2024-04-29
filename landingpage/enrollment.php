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
    <link rel="stylesheet" href="assets/css/main.css" />
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

<body class="is-preload">
    
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
                        <!-- Requester's Name -->
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-12">
                                <input type="text" name="username" id="email" value="" autocomplete="off" placeholder="LRN No." maxlength="12" required />
                            </div>
                        </div>

                        <div class="row gtr-uniform gtr-50">
                            <div class="col-12">
                                <label for="address">LRN No.</label>
                            </div>
                        </div>
                        <br />
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-4 col-12-xsmall">
                                <input type="text"  name="lastname" id="lastname" value="" autocomplete="off" placeholder="Lastname" required />
                            </div>
                            <div class="col-4 col-12-xsmall">
                                <input type="text" name="firstname" id="firstname" value="" autocomplete="off" placeholder="Firstname" required />
                            </div>
                            <div class="col-4 col-12-xsmall">
                                <input type="text" name="middle_initial" id="middle_initial" value="" autocomplete="off" placeholder="Middle Name" required />
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-4 col-12-xsmall">
                                <label for="lastname">Last Name</label>
                            </div>
                            <div class="col-4 col-12-xsmall">
                                <label for="firstname">First Name</label>
                            </div>
                            <div class="col-4 col-12-xsmall">
                                <label for="middle_initial">Middle Name - input N/A if not applicable</label>
                            </div>
                        </div>

                        <br />

                        <!-- user email -->
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-8">
                                <input type="text" name="email" id="email" value="" autocomplete="off" placeholder="Email ( request status will be sent to this email )" required />
                            </div>
                            <div class="col-4">
                                <input type="text" name="contact" id="contact" minlength="11" maxlength="11" autocomplete="off" placeholder="09XXXXXXX" required />
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-8">
                                <label for="address">Email</label>
                            </div> 
                            <div class="col-4">
                                <label for="address">Contact</label>
                            </div>
                        </div>
                        <br />

                        <!-- Requester's Address -->
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-12">
                                <input type="text" name="address" id="address" value="" autocomplete="off" placeholder="Address" required />
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-12">
                                <label for="address">Address</label>
                            </div>
                        </div>

                        <br />

                        <!-- Requester's Course/Program -->
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-12">
                                <select name="is_regular" value="" id="tor_purpose" required>
                                    <option value="" selected>
                                        -- Select Student Type --
                                    </option>
                                    <option value="1">
                                        New Student
                                    </option>
                                    <option value="2">
                                        Transferee
                                    </option>
                                    <!--
                                    <option value="3">
                                        Irregular Student
                                    </option>
                                    -->
                                </select>
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-12">
                                <label for="course">Student Type</label>
                            </div>
                        </div>

                        <br />
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-12">
                                <select name="grade_level" value="" id="tor_purpose" required>
                                    <option value="" selected>
                                        -- Select Grade Level --
                                    </option>
                                    <option value="11">
                                        Grade 11
                                    </option>
                                    <option value="12">
                                        Grade 12
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-12">
                                <label for="course">Grade Level</label>
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

                        <!-- Requester's Birth Info -->
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
                                <label for="dob">Date of Birth</label>
                            </div>
                            <div class="col-8 col-12-xsmall">
                                <label for="pob">Place of Birth</label>
                            </div>
                        </div>

                        <br />

                        <!--  -->
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-6">
                                <input type="text" name="highschool" id="highschool" value="" autocomplete="off" placeholder="Highschool" required />
                            </div>
                            <div class="col-6">
                                <input type="text" name="other_colleges" id="other_colleges" value="" autocomplete="off" placeholder="Other Colleges" required />
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-6 col-12-xsmall">
                                <label for="highschool">Highschool</label>
                            </div>
                            <div class="col-6">
                                <label for="other_colleges">Other Colleges - input N/A if not applicable</label>
                            </div>
                        </div>
                        <br />

                        <!--  -->

                        <!-- hs address -->
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-12">
                                <input type="text" name="highschool_address" id="highschool_address" value="" autocomplete="off" placeholder="Address of Highschool" required />
                            </div>
                        </div>
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-12">
                                <label for="highschool_address">Address of Highschool</label>
                            </div>
                        </div>
                        <br />
                        <div class="row gtr-uniform gtr-50">

                        <div class="col-4">
                            <p style="color: red;">* For New Student Only</p>
                        </div>
                        </div>
                        <br />

                        <!-- GMC Admission, Requirements, and Purpose of Request -->


                        <br />
                        <!-- Request Info -->

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