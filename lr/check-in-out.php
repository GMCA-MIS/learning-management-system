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

    if(isset($_POST['stud_no'])){
        
        $stud_id =$_POST['stud_no'];
		$date = date('Y-m-d');
		date_default_timezone_set('Asia/Manila');
		$time = date('h:i:sa');

		$sql = "SELECT * FROM cards WHERE id_no = '$stud_id'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Cannot find QR Code number '.$stud_id;
		}else{
				$row = $query->fetch_assoc();
				$id = $row['stud_no'];
				$sql ="SELECT * FROM attendance WHERE id_no='$id' AND logdate='$date' AND status='0'";
				$query=$conn->query($sql);
				if($query->num_rows>0){
				$sql = "UPDATE attendance SET timeout='$time', status='1' WHERE id_no='$stud_id' AND logdate='$date'";
				$query=$conn->query($sql);
				$_SESSION['success'] = 'Successfully Time Out: '.$row['firstname'].' '.$row['lastname'];
			}else{
					$sql = "INSERT INTO attendance(stud_no,timein,logdate,status) VALUES('$stud_id','$time','$date','0')";
					if($conn->query($sql) ===TRUE){
					 $_SESSION['success'] = 'Successfully Time In: '.$row['firstname'].' '.$row['lastname'];
			 }else{
			  $_SESSION['error'] = $conn->error;
		   }	
		}
	}

	}else{
		$_SESSION['error'] = 'Please scan your QR Code number';
} 
header("location: qr-scanner.php");
	   
$conn->close();
?>