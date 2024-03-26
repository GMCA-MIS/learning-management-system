<?php
include("dbcon.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['student_id'])) {
        $studentId = $_POST['student_id'];

        $query = "SELECT `id`, `description`, `filename` FROM `attachment` WHERE `student_id` = '$studentId'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                echo '<table>';
                echo '<tr><th>Description</th><th></th><th>Filename</th></tr>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td width="30%">' . $row['description'] . '</td>';
                    echo '<td width="10%"></td>';
                    echo '<td width="50%"><a href="../attachment/' . $row['filename'] . '" target="_blank">' . $row['filename'] . '</a></td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo 'No attachments available.';
            }
        } else {
            echo "Error retrieving attachments: " . mysqli_error($conn);
        }
    } else {
        echo "Student ID not provided.";
    }
}
?>
