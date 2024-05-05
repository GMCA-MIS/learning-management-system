<?php
include('dbcon.php');
$jsonarray = array();

if (isset($_GET['allincome'])) {

    $querydept = "SELECT SUM(payment_amount) as totalincome , YEAR(payment_date) as labyear , MONTHNAME (payment_date) as labmonth FROM student_payment WHERE status='Paid' GROUP BY YEAR(payment_date) , MONTH(payment_date) ";
    
    $query_rundept = mysqli_query($conn, $querydept);

    if (mysqli_num_rows($query_rundept) > 0) {
        while ($row = mysqli_fetch_assoc($query_rundept)) {

            array_push($jsonarray, array( 
                "year" => $row['labyear'] . ' - ' . $row['labmonth'], 
                "count" => $row['totalincome'] ));
        }
        echo json_encode($jsonarray);
    }

} 