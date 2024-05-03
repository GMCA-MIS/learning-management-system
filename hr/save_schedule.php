

<?php
include ('includes/header.php');
require_once('dbcon.php');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<script> alert('Error: No data to save.'); location.replace('./') </script>";
    $conn->close();
    exit;
}

extract($_POST);
$allday = isset($allday);

if (empty($id)) {
    $sql = "INSERT INTO `schedule_list` (`title`,`description`,`start_datetime`,`end_datetime`, `teacher_class_id`) VALUES ('$title','$description','$start_datetime','$end_datetime','')";
} else {
    $sql = "UPDATE `schedule_list` set `title` = '{$title}', `description` = '{$description}', `start_datetime` = '{$start_datetime}', `end_datetime` = '{$end_datetime}' where `id` = '{$id}'";
}

$save = $conn->query($sql);

if ($save) {
    echo "<script>
    Swal.fire({
        icon: 'success',
        title: 'Schedule Successfully Updated!',
        showConfirmButton: true,
        confirmButtonText: 'OK',
        allowOutsideClick: false,
        timer: 1500
    }).then(() => {
        window.location.replace('calendar.php');
    });
</script>";


} else {
    echo "<pre>";
    echo "An Error occurred.<br>";
    echo "Error: " . $conn->error . "<br>";
    echo "SQL: " . $sql . "<br>";
    echo "</pre>";
}

$conn->close();
?>
