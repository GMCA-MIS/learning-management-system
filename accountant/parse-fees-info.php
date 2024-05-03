<?php


include('dbcon.php');

if(isset($_GET['ccid']))
{
   $ccid = $_GET['ccid'];

        $querydept = "SELECT *   FROM  charge_types where chargetype_id  = $ccid";
        $query_rundept = mysqli_query($conn, $querydept);

        if (mysqli_num_rows($query_rundept) > 0) {
            while ($row = mysqli_fetch_assoc($query_rundept)) {
                            
                    $data["title"] = $row["title"];
                    $data["purpose"] = $row["purpose"];
                    $data["amount"] = $row["amount"];
            }
        }

    echo json_encode($data);
    

}