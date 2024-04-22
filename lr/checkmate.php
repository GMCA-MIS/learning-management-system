<?php
    session_start();

?>            

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modal Popup Example</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Button to Open the Modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Open modal
</button>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Insert Data</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form id="insertForm">
          <div class="form-group">
            <label for="data">Data:</label>
            <input type="text" class="form-control" id="data" name="data">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  $('#insertForm').submit(function(e){
    e.preventDefault();
    $.ajax({
      type: "POST",
      //url: "checkmate.php",
      data: $(this).serialize(),
      success: function(response){
        alert(response);
        $('#myModal').modal('hide');
      }
    });
  });
});
</script>


<?php

$server = "srv1320.hstgr.io";
$username="u944705315_capstone2024";
$password="Capstone@2024.";
$dbname="u944705315_capstone2024";
$conn = new mysqli($server,$username,$password,$dbname);

// Check connection
if($conn->connect_error){
	die("Connection failed" .$conn->connect_error);
}

// Escape user inputs for security
$data = $_POST['data'];

// Attempt insert query execution
$sql = "INSERT INTO `borrowed_books` (`student_id`) VALUES ('$data')";
if($mysqli->query($sql) === true){
    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not execute $sql. " . $mysqli->error;
}

// Close connection
$mysqli->close();
?>


</body>
</html>