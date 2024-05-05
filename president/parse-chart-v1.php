<?php
include('dbcon.php');
if (isset($_GET['strand'])) {
    $condition1 = "";
    $condition2 = "";
    $column = "";
    $condition3 = "";
    $groupby = "";

    if(!empty($_GET['range'])){
        if($_GET['range'] == "current-year"){
            $column = ", MONTHNAME(enrollment_date) as monthlabel";
            $condition3 = " AND YEAR(enrollment_date) = YEAR(NOW())"; 
            $groupby = " , MONTH(enrollment_date)";
        }
    }

    if(!empty($_GET['gender'])){
        $condition1 = $condition1 . " AND gender = '" . $_GET['gender'] ."'";
    }
    if(!empty($_GET['grade'])){
        $condition2 = "AND grade_level = '" . $_GET['grade'] ."'";
    }

    $strand  = $_GET['strand'];
    $jsonarray = array();

    if($_GET['strand'] == "ALL"){
        
        $querydept = "SELECT COUNT(*) as countstudent , YEAR(enrollment_date) as yearlabel , `name` $column  FROM student  s INNER JOIN strand sta ON s.strand_id = sta.id WHERE s.status=1 $condition1 $condition2 $condition3 GROUP BY strand_id , YEAR(enrollment_date) $groupby;";
    
    }else{
        
        $querydept = "SELECT COUNT(*) as countstudent , YEAR(enrollment_date) as yearlabel $column  FROM student s INNER JOIN strand sta ON s.strand_id = sta.id   WHERE s.strand_id = '$strand' AND s.status=1 $condition1 $condition2 $condition3 GROUP BY strand_id , YEAR(enrollment_date) $groupby;";
    
    }
    
    
    $query_rundept = mysqli_query($conn, $querydept);

    if (mysqli_num_rows($query_rundept) > 0) {
        while ($row = mysqli_fetch_assoc($query_rundept)) {

            if($_GET['strand'] == "ALL"){

                    if(!empty($_GET['range'])){
                        if($_GET['range'] == "current-year"){
                            array_push($jsonarray, array( 
                                "year" => $row['yearlabel'] . " - " . $row['name'] . $row['monthlabel'] , 
                                "count" => $row['countstudent'] ));
                        }else{
                            
                        array_push($jsonarray, array( 
                            "year" => $row['yearlabel'] . " - " . $row['name'] , 
                            "count" => $row['countstudent'] ));
                        }
                    }else{
                        array_push($jsonarray, array( 
                            "year" => $row['yearlabel'] . " - " . $row['name'] , 
                            "count" => $row['countstudent'] ));
                    }
                
            }else{
                if(!empty($_GET['range'])){
                    if($_GET['range'] == "current-year"){
                        array_push($jsonarray, array( 
                            "year" => $row['yearlabel'] . " - " . $row['monthlabel'] , 
                            "count" => $row['countstudent'] ));
                    }else{
                        
                    array_push($jsonarray, array( 
                        "year" => $row['yearlabel'], 
                        "count" => $row['countstudent'] ));
                    }
                }else{
                    array_push($jsonarray, array( 
                        "year" => $row['yearlabel'], 
                        "count" => $row['countstudent'] ));
                }
                
            }

        }
        echo json_encode($jsonarray);
    }

} 