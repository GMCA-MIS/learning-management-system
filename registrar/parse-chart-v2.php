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

if (isset($_GET['strandspopulation'])) {

    $querydept = "SELECT COUNT(*) as countstudent , `name`  FROM student  s INNER JOIN strand sta ON s.strand_id = sta.id WHERE s.status=1  GROUP BY strand_id ;";
    
    $query_rundept = mysqli_query($conn, $querydept);

    if (mysqli_num_rows($query_rundept) > 0) {
        while ($row = mysqli_fetch_assoc($query_rundept)) {

            array_push($jsonarray, array( 
                "strand" => $row['name'], 
                "count" => $row['countstudent'] ));
        }
        echo json_encode($jsonarray);
    }

}
if (isset($_GET['inlisted'])) {

    $querydept = "SELECT COUNT(*) as countstudent , `name`  FROM student  s INNER JOIN strand sta ON s.strand_id = sta.id WHERE s.status=3  GROUP BY strand_id ;";
    
    $query_rundept = mysqli_query($conn, $querydept);

    if (mysqli_num_rows($query_rundept) > 0) {
        while ($row = mysqli_fetch_assoc($query_rundept)) {

            array_push($jsonarray, array( 
                "strand" => $row['name'], 
                "count" => $row['countstudent'] ));
        }
        echo json_encode($jsonarray);
    }

} 

if (isset($_GET['strand'])) {

    $condition = "";
    $strandid = $_GET['strand'];

    if(isset($_GET['range'])){
        $condition = " AND YEAR(payment_date) = YEAR(NOW()) ";
    }

    if($_GET['strand'] == "ALL"){
        $querydept = "SELECT SUM(payment_amount) as totalincome , YEAR(payment_date) as labyear , MONTHNAME (payment_date) as labmonth FROM student_payment sp INNER JOIN student st ON sp.student_id = st.student_id  
            WHERE sp.status='Paid' $condition GROUP BY YEAR(payment_date) , MONTH(payment_date) ";
    }elseif($_GET['strand'] != ""){

        $querydept = "SELECT SUM(payment_amount) as totalincome , YEAR(payment_date) as labyear , MONTHNAME (payment_date) as labmonth FROM student_payment sp INNER JOIN student st ON sp.student_id = st.student_id  
            WHERE sp.status='Paid' AND st.strand_id = $strandid $condition GROUP BY YEAR(payment_date) , MONTH(payment_date) ";
    }
    
    $query_rundept = mysqli_query($conn, $querydept);

    if (mysqli_num_rows($query_rundept) > 0) {
        while ($row = mysqli_fetch_assoc($query_rundept)) {

            array_push($jsonarray, array( 
                "year" => $row['labyear'] . " - " . $row['labmonth'], 
                "count" => $row['totalincome'] ));
        }
        echo json_encode($jsonarray);
    }

} 

