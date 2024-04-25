

<?php
include ('dbcon.php');
// Initialize $row to an empty array to avoid undefined variable error
$row = [];

// Assuming you have established a database connection already (e.g., $conn)

// Get the teacher_id from the session
$teacher_id = $_SESSION['teacher_id'];

// Use prepared statements to fetch teacher information
$stmt = $conn->prepare("SELECT * FROM teacher WHERE teacher_id = ?");
$stmt->bind_param("s", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the teacher's data
    $row = $result->fetch_assoc();
} else {
    // Handle the case where the teacher's record is not found
    // You can set a default message or redirect to an error page here
}

$stmt->close();
?>

