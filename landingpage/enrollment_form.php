<?php
include('dbcon.php');

$id = $_GET['id'];

if ($id == "") {
    header("Location: index.html");
}
$sql = "SELECT student.*, strand.name
FROM student
LEFT JOIN strand ON strand.id = student.strand_id    
WHERE student.student_id =" . $id;

$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

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
                <!-- Header -->


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
                                        <input type="text" name="username" id="email" value="<?php echo $row['username'] ?>" autocomplete="off" placeholder="LRN No." required readonly />
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
                                        <input type="text" name="lastname" id="lastname" value="<?php echo $row['lastname'] ?>" autocomplete="off" placeholder="Lastname" required readonly />
                                    </div>
                                    <div class="col-4 col-12-xsmall">
                                        <input type="text" name="firstname" id="firstname" value="<?php echo $row['firstname'] ?>" autocomplete="off" placeholder="Firstname" required readonly />
                                    </div>
                                    <div class="col-4 col-12-xsmall">
                                        <input type="text" name="middle_initial" id="middle_initial" value="<?php echo $row['middle_initial'] ?>" autocomplete="off" placeholder="Middle Initial" required readonly />
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
                                        <label for="middle_initial">Middle Initial - input N/A if not applicable</label>
                                    </div>
                                </div>

                                <br />

                                <!-- user email -->
                                <div class="row gtr-uniform gtr-50">
                                    <div class="col-12">
                                        <input type="text" name="email" id="email" value="<?php echo $row['email'] ?>" autocomplete="off" placeholder="Email ( request status will be sent to this email )" required readonly />
                                    </div>
                                </div>
                                <div class="row gtr-uniform gtr-50">
                                    <div class="col-12">
                                        <label for="address">Email</label>
                                    </div>
                                </div>
                                <br />

                                <!-- Requester's Address -->
                                <div class="row gtr-uniform gtr-50">
                                    <div class="col-12">
                                        <input type="text" name="address" id="address" value="<?php echo $row['location'] ?>" autocomplete="off" placeholder="Address" required readonly />
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
                                            <option value="<?php echo $row['is_regular'] ?>" selected>
                                                <?php echo ($row['is_regular'] == 1) ? 'New Student' : 'Transferee'; ?>
                                            </option>
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
                                            <option value="<?php echo $row['grade_level'] ?>" selected><?php echo $row['grade_level'] ?></option>
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
                                            <option value="<?php echo $row['name'] ?>" selected>
                                                <?php echo $row['name'] ?>
                                            </option>

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
                                        <input type="date" name="dob" id="dob" value="<?php echo $row['dob'] ?>" autocomplete="off" placeholder="Date of Birth" required readonly />
                                    </div>
                                    <div class="col-8 col-12-xsmall">
                                        <input type="text" name="pob" id="pob" value="<?php echo $row['pob'] ?>" autocomplete="off" placeholder="Place of Birth" required readonly />
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
                                        <input type="text" name="highschool" id="highschool" value="<?php echo $row['highschool'] ?>" autocomplete="off" placeholder="Highschool" required readonly />
                                    </div>
                                    <div class="col-6">
                                        <input type="text" name="other_colleges" id="other_colleges" value="<?php echo $row['other_colleges'] ?>" autocomplete="off" placeholder="Other Colleges" required readonly />
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
                                        <input type="text" name="highschool_address" id="highschool_address" value="<?php echo $row['highschool_address'] ?>" autocomplete="off" placeholder="Address of Highschool" required />
                                    </div>
                                </div>
                                <div class="row gtr-uniform gtr-50">
                                    <div class="col-12">
                                        <label for="highschool_address">Address of Highschool</label>
                                    </div>
                                </div>
                                <br />

                                <!-- GMC Admission, Requirements, and Purpose of Request -->


                                <br />
                                <!-- Request Info -->


                                <?php
                                $getAttachmentQuery = "SELECT student.*, attachment.filename, attachment.description
                                    FROM student
                                    LEFT JOIN attachment ON attachment.student_id = student.student_id    
                                    WHERE student.student_id =" . $id;

                                $result1 = mysqli_query($conn, $getAttachmentQuery);

                                if ($result1) {
                                    if (mysqli_num_rows($result1) > 0) {
                                        while ($row1 = mysqli_fetch_assoc($result1)) {
                                ?>
                                            <div class="row gtr-uniform gtr-50">
                                                <div class="col-4">
                                                    <a href="/learning-management-system/uploads/<?php echo $row1['filename']; ?>" style="color:blue;"><?php echo $row1['filename']; ?></a>
                                                </div>
                                            </div>

                                            <div class="row gtr-uniform gtr-50">
                                                <div class="col-4">
                                                    <label for="creds_submitted"><?php echo $row1['description']; ?></label>

                                                </div>
                                            </div>

                                <?php
                                        }
                                    } else {
                                        echo "No records found";
                                    }
                                } else {
                                    // If there's an error in the query execution, handle it appropriately
                                    echo "Error: " . mysqli_error($conn);
                                } ?>

                                <!-- <div class="col-12">
                            <ul class="actions">
                                <li>
                                    <input type="submit" name="submit" id="submit" class="primary" />
                                </li>
                            </ul>
                        </div> -->
                            </form>
                        </section>
                    </div>
                </div>

                <!-- Footer -->


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

<?php
        }
    } else {
        echo "No records found";
    }
} else {
    // If there's an error in the query execution, handle it appropriately
    echo "Error: " . mysqli_error($conn);
}
?>