<?php


if(isset($_GET['addstudent'])){



    
    $teacher_id = $_SESSION['teacher_id'];
    $student_id1 = $_GET['studentid'];
    $teacher_class_id =  $_GET['id'];    
    $idclaz =  $_GET['classid'];
    $subjid =  $_GET['subjid'];



    

    
   $sql= "INSERT INTO teacher_class_student (teacher_class_id, student_id, teacher_id) VALUES ('$teacher_class_id', '$student_id1', $teacher_id)";
    if ($conn->query($sql) === TRUE) {

    }    
    $sql= "INSERT INTO student_class (class_id, student_id, `status`) VALUES ('$idclaz', '$student_id1', 1)";
   

    if ($conn->query($sql) === TRUE) {

        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

        echo "<script>Swal.fire({
            title: 'success',
            text: 'Successfully added the Student!',
            icon: 'Success',
        }).then(function() {

            window.location.ref = 'class_members.php?id=$teacher_class_id&subjid=$subjid&classid=$idclaz';
            
        });</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


 
}

?>