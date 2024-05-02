<?php                
require '../database_connection.php'; 

$event_name = $_POST['event_name'];

$description = $_POST['description'];
$event_start_datetime = $_POST['event_start_date'] . ' ' . $_POST['event_start_time'] . ':00'; // Add seconds (00)
$event_end_datetime = $_POST['event_end_date'] . ' ' . $_POST['event_end_time'] . ':00'; // Add seconds (00)

$insert_query = "INSERT INTO `calendar_event_master`(`event_name`,`event_start_datetime`,`event_end_datetime`,`description`) VALUES ('$event_name','$event_start_datetime','$event_end_datetime', '$description')";             
if(mysqli_query($con, $insert_query))
{
    $data = array(
        'status' => true,
        'msg' => 'Event added successfully!'
    );
}
else
{
    $data = array(
        'status' => false,
        'msg' => 'Sorry, Event not added.'				
    );
}

echo json_encode($data);
?>
