<?php
include('dbcon.php');


if($_POST['content'] == "mission"){

    $query = "SELECT * FROM content  where title = 'Mission'";
    $query_run = mysqli_query($conn, $query);
    $missions = array();

    if (mysqli_num_rows($query_run) > 0) {
        while ($row = mysqli_fetch_assoc($query_run)) {
           echo $row['content'];
        }
    }

    
}elseif($_POST['content'] == "vision"){

    $query = "SELECT * FROM content  where title = 'Vision'";
    $query_run = mysqli_query($conn, $query);
    $missions = array();

    if (mysqli_num_rows($query_run) > 0) {
        while ($row = mysqli_fetch_assoc($query_run)) {
           echo $row['content'];
        }
    }
}elseif($_POST['content'] == "upcomingevent"){
    $query = "SELECT * FROM content  where title = 'Upcoming Events'";
    $query_run = mysqli_query($conn, $query);
    $missions = array();

    if (mysqli_num_rows($query_run) > 0) {
        while ($row = mysqli_fetch_assoc($query_run)) {
           echo $row['content'];
        }
    }
}elseif($_POST['content'] == "announcement"){

    $query = "SELECT * FROM content  where title = 'Announcements'";
    $query_run = mysqli_query($conn, $query);
    $missions = array();

    if (mysqli_num_rows($query_run) > 0) {
        while ($row = mysqli_fetch_assoc($query_run)) {
           echo $row['content'];
        }
    }
}