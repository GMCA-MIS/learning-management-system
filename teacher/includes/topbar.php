<?php 
include('initialize.php');
include('dbcon.php');
?>

<?php
// Assuming you have established a database connection earlier in your code

// Retrieve the image path from the database based on the session_id
$session_id = $_SESSION['teacher_id']; // Make sure you have this session variable set

$query = mysqli_query($conn, "SELECT * FROM teacher WHERE teacher_id = '$session_id'");
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
<header class="bar">
    <div class="logoPic">
        <img src="../img/gmlogo1.png" alt="logo">
        <a href="index.php" class="logo" style="text-decoration: none;">
            <span>Golden Minds Colleges and Academy</span>
            <p class="subtitle">Management Information System</p>
        </a>
    </div>
    <div class="user ml-auto">
        
        
        <a href="#" class="mr-4" onclick="toggleNotifi()">
            <i class="fa fa-bell" aria-hidden="true"></i>
        </a>
        
        
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="d-none d-lg-inline text-gray-600 small">Welcome! Teacher :  <?php echo $firstname . ' ' . $lastname; ?></span>
                <img class="img-profile rounded-circle" src="<?php echo $imageLocation; ?>" alt="Teacher Image" width="40" height="40">
            </a>
            <!-- Dropdown menu -->
            <div class="dropdown-menu" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile.php"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
               
            </div>
        </li>
    </div>
</header>
<style>
  #box {
    height: 0;
    opacity: 0;
    transition: height 0.3s ease, opacity 0.3s ease;
  }

  #inbox {
    height: 0;
    opacity: 0;
    transition: height 0.3s ease, opacity 0.3s ease;
  }
</style>

<nav>
  <div class="icon" onclick="toggleNotifi()"></div>
  <div class="notifi-box" id="box">
    <div class="notifi-scroll">
      <h6 class="text-center mt-4">Notifications</h6>
      <hr>

      <?php
       

        $sql = "SELECT *, s.picture AS picture
        FROM teacher_notification tn
        JOIN student s ON tn.student_id = s.student_id
        WHERE tn.teacher_id = $teacher_id ORDER BY teacher_notification_id DESC;
        ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            // Display each notification
            //echo "<a href='view_student_assignment_submissions.php?student_id=" . $row['student_id'] . "&post_id=" . $row['assignment_id'] . "&get_id=" . $row['teacher_class_id'] . "'>";
            echo "<div class='notifi-item'>";
            echo "<img src='" . $row['picture'] . "' alt='student-image'>";
            echo "<div class='text'>";
            echo "<h4><b>" . $row['firstname'] . " " . $row['lastname'] . "</b></h4>";
            echo "<h4>" . $row['notification'] . "</h4>";
            echo "<p>Date: " . $row['date_of_notification'] . "</p>";
            echo "</div>";
            echo "</div>";
            //echo "</a>";
          }
        } else {
          echo "<h6 class='text-center mt-4'>No notifications Yet</h6>";
        }
      ?>

    </div>
  </div>
</nav>

<nav>
  <div class="icon" onclick="toggleInbox()"></div>
  <div class="notifi-box" id="inbox">
    <div class="notifi-scroll">
      <h6 class="text-center mt-4">Inbox</h6>
      <hr>

      <?php
       

        $sql = "SELECT * FROM teacher_notification WHERE teacher_id = $teacher_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            // Display each notification
            echo "<div class='notifi-item'>";
            echo "<img src='img/avatar.png' alt='img'>"; // Replace with actual image source
            echo "<div class='text'>";
            echo "<h4>" . $row['notification'] . "</h4>";
            echo "<p>Date: " . $row['date_of_notification'] . "</p>";
            echo "<a href='view_student_assignment_submissions.php?student_id=" . $row['student_id'] . "&post_id=" . $row['assignment_id'] . "&get_id=" . $row['teacher_class_id'] . "'>View Assignment</a>";
            echo "</div>";
            echo "</div>";
          }
        } else {
          echo "<h6 class='text-center mt-4'>No notifications Yet</h6>";
        }
      ?>

    </div>
  </div>
</nav>

<script>
  var notificationBox = document.getElementById('box');
  var notificationDown = false;

  function toggleNotifi() {
    if (notificationDown) {
      notificationBox.style.height = '0px';
      notificationBox.style.opacity = 0;
      notificationDown = false;
    } else {
      notificationBox.style.height = '510px';
      notificationBox.style.opacity = 1;
      notificationDown = true;
    }
  }
</script>

<script>
  var inboxBox = document.getElementById('inbox');
  var inboxDown = false;

  function toggleInbox() {
    if (inboxDown) {
      inboxBox.style.height = '0px';
      inboxBox.style.opacity = 0;
      inboxDown = false;
    } else {
      inboxBox.style.height = '510px';
      inboxBox.style.opacity = 1;
      inboxDown = true;
    }
  }
</script>

</body>
</html>
	

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

.notifi-container {
    position: relative;
	display: inline-block;
}

.notifi-box {
	width: 300px;
	height: 0px;
	position: fixed;
	top: 63px;
	right: 220px;
	transition: 1s opacity, 250ms height;
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	height: 200px;
	overflow-y: auto;
  z-index: 9;
  background-color: white;
}

.notifi-scroll {
    max-height: 100%;
}
.notifi-box h2 {
	font-size: 14px;
	padding: 10px;
	border-bottom: 1px solid #eee;
	color: #999;
}
.notifi-box h2 span {
	color: #f00;
}
.notifi-item {
	display: flex;
	border-bottom: 1px solid #eee;
	padding: 2px 2px;
	margin-bottom: 5px;
	cursor: pointer;
}
.notifi-item:hover {
	background-color: #eee;
}
.notifi-item img {
    display: block;
    width: 40px; 
    height: 40px; 
    margin-right: 10px;
	margin-left: 5px;
    border-radius: 50%;
}

.notifi-item .text h4 {
	color: #777;
	font-size: 16px;
	margin-top: 10px;
}
.notifi-item .text p {
	color: #aaa;
	font-size: 12px;
}

.bar{
  position: sticky;
  width: 100%;
  height: 50px;
  top: 0; 
  right: 0;
  z-index: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-image: #361e12 !important;
  background-size: cover;
  transition: transform 1s ease, opacity 1s ease;
  background: #381c14;
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
    
