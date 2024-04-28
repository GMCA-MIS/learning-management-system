<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/newheader.css">
</head>

<body>

<?php
    //PROMOTE / MOVE to GRADE 12
    if (isset($_GET['add_class'])) //Button Name
    {   
        include('dbcon.php');

        //declare parameters
        echo $class_id = $_GET['class_id'];
        $student_id = "";
        $class_name  = "";
        $strand = "";
        $success_notif = "";

        // get active school year
        $query = "SELECT school_year_id FROM school_year WHERE status = 1";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) != 0) {
            while ($rowsclass = mysqli_fetch_array($result)) {
                $school_year_id = $rowsclass['school_year_id'];
            }
        }

        // get student information and class info
        $query = "SELECT s.student_id,s.class_id,s.grade_level,c.class_name,c.strand 
                    FROM student s 
                    INNER JOIN class c 
                    ON s.class_id = c.class_id 
                    WHERE s.class_id = $class_id ";
        $resultz = mysqli_query($conn, $query);
        if (mysqli_num_rows($resultz) != 0)
        {
            while ($rowstudent = mysqli_fetch_array($resultz)) {
                $student_id = $rowstudent['student_id'];
                $class_id = $rowstudent['class_id'];
                $grade_level = $rowstudent['grade_level'];
                $class_name = $rowstudent['class_name'];
                $strand = $rowstudent['strand'];

                
                    // divide the section
                    $classname_exploded = explode("-",$class_name);
                    $class_shortname = $classname_exploded[0];
                    $class_grade = $classname_exploded[1];
                    $class_section = $classname_exploded[2];

                    // check if student section is still grade 11
                    if($class_grade == "11" ){
                        $query = "SELECT class_id FROM class WHERE class_name = '$class_shortname-12-$class_section' ";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result) != 0) {
                            // found existing class
                            while ($rowsclass12 = mysqli_fetch_array($result)) {
                            
                                 $class_id12 = $rowsclass12['class_id'];

                                // Check if the class_id exists in teacher_class table
                                $check_class_query = "SELECT teacher_class_id, teacher_id FROM teacher_class WHERE class_id = '$class_id12'";
                                $result = mysqli_query($conn, $check_class_query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    // If the class_id exists in teacher_class table
                                    $row = mysqli_fetch_assoc($result);
                                    $teacher_class_id = $row['teacher_class_id'];
                                    $teacher_id = $row['teacher_id'];

                                    // Insert data into teacher_class_student table
                                    $insert_student_class_query = "INSERT INTO teacher_class_student (teacher_class_id, student_id, teacher_id)   VALUES ('$teacher_class_id', '$student_id', '$teacher_id')";
                                    $insert_student_class_result = mysqli_query($conn, $insert_student_class_query);
                                }
                                // insert student to class
                                $queryaw1 = "INSERT student_class SET student_id='$student_id', class_id ='$class_id12'";
                                mysqli_query($conn, $queryaw1);
                                // insert student
                                $queryaw = "UPDATE student SET class_id = '$class_id12' , grade_level = '12' WHERE student_id='$student_id' ";
                                if(mysqli_query($conn, $queryaw)){
                                     $success_notif = "exist_class_insert_student_only";
                                }

                            }
                        }else{ 
                            // no existing class NEED TO generate new class
                            $query = "INSERT INTO  class (class_name,strand,school_year_id,status) VALUES('$class_shortname-12-$class_section','$strand',$school_year_id,1) ";
                            $result = mysqli_query($conn, $query);
                            $class_id12 = $conn->insert_id;

                            $queryaw1 = "INSERT student_class SET student_id='$student_id', class_id ='$class_id12'";
                            mysqli_query($conn, $queryaw1);
                                
                            $queryaw = "UPDATE student SET class_id ='$class_id12' WHERE student_id='$student_id'";
                            if(mysqli_query($conn, $queryaw)){

                                 $success_notif = "generate_class_insert_student_only";

                                
                            }

                            

                        }
                    }
                    // END
                   
            }
            

            
            if($success_notif == "exist_class_insert_student_only"){
                echo '<script>Swal.fire({
                    title: "Success",
                    text: "Student has been promoted successfully!",
                    icon: "success",
                    confirmButtonText: "OK",
                    timer: 3000,
                    allowOutsideClick: false
                }).then(function() {
                    window.location.href = "manage-class.php?class_name="'.$strand.';
                });</script>';
            }elseif($success_notif=="generate_class_insert_student_only"){
                echo '<script>
                                
                    Swal.fire({
                        title: "Success",
                        text: "Student has been promoted successfully!",
                        icon: "success",
                        confirmButtonText: "OK",
                        timer: 3000,
                        allowOutsideClick: false
                    }).then(function() {
                        Swal.fire({
                            title: "Warning",
                            text: "New Class is generated, Please assigned Teachers!",
                            icon: "warning",
                            confirmButtonText: "OK",
                            timer: 3000,
                            allowOutsideClick: false
                        }).then(function() {
                            window.location.href = "manage-class.php?class_name="'.$strand.';
                        });

                    });
                    
                    </script>';
            }else{
                echo '<script>Swal.fire({
                    title: "error",
                    text: "Something went wrong!",
                    icon: "error",
                    confirmButtonText: "OK",
                    timer: 3000,
                    allowOutsideClick: false
                }).then(function() {
                    window.location.href = "manage-class.php?class_name="'.$strand.';
                });</script>';
            }
        }
        
        
        
        


        //$query = "UPDATE student SET username='$lrn', firstname='$firstname', lastname='$lastname', email='$email', class_id='$class_id', dob ='$dob' WHERE student_id='$id'  ";
       // $query_run = mysqli_query($conn, $query);
        /*
        if ($query_run) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Success",
                text: "User has been updated successfully!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "manage-students.php";
            });</script>';
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo '<script>Swal.fire({
                title: "Error",
                text: "Failed to update user!",
                icon: "error",
                confirmButtonText: "OK"
            });</script>';
        } */
    }
    ?>
</body>

</html>