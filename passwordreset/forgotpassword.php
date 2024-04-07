<?php include ('topbar.php'); ?>

<!DOCTYPE html>
<html lang ="en">

<head>
    <meta charset="UTF-8">
	<title> Password Reset </title>
    <meta name="viewport" content="width = device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/header.css?version=<?php echo time(); ?>">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>


	<div class = "cont">
		<div class="space"> </div>
			<div class="container d-flex justify-content-center align-items-center">
			<form id="login_form" class="form-signin" method="post" action="send-password-reset.php">
				<div class="card text-center" style="width: 400px;">
						<div class="card-body ">
							<p class="card-text ">
								Enter your email address and we'll send you an email with instructions to reset your password.
							</p>
							<div class="form-outline">
								<input type="email" id="email" name="email" class="form-control my-3" placeholder="Email Address" required>
							</div>
							<button class="btn btn-primary w-100" style="background:#361e12 !important;">Request New Password</button>
								<a href="../newlogin.php" class="btn" style="color: #02062c;"> Sign in</a>
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
    background: #361e12 !important;
    background-repeat: repeat-x !important;
    border-color: #361e12 !important;
    color: #FFFFFF !important;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25) !important;
    transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;
}

</style>
