<?php
    include("dbcon.php");
    if(isset($_GET['uppstdid'])) {
        $student_id = $_GET['uppstdid'];

        $query = "SELECT * FROM student WHERE student_id = '$student_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $lastname = $row['lastname'];
                $firstname = $row['firstname'];
                $email = $row['email'];
                $student_id = $row['student_id'];
            } else {
                echo "No records found in the 'student' table.";
            }
        } else {
            echo "Error executing the query: " . mysqli_error($conn);
        }
    } else {
        echo "Student ID not provided in the URL.";
    }

    mysqli_close($conn);
?>
<?php
include("dbcon.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $lastname = $_POST['lastname'];
    $description = 'Proof of Payment';

    $targetDir = "../attachment/";
    $fileName = basename($_FILES["creds_submitted"]["name"]);
    $lastName = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $newFileName = "Proof_of_Payment-" . $lastName . "-" . uniqid() . "." . pathinfo($fileName, PATHINFO_EXTENSION);
    $targetFilePath = $targetDir . $newFileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
    $allowedTypes = array('pdf', 'jpg', 'jpeg');
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["creds_submitted"]["tmp_name"], $targetFilePath)) {
            $query = "INSERT INTO attachment (student_id, description, filename) 
                      VALUES ('$student_id', '$description','$newFileName')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<div></div>";
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                        Swal.fire({
                            title: 'Success',
                            text: 'Proof of payment sent successfully. We will email your credentials once we have verified all your requirements.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'index.html';
                            }
                        });
                    </script>";
                exit();
            } else {
                echo "Error inserting data: " . mysqli_error($conn);
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Only PDF, JPG, and JPEG files are allowed.";
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Transcript of Record</title>
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
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
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
          <a href="index.html"
            ><img src="./images/gm-logo.png" alt="" class="logo-gm" />Golden
            Minds Academy and Colleges</a
          >
        </h1>
        <nav id="nav">
          <ul>
            <li><a href="index.html">Home</a></li>
            <li>
              <a href="#">Menu</a>
              <ul>
                <li><a href="Announcements.html">Announcements</a></li>
                <li><a href="school calendar.html">School Calendar</a></li>
                <li><a href="courses.html">SHS Strands</a></li>
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
            <li>
              <a href="../newlogin.php" class="button primary" id="login_btn"
                >Log in</a
              >
            </li>
          </ul>
        </nav>
      </header>

      <!-- Main -->
      <div id="main" class="wrapper style1">
        <div class="container">
          <header class="major">
            <h2>Upload Proof of Payment</h2>
          </header>
          <section>
            <form method="post" enctype="multipart/form-data">
              <!-- Requester's Name -->
                <div class="row gtr-uniform gtr-50">
                <input type="hidden" name="student_id" id="student_id" value="<?php echo isset($student_id) ? $student_id : ''; ?>"/>
                    <div class="col-4 col-12-xsmall">
                        <input type="text" name="lastname" id="lastname" value="<?php echo isset($lastname) ? $lastname : ''; ?>" autocomplete="off" placeholder="Lastname" required />
                    </div>
                    <div class="col-4 col-12-xsmall">
                        <input type="text" name="firstname" id="firstname" value="<?php echo isset($firstname) ? $firstname : ''; ?>" autocomplete="off" placeholder="Firstname" required/>
                    </div>
                    <div class="col-4 col-12-xsmall">
                        <input type="text" name="middle_initial" id="middle_initial" value="<?php echo isset($middle_initial) ? $middle_initial : ''; ?>" autocomplete="off" placeholder="Middle Initial"/>
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
                        <label for="middle_initial">Middle Initial</label>
                    </div>
                </div>
                <br />

                <!-- user email -->
                <div class="row gtr-uniform gtr-50">
                    <div class="col-12">
                    <input type="text" name="email" id="email" value="<?php echo isset($email) ? $email : ''; ?>" autocomplete="off" placeholder="Email" required/>
                    </div>
                </div>
                <div class="row gtr-uniform gtr-50">
                    <div class="col-12">
                    <label for="address">Email</label>
                    </div>
                </div>
                <br />

                <!-- Request Info -->
                <div class="row gtr-uniform">
                    <div class="col-12">
                        <div class="file-upload-wrapper">
                            <input type="file" id="creds_submitted" name="creds_submitted" accept=".pdf, .jpg, .jpeg" required />
                            <span class="file-upload-button">Choose File</span>
                        </div>
                        <label for="creds_submitted" class="file-upload-label">Upload Proof of Payment (PDF, JPG, JPEG)</label>
                    </div>
                </div>

              <br />
              <div class="col-12">
                <ul class="actions">
                  <li>
                    <input type="submit" name="submit" id="submit" class="primary"/>
                  </li>
                </ul>
              </div>
            </form>
          </section>
        </div>
      </div>

      <!-- Footer -->
      <footer id="footer" style="padding: 50px">
        <ul
          class="social-icons"
          style="list-style: none; padding: 0; margin: 0"
        >
          <li style="display: inline-block; margin-right: 10px">
            <a
              href="https://www.facebook.com/profile.php/?id=100070550542307"
              style="
                text-decoration: none;
                color: #ffffff;
                font-size: 30px;
                border-bottom: none;
              "
            >
              <i class="bx bxl-facebook"></i>
            </a>
          </li>

          <li style="display: inline-block; margin-right: 10px">
            <a
              href="#"
              style="
                text-decoration: none;
                color: #ffffff;
                font-size: 30px;
                border-bottom: none;
              "
            >
              <i class="bx bxl-linkedin"></i>
            </a>
          </li>
          <li style="display: inline-block; margin-right: 10px">
            <a
              href="https://l.facebook.com/l.php?u=https%3A%2F%2Fyoutube.com%2F%40goldenmindscolleges7588%3Ffeature%3Dshared%26fbclid%3DIwAR0hJIgq-HJrEXbyxVQiTKdvNoI-jFAvItV7M0KoZWHPM4pJLCs-AmExVfw&h=AT0K3oXYIb5WCvCvMmGAEJwdXqar7Je0QKml_yx5f0C5Aphe7ch6Med2TE8OUiOKQtnstTvCnW6s4Yg2q5AWD1lJgQH8xBiiLZcNm0Y5S0OivyXRzLJo3SLLS-x5ZGea05IJAA"
              style="
                text-decoration: none;
                color: #ffffff;
                font-size: 30px;
                border-bottom: none;
              "
            >
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
