<?php
include('dbcon.php');

if (isset($_GET['specific_strand_population'])) {


    $specific_strand_population  = $_GET['specific_strand_population'];
    $jsonarray = array();

    $querydept = "SELECT COUNT(*) as countstudent , YEAR(enrollment_date) as yearlabel FROM student WHERE strand_id = $specific_strand_population GROUP BY strand_id , YEAR(enrollment_date)";
    $query_rundept = mysqli_query($conn, $querydept);

            if (mysqli_num_rows($query_rundept) > 0) {
                while ($row = mysqli_fetch_assoc($query_rundept)) {

                    array_push($jsonarray, array( 
                        "year" => $row['yearlabel'], 
                        "count" => $row['countstudent'] ));
                }
                echo json_encode($jsonarray);
            }

}
