<?php
    $conn = new mysqli('localhost', 'root', '', 'capstone');
    if($conn -> connect_error){
        die('No Database Established:' .$conn->connect_error);
    }
?>