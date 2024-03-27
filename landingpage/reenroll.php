<?php
include('dbcon.php');

if (isset($_POST['reenroll'])) {
    $id = $_POST['student_id'];
    $grade_level = $_POST['grade_level'];
    $semester = $_POST['semester'];

    // Update student table
    $student_query = "UPDATE student SET grade_level = '$grade_level', semester = '$semester' WHERE student_id = '$id'";
    $student_query_run = mysqli_query($conn, $student_query);

    if ($student_query_run) {
        echo "<div></div>";
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                Swal.fire({
                    title: 'Success',
                    text: 'Reenroll Successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.html';
                    }
                });
            </script>";
        exit();
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<script>Swal.fire({
            title: "Error",
            text: "Failed to rearchive user!",
            icon: "error",
            confirmButtonText: "OK"
        });</script>';
    }
}
?>