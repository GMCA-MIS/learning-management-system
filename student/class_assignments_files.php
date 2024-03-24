<?php
// Include database connection details
require("opener_db.php");

$conn = $connector->DbConnector();

// Function to retrieve file locations for a specific assignment
function getAssignmentFileLocations($assignmentId, $conn) {
    $query = "SELECT floc FROM assignment WHERE assignment_id = $assignmentId";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row && isset($row['floc'])) {
            return json_decode($row['floc'], true);
        }
    }

    return [];
}

// Assuming you have the assignment ID, replace with the actual assignment ID
$assignmentId = 106; 

$fileLocations = getAssignmentFileLocations($assignmentId, $conn);

if ($fileLocations) {
    // Files were found and retrieved
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Assignment Files</title>
    </head>
    <body>
        <h1>Assignment Files</h1>
        <?php foreach ($fileLocations as $fileLocation): ?>
            <div>
                File: <a href="<?php echo $fileLocation; ?>" download>Download File</a>
            </div>
        <?php endforeach; ?>
    </body>
    </html>
    <?php
} else {
    // No files found or error occurred
    echo "No files found for this assignment.";
}
?>
