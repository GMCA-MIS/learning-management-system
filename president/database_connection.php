<?php
    $host = "localhost";
	$username = "root";
	$password = "";
	$database = "kapstown";
	
	// Creating database connection
	$con = mysqli_connect($host,$username,"",$database);
	// Check database connection
	if(!$con)
	{
		die("Connection Failed: ". mysqli_connect_error());
	}
?>