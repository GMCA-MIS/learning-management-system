<?php

include('dbcon.php');

$classname = $_GET['classname'];
$gradelevel = $_GET['grade_level'];

$check_query_strand = "SELECT * FROM strand WHERE full_name_strand = '$classname'";
$check_result_strand = mysqli_query($conn, $check_query_strand);

if (mysqli_num_rows($check_result_strand) > 0) {
    
    // Fetch the result row
    $row_strand = mysqli_fetch_assoc($check_result_strand);
    $strand_name = $row_strand['name'];
    $strand_fname = $row_strand['full_name_strand'];


    // Check if there are any existing classes with less than 2 regular students
    $existing_classes_not_full = false;
    
    //get active school year 
    $check_query_school_year = "SELECT * FROM school_year where status = 1 ORDER BY school_year_id DESC LIMIT 1 ";
    $check_result_school_year = mysqli_query($conn,  $check_query_school_year);
    $row_school_year = mysqli_fetch_assoc($check_result_school_year);
    $current_school_year = $row_school_year['school_year_id'];
    
    //get classes with similar strand and grade
    $check_query_strand_student = "SELECT * FROM class WHERE strand = '$strand_fname' and school_year_id = '$current_school_year' and SUBSTRING_INDEX(SUBSTRING_INDEX(class_name, '-', 2), ' ', -1) = '$strand_name-$gradelevel'";
    $check_result_strand_student = mysqli_query($conn, $check_query_strand_student);
    

    // execute if one or many class exist
    if (mysqli_num_rows($check_result_strand_student) > 0) {
        /*
        while ($row_strand_student = mysqli_fetch_assoc($check_result_strand_student)) {
            $class_id = $row_strand_student['class_id'];

            $check_query_strand_student_st = "SELECT COUNT(*) as id FROM student WHERE class_id = '$class_id' AND is_regular = 1";
            $check_result_strand_student_st = mysqli_query($conn, $check_query_strand_student_st);

            if ($check_result_strand_student_st && mysqli_num_rows($check_result_strand_student_st) > 0) {
                $row_strand_sta = mysqli_fetch_assoc($check_result_strand_student_st);
                $counts_of_students = $row_strand_sta['id'];
                
                // check class if full
                if ($counts_of_students < 50) {

                    //set TRUE to indicate selected class not FULL
                    $existing_classes_not_full = true;
                }
                
            }                           
        }
        */
    } else {  // execute to create new class due to NO EXISTING CLASS

        $newsection = $strand_name . '-' . $gradelevel . '-A';
        $query_class_name = "INSERT INTO class (class_name,strand,school_year_id) VALUES ('$newsection','$strand_fname','$current_school_year')";
        mysqli_query($conn, $query_class_name);
        
        echo "New Class";
        die();
    }
    


    // execute IF all existing classes are FULL 
    if (!$existing_classes_not_full) {
        

        // get last row class inserted
        $check_query_strand_studentqwe = "SELECT * FROM class WHERE strand = '$strand_fname' AND SUBSTRING_INDEX(SUBSTRING_INDEX(class_name, '-', 2), ' ', -1) = '$strand_name-$gradelevel' ORDER BY class_id DESC LIMIT 1";
        $check_result_strand_studentqwe = mysqli_query($conn, $check_query_strand_studentqwe);

        if (mysqli_num_rows($check_result_strand_studentqwe) > 0) {

            $row_row = mysqli_fetch_assoc($check_result_strand_studentqwe);
            $class_name = $row_row['class_name'];

            // Extract the middle part of the class name
            $parts = explode('-', $class_name);
            $middle_part = $parts[1]; // Extract the middle part

            // Replace the middle part with the new grade level
            $new_class_name = $parts[0] . "-" . $gradelevel . "-" . $parts[2];

            // Increment the last character to get the next section
            $last_character = substr($new_class_name, -1); // Get the last character
            $next_section = chr(ord($last_character) + 1); // Increment the last character

            $class_nameu = substr($new_class_name, 0, -1) . $next_section;

            $query_class_name = "INSERT INTO class (class_name,strand,school_year_id) VALUES ('$class_nameu','$strand_fname','$current_school_year')";
            mysqli_query($conn, $query_class_name);

            echo "New Class";
            
        }


    }else{
        echo "Found a Class with below 50 students";
    }

}else{
    echo "strand does not exist";
}

?>