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
		$ta_id = 0;
        $stud_no =$_POST['stud_no'];
		$date = date('Y-m-d');
		date_default_timezone_set('Asia/Manila');
		$time = date('h:i:sa');

		$sql = "SELECT * FROM teacher WHERE teacher_id = '$stud_no'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Cannot find QR Code number '.$stud_no;
		}else{
				$row = $query->fetch_assoc();
				$id = $row['teacher_id'];
				$sql ="SELECT * FROM time_attendance WHERE teacher_id='$id' AND DATE(expected_timein)= DATE(NOW()) AND actual_timein = '0000-00-00 00:00:00'";
				$query=$conn->query($sql);
				if($query->num_rows>0){
					while($row=mysqli_fetch_assoc($query))
					{
						$ta_id = $row['ta_id'];
					}
					$sql = "UPDATE time_attendance SET actual_timein='$date $time'  WHERE ta_id ='$ta_id' ";
					$query=$conn->query($sql);
				
					$_SESSION['success'] = 'Successfully Time In: '.$row['firstname'].' '.$row['lastname'];
				}else{

					$sql ="SELECT * FROM time_attendance WHERE teacher_id='$id' AND DATE(expected_timein) = DATE(NOW()) ";
					$query=$conn->query($sql);
					while($rows=mysqli_fetch_assoc($query))
					{
						$ta_id = $rows['ta_id'];
					}

					$sql = "UPDATE time_attendance SET actual_timeout='$date $time'  WHERE ta_id ='$ta_id' AND DATE(expected_timein) = DATE(NOW())";
					if($conn->query($sql) ===TRUE){
					 $_SESSION['success'] = 'Successfully Time Out: '.$row['firstname'].' '.$row['lastname'];
					}else{
						$_SESSION['error'] = $conn->error;
					}	

				}
		}

	}else{
		$_SESSION['error'] = 'Please scan your QR Code number';
} 
header("location: manage-clockinandout.php");
	

$conn->close();
