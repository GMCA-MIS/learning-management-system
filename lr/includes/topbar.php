<?php 
include('initialize.php');
include('dbcon.php');
?>

<?php
// Assuming you have established a database connection earlier in your code

// Retrieve the image path from the database based on the session_id
$session_id = $_SESSION['teacher_id']; // Make sure you have this session variable set

$query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$session_id'");
if ($query) {
    $row = mysqli_fetch_assoc($query);
    $imageLocation = $row['location'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.7.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.2/dist/js/bootstrap.min.js"></script>
</head>
<body>
<header class ="bar">

    <div class="logoPic">
            <img src="img/slshslogo1.png" alt="logo">
                <a href ="index.php" class="logo" style="text-decoration: none;">
                    <span>Golden Minds College and Academy</span>
                    <p class="subtitle">Learning Management System</p>
                </a>
        </div>
        
        <div class="logBar">
            <div class="user-dropdown">
            <a href="#" role="button" id="userDropdown" data-bs-toggle="dropdown">
                <img class="img-profile rounded-circle" src="<?php echo $imageLocation; ?>" alt="Teacher Image" width="40" height="40"> <?php echo $row['firstname']." ".$row['lastname']; ?>
            </a>

                <div class="dropdown-content" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="profile_teacher.php"><i class="fa fa-user" aria-hidden="true"></i> My Profile</a>
                    <a class="dropdown-item" href="change_password_teacher.php"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Change Password</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php"><i class="icon-signout"></i> Logout</a>
                </div>
            </div>
        </div> <!-- Logbar -->
    </header>
    
</body>
</html>

	
	
	
	<!-- <div class="navbar navbar-fixed-top navbar-inverse">
           <div class="navbar-inner">
               <div class="container-fluid">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
                   <a class="brand" href="#">Welcome to: M - Learning</a>
							<div class="nav-collapse collapse">
								<ul class="nav pull-right">
												<?php /*?$query= mysqli_query($conn,"select * from teacher where teacher_id = '$session_id'")or die(mysqli_error());
														$row = mysqli_fetch_array($query);
												*/?>
												<li class="dropdown">
													<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user icon-large"></i><?php /* echo $row['firstname']." ".$row['lastname']; */ ?> <i class="caret"></i></a>
															<ul class="dropdown-menu">
																<li>
																	<a href="change_password_teacher.php"><i class="icon-circle"></i> Change Password</a>
																	<a tabindex="-1" href="#myModal" data-toggle="modal"><i class="icon-picture"></i> Change Avatar</a>
																	<a tabindex="-1" href="profile_teacher.php"><i class="icon-user"></i> Profile</a>
																</li>
																<li class="divider"></li>
																<li><a tabindex="-1" href="logout.php"><i class="icon-signout"></i>&nbsp;Logout</a></li>
															</ul>
												</li>
								</ul>
							</div>
            
               </div>
           </div>
</div> -->





<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;700&display=swap');
*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
    text-decoration: none;
    list-style: none;
}

.bar{
  position: relative;
  width: 100%;
  height: 50px;
  top: 0; 
  right: 0;
  z-index: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-image: linear-gradient(180deg, rgba(23, 24, 32, 0.95) 5%,rgba(23, 24, 32, 0.95) 100%) !important;
  background-size: cover;
  transition: transform 1s ease, opacity 1s ease;
  background: rgba(23, 24, 32, 0.95);
  opacity: 1;
  padding: 33px 10%;
  transition: all .50s ease; 
}

.logoPic{
  display: flex;
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
    
