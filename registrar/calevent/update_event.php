<?php
require '../database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['event_id'], $_POST['event_name'], $_POST['event_start_date'], $_POST['event_start_time'], $_POST['event_end_date'], $_POST['event_end_time'])) {
        $event_id = $_POST['event_id'];
        $description = $_POST['description'];
        $event_name = $_POST['event_name'];
        $event_start_datetime = date("Y-m-d H:i:s", strtotime($_POST['event_start_date'] . ' ' . $_POST['event_start_time']));
        $event_end_datetime = date("Y-m-d H:i:s", strtotime($_POST['event_end_date'] . ' ' . $_POST['event_end_time']));

        // Update the event in the database
        $query = "UPDATE calendar_event_master SET event_name = '$event_name', event_start_datetime = '$event_start_datetime', event_end_datetime = '$event_end_datetime', description ='$description' WHERE event_id = $event_id";

        if (mysqli_query($con, $query)) {
            $data = array(
                'status' => true,
                'msg' => 'Event updated successfully'
            );
        } else {
            $data = array(
                'status' => false,
                'msg' => 'Error updating event: ' . mysqli_error($con),
                'query' => $query // Debug: Add the actual query to the response
            );
        }
    } else {
        $data = array(
            'status' => false,
            'msg' => 'Missing required fields'
        );
    }
} else {
    $data = array(
        'status' => false,
        'msg' => 'Invalid request method'
    );
}

echo json_encode($data);
