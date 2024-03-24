<?php
	include("dbcon.php");

	// Assuming you have a database connection established in "dbcon.php"
	// Make sure to replace "your_table_name" with the actual table name
	$query = "SELECT * FROM content where content_id = 1";

	$result = mysqli_query($conn, $query);

	if ($result) {
		// Check if there are any rows returned
		if (mysqli_num_rows($result) > 0) {
			// Loop through the results and process each row
			while ($row = mysqli_fetch_assoc($result)) {
				// Access columns using $row['column_name']
				$content_id = $row['content_id'];
				$content = $row['content'];
				$title = $row['title'];

			}
		} else {
			echo "No records found in the 'content' table.";
		}
	} else {
		echo "Error executing the query: " . mysqli_error($conn);
	}

	// Close the database connection when you're done
	mysqli_close($conn);
?>

<?php
	include("dbcon.php");

	// Assuming you have a database connection established in "dbcon.php"
	// Make sure to replace "your_table_name" with the actual table name
	$query = "SELECT * FROM content where content_id = 2";

	$result = mysqli_query($conn, $query);

	if ($result) {
		// Check if there are any rows returned
		if (mysqli_num_rows($result) > 0) {
			// Loop through the results and process each row
			while ($row = mysqli_fetch_assoc($result)) {
				// Access columns using $row['column_name']
				$content_id = $row['content_id'];
				$content2 = $row['content'];
				$title2 = $row['title'];

			}
		} else {
			echo "No records found in the 'content' table.";
		}
	} else {
		echo "Error executing the query: " . mysqli_error($conn);
	}

	// Close the database connection when you're done
	mysqli_close($conn);
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Homepage</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/css/modal.css">
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload landing">
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1 id="logo"><a href="index.html">Golden Minds Colleges and Academy</a></h1>
					<nav id="nav">
						<ul>
							<li><a href="index.html">Home</a></li>
							<li>
								<a href="#">Menu</a>
								<ul>
									<li><a href="Announcements.html">Announcements</a></li>
									<li><a href="school calendar.html">School Calendar</a></li>
									<li><a href="courses.html">Courses</a></li>
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
							<li><a href="../login.php" class="button primary">Log in</a></li>
						</ul>
					</nav>
				</header>

			<!-- Banner -->
				<section id="banner">
					<div class="content">
						<header>
							<h2>Golden Minds Colleges</h2>
							<p>Providing Quality Education.</p>
						</header>
						<span class="image"><img src="../img/slshslogo.png" alt="" /></span>
					</div>
					<a href="#one" class="goto-next scrolly">Next</a>
				</section>

			<!-- One -->
				<section id="one" class="spotlight style1 bottom">
					<span class="image fit main"><img src="../img/slshsbg.jpg" alt="" /></span>
					<div class="content">
						<div class="container">
							<div class="row">
								<div class="col-4 col-12-medium">
									<header>
										<h2>ABOUT US</h2>
										<p>Golden Minds Colleges</p>
									</header>
								</div>
								<div class="col-4 col-12-medium">
									<p>
									</p>
								</div>
								<div class="col-4 col-12-medium">
									<p>ad</p>
								</div>
							</div>
						</div>
					</div>
					<a href="#two" class="goto-next scrolly">Next</a>
				</section>

			<!-- Two -->
				<section id="two" class="spotlight style2 right">
					<span class="image fit main"><img src="images/pic03.jpg" alt="" /></span>
					<div class="content">
						<header>
							<h2><?php echo $title?></h2>
						
						</header>
						<p> <?php echo $content?>
                        </p>
					</div>
					<a href="#three" class="goto-next scrolly">Next</a>
				</section>

			<!-- Three -->
				<section id="three" class="spotlight style3 left">
					<span class="image fit main bottom"><img src="../img/slshsbg.jpg" alt="" /></span>
					<div class="content">
						<header>
                        <h2><?php echo $title2?></h2>
						</header>
                        <p> <?php echo $content2?>
					</div>
					<a href="#four" class="goto-next scrolly">Next</a>
				</section>

			<!-- Four -->
				<section id="four" class="wrapper style1 special fade-up">
					<div class="container">
						<header class="major">
							<h2>Discover What's Happening: Events and Announcements</h2>
							<p>Stay informed and be a part of our vibrant educational community. Explore upcoming events, workshops, and important announcements that enrich your learning journey and foster a sense of connection and engagement.</p>
						</header>
						<div class="box alt">
							<div class="row gtr-uniform">
								<section class="col-4 col-6-medium col-12-xsmall">
									<span class="icon solid alt major fa-comment"></span>
									<h3>Admission Application for SY 2023-2024</h3>
									<p>ADMINSSION TEXT </p>
								</section>
								<section class="col-4 col-6-medium col-12-xsmall">
									<span class="icon solid alt major fa-comment"></span>
									<h3>GMC School Calendar (2nd Semester SY 2023-2024)</h3>
									<p>CALEDAR </p>
								</section>
								<section class="col-4 col-6-medium col-12-xsmall">
									<span class="icon solid alt major fa-flask"></span>
									<h3>IGSR Virtual Reunion 2023</h3>
									<p>REUNION </p>
								</section>
								<section class="col-4 col-6-medium col-12-xsmall">
									<span class="icon solid alt major fa-paper-plane"></span>
									<h3>ABM Strand 2023: 11th International Conference on Business, Accounting, Finance and Economics</h3>
									<p>ABM . </p>
								</section>
								<section class="col-4 col-6-medium col-12-xsmall">
									<span class="icon solid alt major fa-file"></span>
									<h3>GMC Virtual Alumni Homecoming and General Assembly 2024</h3>
									<p>Gmc  </p>
								</section>
								<section class="col-4 col-6-medium col-12-xsmall">
									<span class="icon solid alt major fa-lock"></span>
									<h3>GMC, CONFERRED OUTSTANDING EDUCATIONAL INSTITUTE 2023</h3>
									<p> </p>
								</section>
							</div>
						</div>
						<footer class="major">
							<ul class="actions special">
								<li><a href="#" class="button">View More</a></li>
							</ul>
						</footer>
					</div>
				</section>

			<!-- Five -->
				<section id="five" class="wrapper style2 special fade">
					<div class="container">
						<header>
							<h2>Sign Up</h2>
							<p></p>
						</header>
						<form method="post" action="#" class="cta">
							<div class="row gtr-uniform gtr-50">
								<div class="col-8 col-12-xsmall"><input type="email" name="email" id="email" placeholder="Your Email Address" /></div>
								<div class="col-4 col-12-xsmall"><input type="submit" value="Get Started" class="fit primary" /></div>
							</div>
						</form>
					</div>
				</section>

			<!-- Footer -->
				<footer id="footer">
					<ul class="icons">
						<li><a href="#" class="icon brands alt fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon brands alt fa-facebook-f"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon brands alt fa-linkedin-in"><span class="label">LinkedIn</span></a></li>
						<li><a href="#" class="icon brands alt fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon solid alt fa-envelope"><span class="label">Email</span></a></li>
					</ul>
					<ul class="copyright">
						<li>&copy; Golden Minds Colleges. All rights reserved.</li><li>Developed by: <a href="http://html5up.net">Group 2</a></li>
					</ul>
				</footer>

		</div>

		<!-- Scripts -->
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