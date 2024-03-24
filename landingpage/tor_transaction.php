<!DOCTYPE html>
<html>
  <head>
    <title>Transcript of Records Transaction Form</title>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, user-scalable=no"
    />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript
      ><link rel="stylesheet" href="assets/css/noscript.css"
    /></noscript>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
      color: black !important; /* Change font color to black */
    }

    header.major::after {
      background: #e3a539 !important;
    }

    /* Target specific input types */
    input[type="text"],
    input[type="date"],
    input[type="number"] {
      border-color: black !important; /* Change input border color to black */
      border-width: 1px; /* Set initial border width */
    }

    #tor_purpose {
      border-color: black !important; /* Change input border color to black */
      border-width: 1px; /* Set initial border width */
      color: black !important;
      font-weight: bold !important;
    }
    #tor_purpose:focus {
      border-color: rgb(
        127,
        98,
        61,
        0.5
      ) !important; /* Change input border color to transparent blue */
      border-width: 2px; /* Set thicker border width when focused */
    }

    /* Change border color and width of input fields when they are focused */
    input[type="text"]:focus,
    input[type="date"]:focus,
    input[type="number"]:focus {
      border-color: rgb(
        127,
        98,
        61,
        0.5
      ) !important; /* Change input border color to transparent blue */
      border-width: 2px; /* Set thicker border width when focused */
    }

    /* Change the color of placeholder text */
    input[type="text"]::placeholder,
    input[type="date"]::placeholder,
    input[type="number"]::placeholder {
      color: black !important; /* Change placeholder text color to black */
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
          <a href="index.html"><img src="./images/gm-logo.png" alt="" class="logo-gm">Golden Minds Academy and Colleges</a>
        </h1>
        <nav id="nav">
          <ul>
            <li><a href="index.html">Home</a></li>
            <li>
              <a href="#">Menu</a>
              <ul>
                <li><a href="Announcements.html">Announcements</a></li>
                <li><a href="school calendar.html">School Calendar</a></li>
                <li><a href="courses.html">Courses</a></li>
                <li>
                  <a href="#">Resources</a>
                  <ul>
                    <li><a href="#">Admission</a></li>
                    <li><a href="#">Inquiries</a></li>
                    <li><a href="tor.html">Transcript of Record</a></li>
                    <li><a href="#">Support</a></li>
                    <li><a href="#">Feedbacks</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="elements.html">Contact Us</a></li>
            <li><a href="../newlogin.php" class="button primary" id="login_btn">Log in</a></li>
          </ul>
        </nav>
      </header>

      <!-- Main -->
      <div id="main" class="wrapper style1">
        <div class="container">
          <header class="major">
            <h2>Transcript of Records Transaction Form</h2>
          </header>
          <section>
            <form  method="post" enctype="multipart/form-data">
            
              <!-- Request Info -->
              
              <br />
              <div class="row gtr-uniform gtr-50">
                <div class="col-6 col-12-xsmall">
                  <input
                    type="number"
                    name="or_number"
                    id="or_number"
                    value=""
                    placeholder="OR Number ( please check email for OR number )"
                    required
                  />
                </div>
                
                <div class="col-6 col-12-xsmall">
                  <input
                    type="number"
                    name="paid_amount"
                    id="paid_amount"
                    value=""
                    placeholder="Amount Paid"
                    required
                  />
                </div>
              </div>
              <div class="row gtr-uniform gtr-50">
                <div class="col-6 col-12-xsmall">
                  <label for="or_number">OR Number</label>
                </div>
                <div class="col-6 col-12-xsmall">
                  <label for="paid_amount">Amount Paid</label>
                </div>
              </div>
              <br />
              <!-- Claiming Info -->
              <div class="row gtr-uniform gtr-50">
              <div class="col-6 col-12-xsmall">
                  <input
                    type="date"
                    name="requested_date"
                    id="requested_date"
                    value=""
                    placeholder="Date Requested"
                    required
                  />
                </div>
                <div class="col-6 col-12-xsmall">
                  <input
                    type="number"
                    name="contact"
                    id="contact"
                    values=""
                    placeholder="Contact Number"
                    required
                  />
                </div>
              </div>
              <div class="row gtr-uniform gtr-50">
                <div class="col-6 col-12-xsmall">
                  <label for="requested_date">Date Requested</label>
                </div>
                <div class="col-6 col-12-xsmall">
                  <label for="contact">Contact Number</label>
                </div>
              </div>
              <br />
              <div class="row gtr-uniform gtr-50">
                <div class="col-6 col-12-xsmall">
                  <input
                    type="text"
                    name="receiving_staff"
                    id="receiving_staff"
                    values=""
                    placeholder="Request Received by:(name of Staff)"
                    required
                  />
                </div>
                <div class="col-6 col-12-xsmall">
                  <input
                    type="file"
                    id="payment_proof"
                    name="payment_proof"
                    accept=".pdf, .doc, .docx, .jpg, .jpeg"
                    required
                  />
                </div>
              </div>
              <div class="row gtr-uniform gtr-50">
              <div class="col-6 col-12-xsmall">
                  <label for="receiving_staff">Request Received by: (name of Staff)</label>
              </div>
              <div class="col-6 col-12-xsmall">
                  <label for="creds_submitted">Upload Proof of Payment (PDF, DOC, DOCX, JPG, JPEG)</label>
              </div>
          </div>
              <br>
              <div class="col-12">
                <ul class="actions">
                  <li>
                    <input
                      type="submit"
                      name="submit"
                      id="submit"
                      class="primary"
                    />
                  </li>
                </ul>
              </div>
            </form>
          </section>
        </div>
      </div>

      <!-- Footer -->
<footer id="footer">
    <ul class="social-icons" style="list-style: none; padding: 0; margin: 0;">
        <li style="display: inline-block; margin-right: 10px;">
            <a href="#" style="text-decoration: none; color: #ffffff; font-size: 30px; border-bottom:none;">
                <i class='bx bxl-twitter'></i>
            </a>
        </li>
        <li style="display: inline-block; margin-right: 10px;">
            <a href="#" style="text-decoration: none; color: #ffffff; font-size: 30px;border-bottom:none;">
                <i class='bx bxl-facebook'></i>
            </a>
        </li>
        <li style="display: inline-block; margin-right: 10px;">
            <a href="#" style="text-decoration: none; color: #ffffff; font-size: 30px;border-bottom:none;">
                <i class='bx bxl-instagram'></i>
            </a>
        </li>
        <li style="display: inline-block; margin-right: 10px;">
            <a href="#" style="text-decoration: none; color: #ffffff; font-size: 30px;border-bottom:none;">
                <i class='bx bxl-linkedin'></i>
            </a>
        </li>
        <li style="display: inline-block; margin-right: 10px;">
            <a href="#" style="text-decoration: none; color: #ffffff; font-size: 30px;border-bottom:none;">
                <i class='bx bxl-youtube'></i>
            </a>
        </li>
    </ul>
    <ul class="copyright">
        <li style="display: inline-block;">&copy; Untitled. All rights reserved.</li>
        <li style="display: inline-block;">Design: <a href="http://html5up.net" style="text-decoration: none; color: #ffffff; border-bottom:none;">Group 2</a></li>
    </ul>
</footer>

    </div>

    <!-- Scripts -->
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
include('dbcon.php'); // Include your database connection file

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $requested_date = $_POST['requested_date'];
    $paid_amount = $_POST['paid_amount'];
    $or_number = $_POST['or_number'];
    $contact = $_POST['contact'];
    $receiving_staff = $_POST['receiving_staff'];

    // Check if the provided OR number exists in the database
    $sql_check_or_number = "SELECT * FROM tor WHERE or_number = ?";
    $stmt_check_or_number = $conn->prepare($sql_check_or_number);
    $stmt_check_or_number->bind_param("s", $or_number);
    $stmt_check_or_number->execute();
    $result_check_or_number = $stmt_check_or_number->get_result();

    if ($result_check_or_number->num_rows === 0) {
        // OR number not found, show notification
        echo "<div></div>";
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'OR number not found',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'tor_transaction.php';
                });
            </script>";
    } else {
        // File upload handling
        $targetDir = "../admin/payment_proof/"; // Specify the directory where you want to store the uploaded files
        $fileName = basename($_FILES["payment_proof"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
            // Upload file to the server
            if (move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $targetFilePath)) {
                // Insert the file path into the database
                $sql = "UPDATE tor SET requested_date=?, amt_paid=?, contact=?, receiving_staff=?, payment_proof=? WHERE or_number=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sissss", $requested_date, $paid_amount, $contact, $receiving_staff, $targetFilePath, $or_number);

                // Execute the statement
                if ($stmt->execute()) {
                    // Success message if insertion is successful
                    echo "<div></div>";
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo "<script>
                            Swal.fire({
                                title: 'Success',
                                text: 'Form submission success',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = 'index.html';
                            });
                        </script>";
                } else {
                    // Error message if SQL statement execution failed
                    echo "<div></div>";
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo "<script>
                            Swal.fire({
                                title: 'Error',
                                text: 'Form submission failed',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = 'tor_transaction.php';
                            });
                        </script>";
                }
                // Close the statement
                $stmt->close();
            } else {
                // Error message if file upload failed
                echo "<div></div>";
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'File upload failed',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = 'tor_transaction.php';
                        });
                    </script>";
            }
        } else {
            // Error message if file type is not allowed
            echo "<div></div>";
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Only PDF, DOC, DOCX, JPG, and JPEG files are allowed',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'tor_transaction.php';
                    });
                </script>";
        }
    }

    // Close the connection
    $conn->close();
} else {
    // If form is not submitted via POST method, redirect back to the form page
    // header("Location: index.html");
    exit();
}
?>
