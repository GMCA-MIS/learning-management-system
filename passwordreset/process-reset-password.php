<!DOCTYPE html>
<html lang ="en">

<head>
    <meta charset="UTF-8">
	<title> Password Reset </title>
    <meta name="viewport" content="width = device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/header.css?version=<?php echo time(); ?>">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</head>
<body>

<?php
$token = $_POST["token"];
$token_hash = hash("sha256", $token);
$mysqli = require __DIR__ . "/dbconn.php";

// Check if the token exists in the teacher table
$sqlTeacher = "SELECT * FROM teacher WHERE reset_token_hash = ?";
$stmtTeacher = $mysqli->prepare($sqlTeacher);
$stmtTeacher->bind_param("s", $token_hash);
$stmtTeacher->execute();
$resultTeacher = $stmtTeacher->get_result();
$userTeacher = $resultTeacher->fetch_assoc();

// Check if the token exists in the student table
$sqlStudent = "SELECT * FROM student WHERE reset_token_hash = ?";
$stmtStudent = $mysqli->prepare($sqlStudent);
$stmtStudent->bind_param("s", $token_hash);
$stmtStudent->execute();
$resultStudent = $stmtStudent->get_result();
$userStudent = $resultStudent->fetch_assoc();

// Check if the token exists in the student table
$sqlCoordinator = "SELECT * FROM coordinators WHERE reset_token_hash = ?";
$stmtCoordinator = $mysqli->prepare($sqlCoordinator);
$stmtCoordinator->bind_param("s", $token_hash);
$stmtCoordinator->execute();
$resultCoordinator = $stmtCoordinator->get_result();
$userCoordinator = $resultCoordinator->fetch_assoc();

if ($userTeacher === null && $userStudent === null && $userCoordinator === null) {
    die("Token not found");
}

if (strtotime($userTeacher["reset_token_expires_at"] ?? "") <= time() && strtotime($userStudent["reset_token_expires_at"] ?? "") <= time() && strtotime($userCoordinator["reset_token_expires_at"] ?? "") <= time()) {
    
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Token has expired',
        showConfirmButton: false
    }).then(function() {
        window.location = 'reset-password.php?token=". $_POST['token'] . "'; // Redirect to profile.php
    });
    </script>";
    
    die("Token has expired");
}


if (strlen($_POST["password"]) < 8) {

    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Password must be at least 8 characters',
        showConfirmButton: false
    }).then(function() {
        window.location = 'reset-password.php?token=". $_POST['token'] . "'; // Redirect to profile.php
    });
    </script>";

    die("Password must be at least 8 characters");
}

if (!preg_match("/[A-Z]/", $_POST["password"])) {

    
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Password must contain at least one capital letter!',
        showConfirmButton: false
    }).then(function() {
        window.location = 'reset-password.php?token=". $_POST['token'] . "'; // Redirect to profile.php
    });
    </script>";
    die("Password must contain at least one letter");
}


if (preg_match('/[^a-zA-Z\d]/', $_POST["password"])) {
   
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Password must contain at least one symbol!',
        showConfirmButton: false
    }).then(function() {
        window.location = 'reset-password.php?token=". $_POST['token'] . "'; // Redirect to profile.php
    });
    </script>";
    die("Password must contain at least one letter");
}



if (!preg_match("/[a-z]/i", $_POST["password"])) {

    
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Password must contain at least one letter!',
        showConfirmButton: false
    }).then(function() {
        window.location = 'reset-password.php?token=". $_POST['token'] . "'; // Redirect to profile.php
    });
    </script>";
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Password must contain at least one number!',
        showConfirmButton: false
    }).then(function() {
        window.location = 'reset-password.php?token=". $_POST['token'] . "'; // Redirect to profile.php
    });
    </script>";
    
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    


    
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Passwords must match!',
        showConfirmButton: false
    }).then(function() {
        window.location = 'reset-password.php?token=". $_POST['token'] . "'; // Redirect to profile.php
    });
    </script>";
    
    die("Passwords must match!");
}


// Update teacher table if the user is found in teacher table
if ($userTeacher !== null) {

    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sqlUpdateTeacher = "UPDATE teacher
            SET password = ?,
                reset_token_hash = NULL,
                reset_token_expires_at = NULL
            WHERE teacher_id = ?";
    $stmtUpdateTeacher = $mysqli->prepare($sqlUpdateTeacher);
    $stmtUpdateTeacher->bind_param("ss", $password_hash, $userTeacher["teacher_id"]);
    $stmtUpdateTeacher->execute();
    echo "<script>alert('Password updated. You can now login to your account.'); window.location.href = '../newlogin.php';</script>";
}

if ($userStudent !== null) {

    $password_hash = md5($_POST["password"]);

    $sqlUpdateStudent = "UPDATE student
            SET password = ?,
                reset_token_hash = NULL,
                reset_token_expires_at = NULL
            WHERE student_id = ?";
    $stmtUpdateStudent = $mysqli->prepare($sqlUpdateStudent);
    $stmtUpdateStudent->bind_param("ss", $password_hash, $userStudent["student_id"]);
    $stmtUpdateStudent->execute();
    echo "<script>alert(' Password updated. You can now login to your account.'); window.location.href = '../newlogin.php';</script>";
}

if ($userCoordinator !== null) {

    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sqlUpdateCoordinator = "UPDATE coordinators
            SET password = ?,
                reset_token_hash = NULL,
                reset_token_expires_at = NULL
            WHERE coordinator_id = ?";
    $stmtUpdateCoordinator = $mysqli->prepare($sqlUpdateCoordinator);
    $stmtUpdateCoordinator->bind_param("ss", $password_hash, $userCoordinator["coordinator_id"]);
    $stmtUpdateCoordinator->execute();
    echo "<script>alert('Password updated. You can now login to your account.'); window.location.href = '../newlogin.php';</script>";
}
?>
</body>
</html>