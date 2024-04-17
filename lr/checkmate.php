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

    if(isset($_POST['book_id'])){
        
        $book_no =$_POST['book_id'];
		$date = date('Y-m-d');
        $status = "Borrowed";
		//date_default_timezone_set('Asia/Manila');
		//$time = date('h:i:sa');

		$sql = "SELECT * FROM booklist WHERE book_id = '$book_no'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Cannot find QR Code number '.$book_no;
		}else{
				$row = $query->fetch_assoc();
				$id = $row['book_id'];
				$sql ="SELECT * FROM student WHERE student_id='$id'";
				$query=$conn->query($sql);
				if($query->num_rows>0){
				$status = "Returned";
				$query=$conn->query($sql);
				$_SESSION['success'] = 'Successfully Returned Book: '.$row['book_id'].' '.$row['book_title'];
			}else{
					$sql = "INSERT INTO borrowed_books(book_id, book_title, student_id,borrowed_date, status, returned_date) VALUES ('$book_no','','$date','0')";
					if($conn->query($sql) ===TRUE){
					 $_SESSION['success'] = 'Successfully Borrowed Book: '.$row['book_id'].' '.$row['book_title'];
			 }else{
			  $_SESSION['error'] = $conn->error;
		   }	
		}
	}

	}else{
		$_SESSION['error'] = 'Please scan your QR Code number';
} 
header("location: issue-book.php");
	

$conn->close();
