<?php
include('dbcon.php');
if (isset($_GET['component_charge_id'])) {
    $component_charge_id  = $_GET['component_charge_id'];
    $totalfees = 0;
    $querydept = "SELECT *
    FROM  component_charge_fees cc INNER JOIN charge_types ct ON cc.chargetype_id = ct.chargetype_id
        WHERE cc.component_charge_id = $component_charge_id";
    $query_rundept = mysqli_query($conn, $querydept);

    echo "<table>";
        echo "<tr>";
            echo "<th style='padding-right:200px;'>ID</th>";   
            echo "<th style='padding-right:200px;'>Fees</th>";            
            echo "<th>Amounts</th>";
        echo "</tr>";
            if (mysqli_num_rows($query_rundept) > 0) {
                while ($rowdept = mysqli_fetch_assoc($query_rundept)) {
                    
                    echo "<tr>";
                    echo "<td>".$rowdept['chargetype_id']."</td>";
                    echo "<td>".$rowdept['title']."</td>";
                    echo "<td>".$rowdept['amount']."</td>";
                    echo "</tr>";
                    $totalfees = $totalfees + $rowdept['amount'];
                }
                echo "<tr style='border-top:1px solid gray'>";
                echo "<td></td>";
                echo "<td><b>Total Fees</b></td>";
                echo "<td>".$totalfees."</td>";
                echo "</tr>";
            }
    echo "</table>";
}
?>