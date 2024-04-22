<?php
    session_start();

    $server = "srv1320.hstgr.io";
    $username="u944705315_capstone2024";
    $password="Capstone@2024.";
    $dbname="u944705315_capstone2024";

    $conn = new mysqli($server,$username,$password,$dbname);

    if($conn->connect_error){
        die("Connection failed" .$conn->connect_error);
    }

    // Escape user inputs for security
	$data = $mysqli->real_escape_string($_POST['data']);

	// Attempt insert query execution
	$sql ="INSERT INTO `borrowed_books` (`book_id`, `book_title`, `student_no`, `borrowed_date`, `status`, `returned_date`) 
           VALUES ('$book_no', '$book_title', '$borrower', '$date', '$status', '')";

	if($mysqli->query($sql) === true){
		echo "Records inserted successfully.";
	} else{
		echo "ERROR: Could not execute $sql. " . $mysqli->error;
	}

	header("location: issue-book.php");
	// Close connection
	$mysqli->close();
	