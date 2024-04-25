<?php
require '../database_connection.php';

if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    
    $query = "SELECT event_id, event_name, DATE_FORMAT(event_start_datetime, '%Y-%m-%d') AS event_start_date, TIME(event_start_datetime) AS event_start_time, DATE_FORMAT(event_end_datetime, '%Y-%m-%d') AS event_end_date, TIME(event_end_datetime) AS event_end_time, description FROM calendar_event_master WHERE event_id = $event_id";
    $result = mysqli_query($con, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $eventData = mysqli_fetch_assoc($result);
            $data = array(
                'status' => true,
                'data' => $eventData
            );
        } else {
            $data = array(
                'status' => false,
                'msg' => 'Event not found.'
            );
        }
    } else {
        $data = array(
            'status' => false,
            'msg' => 'Query execution error: ' . mysqli_error($con),
            'query' => $query // Debug: Add the actual query to the response
        );
    }
} else {
    $data = array(
        'status' => false,
        'msg' => 'Invalid event ID.'
    );
}

echo json_encode($data);
?>
