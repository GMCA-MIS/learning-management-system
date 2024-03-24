<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/dbconn.php";

// Check the teacher table
$sqlTeacher = "SELECT * FROM teacher
        WHERE reset_token_hash = ?";

$stmtTeacher = $mysqli->prepare($sqlTeacher);
$stmtTeacher->bind_param("s", $token_hash);
$stmtTeacher->execute();
$resultTeacher = $stmtTeacher->get_result();
$userTeacher = $resultTeacher->fetch_assoc();

// Check the teacher table
$sqlCoordinator = "SELECT * FROM coordinators
        WHERE reset_token_hash = ?";

$stmtCoordinator = $mysqli->prepare($sqlCoordinator);
$stmtCoordinator->bind_param("s", $token_hash);
$stmtCoordinator->execute();
$resultCoordinator = $stmtCoordinator->get_result();
$userCoordinator = $resultCoordinator->fetch_assoc();

// Check the student table
$sqlStudent = "SELECT * FROM student
        WHERE reset_token_hash = ?";

$stmtStudent = $mysqli->prepare($sqlStudent);
$stmtStudent->bind_param("s", $token_hash);
$stmtStudent->execute();
$resultStudent = $stmtStudent->get_result();
$userStudent = $resultStudent->fetch_assoc();

if ($userTeacher === null && $userStudent === null && $userCoordinator === null) {
    die("Invalid Request");
}

if (
    ($userTeacher !== null && strtotime($userTeacher["reset_token_expires_at"]) <= time()) ||
    ($userStudent !== null && strtotime($userStudent["reset_token_expires_at"]) <= time()) ||
    ($userCoordinator !== null && strtotime($userCoordinator["reset_token_expires_at"]) <= time())
) {
    die("Password Request has been expired");
}

?>


<!DOCTYPE html>
<html lang ="en">

<head>
    <meta charset="UTF-8">
	<title> Password Reset </title>
    <meta name="viewport" content="width = device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/header.css?version=<?php echo time(); ?>">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function showLoadingSpinner() {
            // Disable the button
            document.getElementById("loading-button").disabled = true;

            // Show the loading spinner
            document.getElementById("spinner").style.display = "inline-block";

            // Simulate an asynchronous request (e.g., page loading)
            setTimeout(function () {
                // Re-enable the button and hide the spinner after a delay (simulating completion of the operation)
                document.getElementById("loading-button").disabled = false;
                document.getElementById("spinner").style.display = "none";
            }, 3000); // Simulated 3 seconds of loading time (adjust as needed)
        }
    </script>
</head>
<body>

<?php include('topbar.php'); ?>
	<div class = "cont">
		<div class="space"> </div>
			<div class="container d-flex justify-content-center align-items-center">
			<form id="login_form" class="form-signin" method="post" action="process-reset-password.php"> 
				<div class="card text-center" style="width: 400px;">
						<div class="card-body ">
							<p class="card-text ">
								Enter your email address and we'll send you an email with instructions to reset your password.
							</p>
							<div class="form-outline">
                                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
								<input type="password" id="password" name="password" class="form-control my-3" placeholder="Enter New Password" required>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control my-3" placeholder="Confirm New Password" required>
							</div>
							<button class="btn btn-primary w-100" style="background: #361e12 !important;">
							  <span id="btnText" onclick="showLoadingSpinner()">Save Changes</span>
                              <div class="loading-spinner" id="spinner"></div>
							</button>
						</div>
				</div>
			</form>
			</div>
	</div>

</body>
</html>

<style>
	.space {
		padding-top: 130px;
	}
	.card-body {
		color:  #666;
	}
	.container {
		color: white;
	}
	.btn-primary:hover {
    background-color:#361e12 !important;
    background-image: #361e12 !important;
    background-repeat: repeat-x !important;
    border-color: #361e12 !important;
    color: #FFFFFF !important;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25) !important;
    transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;
}


        /* Styles for the loading spinner */
        .loading-spinner {
            border: 4px solid rgba(0, 0, 0, 0.2);
            border-top: 4px solid #007BFF;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
            display: none; /* Initially hidden */
        }

        /* Keyframes for the loading spinner animation */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

</style>

