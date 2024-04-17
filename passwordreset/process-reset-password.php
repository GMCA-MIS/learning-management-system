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
    die("Token has expired");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
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
    echo "<script>alert('Student Password updated. You can now login to your account.'); window.location.href = '../newlogin.php';</script>";
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
