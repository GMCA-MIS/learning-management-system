

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
  
      $hashed_password = md5($password);
  
      // Verify the password
      if ($hashed_password === $row['password']) {
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
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login | Golden Minds Colleges/Academy MIS</title>
    <link rel="icon" type="image/x-icon" href="img/gmlogo1.png">
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">



</body>
</html>

<body>
  <div class="wrapper" style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.897), rgba(0, 0, 0, 0.685)), url('img/gmbg.png') center no-repeat; background-size: cover; width: 100%; height: 100%;">>
    <div class="container main">
        <div class="row">
            <div class="col-md-6 side-image">
                       
            </div>
            <div class="col-md-6 right">
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
                <div class="input-box">
        
                <header>
                    <div class="header-content">
                        <div class="title">
                            <h2>Golden Minds Colleges and Academy Management Information System</h2>
                        </div>
                    </div>
                    Sign In to Start your session
                </header>
                   <form id="login-form" method="POST">
                        <div class="input-field">
                              <input type="text" class="input" id="username" name="username" required="" >
                              <label for="email">Username</label> 
                          </div> 
                        <div class="input-field">
                              <input type="password" id="password" name="password" class="input" id="pass" required="" >
                              <label for="pass">Password</label>
                          </div> 
                        <div class="input-field">
                              <input type="submit" class="submit" value="Sign In">
                        </div> 
                        <div class="signin">
                          <span>Forgot Password? <a href="passwordreset/forgotpassword.php">Click here</a></span>
                        </div>
                  </form>
                </div>  
            </div>
        </div>
    </div>
</div>
</body>
</html>

<style>
  /* POPPINS FONT */
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
*{
    font-family: 'Poppins', sans-serif;
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
.wrapper{
    background: #ececec;
    padding: 0 20px 0 20px;
}
.main{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
.side-image{
    background-image: url("img/gmlogo1.png");
    background-position: center;
    /* background-size: cover; */
    background-repeat: no-repeat;
    border-radius: 10px 0 0 10px;
    position: relative;
}
.row{
  width:  900px;
  height:550px;
  border-radius: 10px;
  background: #fff;
  padding: 0px;
  box-shadow: 5px 5px 10px 1px rgba(0,0,0,0.2);
}
.text{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.text p{
    color: #fff;
    font-size: 20px; 
}
i{
    font-weight: 400;
    font-size: 15px;
}
.right{
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}
.input-box{
  width: 330px;
  box-sizing: border-box;
}
img{
    width: 35px;
    position: absolute;
    top: 30px;
    left: 30px;
}
.input-box header{
    font-weight: 700;
    text-align: center;
    margin-bottom: 45px;
}
.input-field{
    display: flex;
    flex-direction: column;
    position: relative;
    padding: 0 10px 0 10px;
}
.input{
    height: 45px;
    width: 100%;
    background: transparent;
    border: none;
    border-bottom: 1px solid rgba(0, 0, 0, 0.2);
    outline: none;
    margin-bottom: 20px;
    color: #40414a;
}
.input-box .input-field label{
    position: absolute;
    top: 10px;
    left: 10px;
    pointer-events: none;
    transition: .5s;
}
.input-field input:focus ~ label
   {
    top: -10px;
    font-size: 13px;
  }
  .input-field input:valid ~ label
  {
   top: -10px;
   font-size: 13px;
   color: #381c14;
 }
 .input-field .input:focus, .input-field .input:valid{
    border-bottom: 1px solid #381c14;
 }
 .submit{
    border: none;
    outline: none;
    height: 45px;
    background: #ececec;
    border-radius: 5px;
    transition: .4s;
 }
 .submit:hover{
    background: #381c14;
    color: #fff;
 }
 .signin{
    text-align: center;
    font-size: small;
    margin-top: 25px;
}
span a{
    text-decoration: none;
    font-weight: 700;
    color: #000;
    transition: .5s;
}
span a:hover{
    text-decoration: underline;
    color: #000;
}
@media only screen and (max-width: 768px){
    .side-image{
        border-radius: 10px 10px 0 0;
    }
    img{
        width: 35px;
        position: absolute;
        top: 20px;
        left: 47%;
    }
    .text{
        position: absolute;
        top: 70%;
        text-align: center;
    }
    .text p, i{
        font-size: 16px;
    }
    .row{
        max-width:420px;
        width: 100%;
    }
}
  </style>

  <!-- --------------------------Header Style----------------------------- -->



<style>
*{
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
  text-decoration: none;
  list-style: none;
  font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
}

.cont {
  background-color: fff;
}
.bar{
  position: absolute;
  width: 100%;
  height: 50px;
  top: 0; 
  right: 0;
  z-index: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #02062c;
  padding: 33px 10%;
  transition: all .50s ease; 
  border-bottom: 2px solid #dba61e;
}

.logoPic{
  display: flex;
  margin-left: 30px;
}

.logoPic img{
  height: 50px;
  margin-right: 10px;
  border-radius: 50%;
  margin-top: 10px;
}

.logo{
  display: flex;
  flex-direction: column;
}

.logo span{
  color: white;
  margin-top: 10px;
  font-size: 1.2rem;
  font-weight: 600;
}

.logo .subtitle{
  margin-top: 0px;
  color: bisque;
  font-size: 0.9rem;
}

.logBar{
  display: flex;
  align-items: center;
}

.logBar a{
  margin-right: 25px;
  margin-left: 10px;
  color: white;
  font-size: 1.1rem;
  font-weight: 500;
  transition: all .50 ease;
}

.user{
  display: flex;
  align-items: center;
}

.user i {
  color: bisque;
  font-size: 21px;
  margin-right: 7px;
}



.logBar a:hover{
 color: #dba61e;
}

@media (max-width: 650px) {
  
  .logo .subtitle{
      font-size: 12px;
      margin-top: 3px;
  }

  .logo span{
      font-size: 1.3rem;
      font-weight: 600;
  }

  .logoPic img{
      height: 63px;
      margin-top: 3px;
  }

  .logBar a{
      display: none;
  }
}


/* Style the dropdown container */
.user-dropdown {
  position: relative;
  display: inline-block;
}

/* Style the dropdown content (hidden by default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #001653;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Style the dropdown links */
.dropdown-content a {
  color: white;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color on hover */
.dropdown-content a:hover {
  background-color: #110edf;
}



</style>