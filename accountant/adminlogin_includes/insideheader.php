<?php 
 session_start();
 $user_id = $_SESSION['user_id'];

 $select_user = mysqli_query($conn, "SELECT * FROM `reg_form` WHERE Reg_ID = '$user_id'") or die('query failed');
            if(mysqli_num_rows($select_user) > 0){
                $fetch_user = mysqli_fetch_assoc($select_user);
            };
?>

<!DOCTYPE html>
<html lang ="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/insideHeader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <header class ="bar">

    <div class="logoPic">
            <img src="style/logo2.png" alt="logo">
                <a href ="#" class="logo" style="text-decoration: none;">
                    <span>IQMSO Portal</span>
                    <p class="subtitle">Documented Information Management System</p>
                </a>
        </div>
        
        <div class="logBar">
            <a href ="#" class="user" style="text-decoration: none;"><i class="fa fa-user" aria-hidden="true"></i>Welcome, <?php echo $fetch_user['fname']; ?></a>
           <!--  <a href ="#" class="user"><i class="fa fa-user-plus" aria-hidden="true"></i>Register</a> -->
        </div>
        
    </header>
    
</body>
</html>
