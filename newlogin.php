

<?php
// Start output buffering if needed
ob_start();
session_start();
include('dbcon.php');

if (isset($_SESSION['username'])) {
    // Check user type and redirect to the appropriate dashboard
    if ($_SESSION['user_type'] === 'student') {
        header('Location: student/index.php');
        exit();
    } elseif ($_SESSION['user_type'] === 'teacher') {
        header('Location: teacher/index.php');
        exit();
    } elseif ($_SESSION['user_type'] === 'admin') { // Add support for 'admin' user type
        header('Location: admin/index.php');
        exit();
    } elseif ($_SESSION['user_type'] === 'LR') { // Add support for 'admin' user type
      header('Location: lr/index.php');
      exit();
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check in 'students' table
    $query = "SELECT * FROM student WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_type'] = 'student';
            $_SESSION['username'] = $username;
            $_SESSION['student_id'] = $row['student_id'];
            header('Location: student/index.php');
            exit();
        }
    }
    
     // Check in 'coordinators' table
     $query = "SELECT * FROM coordinators WHERE email = '$username'";
     $result = mysqli_query($conn, $query);
 
     if ($result->num_rows > 0) {
         $row = $result->fetch_assoc();
 
         // Verify the password
         if (password_verify($password, $row['password'])) {
             $_SESSION['user_type'] = 'LR';
             $_SESSION['username'] = $username;
             $_SESSION['coordinator_id'] = $row['coordinator_id'];
             header('Location: lr/index.php');
             exit();
         }
     }

    // Check in 'teachers' table
    $query = "SELECT * FROM teacher WHERE email = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_type'] = 'teacher';
            $_SESSION['username'] = $username;
            $_SESSION['teacher_id'] = $row['teacher_id'];
            header('Location: teacher/index.php');
            exit();
        }
    }

  // Check in 'admin' table (you may need to replace 'admin' with your actual admin user table name)
$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($conn, $query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['user_type'] = 'admin';
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $row['user_id']; // Include user_id in the session
    header('Location: admin/index.php');
    exit();
}


    $login_error = "Login failed. Please try again.";
}

// End output buffering if needed
ob_end_flush();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="../images/ltoo.png">
<!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<!-- icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<!-- css  -->
<link rel="stylesheet" href="style.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>
<style>
 .bg {
  height: auto !important;
  background-image: linear-gradient(
      to left,
      rgba(0, 0, 0, 0.8),
      rgba(0, 0, 0, 0.8)
    ),
    url("./img/gm.jpg") !important;
  background-position: center;
  background-size: cover;
  background-repeat: no-repeat;
}

.logo {
  height: 250px;
  width: auto;
}

.input-group-text {
  border-color: rgba(0, 0, 0, 0.15);
}

.forgot-password-link {
  position: relative;
  display: inline-block;
}

.forgot-password-link::before,
.forgot-password-link::after {
  content: "";
  position: absolute;
  bottom: 10px; /* Adjust vertical position */
  width: 110%; /* Adjust the width of the lines */
  height: 1px; /* Adjust the height of the lines */
  background-color: rgba(0, 0, 0, 0.15); /* Adjust the color of the lines */
}

.forgot-password-link::before {
  left: -155px;
}

.forgot-password-link::after {
  right: -155px;
}

.btn-login{
 background: #341c14;
 color:white;
}
.btn-login:hover{
 background: #7f623d;
 color:white;
}

.txt-hdr {
  color: transparent; /* Make text transparent */
  font-weight: bold;
  background-image: linear-gradient(to left, #E5A535, #efe3be); /* Gradient color */
  -webkit-background-clip: text; /* Apply gradient to text */
  background-clip: text; /* Apply gradient to text */
}

.home-btn a{
 text-decoration: none !important;
 color: #ffff !important;
}
.home-btn a:hover{
 color: #7f623d !important;
}
.custom-alert {
        position: fixed;
        top: 10px;
        right: 10px;
        z-index: 1000;
        padding: 10px;
        background-color: #ff3333;
        color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        opacity: 0; /* Start with 0 opacity for the fade-in effect */
        transition: opacity 0.3s ease-in-out;
    }



</style>
<body>
 <?php
                        if (isset($login_error)) {
                          echo '<script>
                          document.addEventListener("DOMContentLoaded", function() {
                              var alertContainer = document.createElement("div");
                              alertContainer.classList.add("custom-alert");
                              alertContainer.innerHTML = "' . $login_error . '</p>";
                              document.body.appendChild(alertContainer);
              
                              // Triggering reflow to enable the fade-in effect
                              alertContainer.offsetHeight;
              
                              alertContainer.style.opacity = 1; // Fading in
              
                              setTimeout(function() {
                                  alertContainer.style.opacity = 0; // Fading out
                              }, 4000); // Adjust the time (in milliseconds) the alert will be displayed
              
                              setTimeout(function() {
                                  alertContainer.remove();
                              }, 5000); // Adjust the time (in milliseconds) the alert will be displayed + fade-out duration
                          });
                      </script>';
                      }
                      ?>
 
   <!-- Section: Design Block -->
<section class="bg px-3 py-3">
 
 

  <label class="text-light mt-2 mx-3 home-btn"for=""><a href="./landingpage/index.html">Home</a></label>

  <!-- Jumbotron -->
  <div class="px-4 py-5 px-md-5 text-center text-lg-start" >
    <div class="container">
      <div class="row gx-lg-5 align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <h1 class="my-5 display-4 fw-bold ls-tight text-light">
            <span class="txt-hdr">Golden Minds Colleges and Academy</span>  <br />Management Information System
          </h1>
          <p class="text-light">
          Golden Minds Bulacan is a private school that offers free education, produce graduates that are competitive in the current global trends
          </p>
        </div>

        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="card">
            <div class="card-body py-4 px-md-5">
            <form METHOD = "POST">
                <div class="text-center mb-1">
                    <a href="#"><img class="logo" src="./img/gm-logo.png" alt=""></a>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <!-- Email input -->
                        <input id="username" name="username"  type="text"  class="form-control" placeholder="Email / Username" required/>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col position-relative">
                        <!-- Password input -->
                        <div class="input-group">
                            <input id="password" name="password" type="password" class="form-control" placeholder="Password" required/>
                            <!-- Icon -->
                            <button class="btn btn-outline-secondary input-group-text" type="button"  >
                                <i class="bi bi-eye" id="togglePassword"></i>
                            </button>
                        </div>
                    </div>
                </div>
               
                <div class="row mb-4">
                    <div class="col text-center">
                        <a href="passwordreset/forgotpassword.php" class="forgot-password-link">Forgot Password?</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <!-- Submit btn -->
                        <button type="submit" class="btn btn-login form-control mb-3">Sign in</button>
                    </div>
                </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- password toggle js -->
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    
    togglePassword.addEventListener('click', () => {
        // Toggle the type attribute using the ternary operator
        password.type = password.type === 'password' ? 'text' : 'password';
        
        // Toggle the eye and eye-slash icon by toggling the 'bi-eye-slash' and 'bi-eye' classes
        togglePassword.classList.toggle('bi-eye-slash');
        togglePassword.classList.toggle('bi-eye');
        
        // Hide the password after 3 seconds
        setTimeout(() => {
            password.type = 'password';
            togglePassword.classList.remove('bi-eye-slash');
            togglePassword.classList.add('bi-eye');
        }, 3000);
    });
</script>





<!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>