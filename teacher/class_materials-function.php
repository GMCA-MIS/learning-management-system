<?php 
include('teacher_session.php');
?>
<?php
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
include('dbcon.php');
include('initialize.php');
?>



<?php
if (isset($_POST['upload_material'])) {
    require("opener_db.php");

    // Generate a unique identifier
    $unique_id = uniqid();

    $get_id = $_POST['get_id'];
    $name = $_POST['name'];
    $filedesc = $_POST['desc'];
    $post_id = $_POST['post_id'];
    $uploaded_by = $teacher_id;

    $fileLocations = [];
    $atLeastOneFileUploaded = false;

    $uploadDirectory = "../uploads/";

    if (!empty($_FILES['uploaded_files']['name'][0])) {
        foreach ($_FILES['uploaded_files']['name'] as $key => $value) {
            // Append the unique identifier to the filename
            $filename = $unique_id . '_' . basename($_FILES['uploaded_files']['name'][$key]);
            $newname = $uploadDirectory . $filename;

            if (move_uploaded_file($_FILES['uploaded_files']['tmp_name'][$key], $newname)) {
                $fileLocations[] = $newname;
                $atLeastOneFileUploaded = true;
            } else {
                // Handle file upload errors
                echo "File upload failed for: " . $filename . "<br>";
            }
        }
    }

    if (!$atLeastOneFileUploaded) {
        $fileLocations[] = ''; // Or any suitable value
    }

    // Convert the file locations to JSON format
    $fileLocationsJson = json_encode($fileLocations);

    // Use prepared statements to prevent SQL injection
    $qry = "INSERT INTO files (floc, fdatein, fdesc, teacher_id, fname, teacher_class_id, uploaded_by) VALUES (?, NOW(), ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $qry);
    mysqli_stmt_bind_param($stmt, "ssssss", $fileLocationsJson, $filedesc, $teacher_id, $name, $get_id, $uploaded_by);

    if (mysqli_stmt_execute($stmt)) {
        // Insertion successful
        echo'<script>
        Swal.fire({
            title: "Files uploaded successfully!",
            icon: "success",
            confirmButtonColor: "rgba(23, 24, 32, 0.95)",
            showCancelButton: false,
            allowOutsideClick: false,
        }).then(() => {
            window.location.href = "class_materials.php?id=' . $get_id . '";
        });
    </script>';
    } else {
        // Insertion failed
        echo "Error: " . mysqli_error($conn); // Display the specific error message
    }

    mysqli_stmt_close($stmt);
}
?>



<?php
if (isset($_POST['editMaterial'])) {
    require("opener_db.php");

    // Assuming you have already started the session
    // Get the teacher ID from the session
    $teacher_id = $_SESSION['teacher_id'];

    $get_id = $_POST['get_id']; // Assuming this is the class ID
    $name = $_POST['editName'];
    $filedesc = $_POST['editDescription'];
    $post_id = $_POST['editId'];
    $uploaded_by = $teacher_id;

    $uploadDirectory = "../uploads/";

    // Retrieve current file locations from the database
    $getCurrentFileLocationsQuery = "SELECT floc FROM files WHERE file_id = ?";
    $getCurrentFileLocationsStmt = mysqli_prepare($conn, $getCurrentFileLocationsQuery);
    mysqli_stmt_bind_param($getCurrentFileLocationsStmt, "i", $post_id);
    mysqli_stmt_execute($getCurrentFileLocationsStmt);
    mysqli_stmt_bind_result($getCurrentFileLocationsStmt, $currentFileLocations);
    mysqli_stmt_fetch($getCurrentFileLocationsStmt);
    mysqli_stmt_close($getCurrentFileLocationsStmt);

    // Decode the current file locations
    $currentFileLocationsArray = json_decode($currentFileLocations, true);

    // Delete old files
    foreach ($currentFileLocationsArray as $oldFile) {
        unlink($oldFile); // Delete the file from the server
    }

    // Upload new files with a unique identifier
    $fileLocations = [];
    if (!empty($_FILES['editUploadedFiles']['name'][0])) {
        $unique_id = uniqid(); // Generate a unique identifier
        foreach ($_FILES['editUploadedFiles']['name'] as $key => $value) {
            $filename = $unique_id . '_' . basename($_FILES['editUploadedFiles']['name'][$key]);
            $newname = $uploadDirectory . $filename;

            if (move_uploaded_file($_FILES['editUploadedFiles']['tmp_name'][$key], $newname)) {
                $fileLocations[] = $newname;
            } else {
                // Handle file upload errors
                echo "File upload failed for: " . $filename . "<br>";
            }
        }
    }

    // Convert the file locations to JSON format
    $fileLocationsJson = json_encode($fileLocations);

    // Use prepared statements to prevent SQL injection
    $updateFilesQuery = "UPDATE files SET floc = ?, fdatein = NOW(), fdesc = ?, teacher_id = ?, fname = ?, teacher_class_id = ?, uploaded_by = ? WHERE file_id = ?";
    $updateFilesStmt = mysqli_prepare($conn, $updateFilesQuery);
    mysqli_stmt_bind_param($updateFilesStmt, "ssdsssi", $fileLocationsJson, $filedesc, $teacher_id, $name, $get_id, $uploaded_by, $post_id);

    if (mysqli_stmt_execute($updateFilesStmt)) {
        // Update successful
        echo'<script>
        Swal.fire({
            title: "Files edited successfully!",
            icon: "success",
            confirmButtonColor: "rgba(23, 24, 32, 0.95)",
            showCancelButton: false,
            allowOutsideClick: false,
        }).then(() => {
            window.location.href = "class_materials.php?id=' . $get_id . '";
        });
    </script>';
    } else {
        // Update failed
    }

    mysqli_stmt_close($updateFilesStmt);
}
?>


<?php
if (isset($_POST['file_id'])) {
    require("opener_db.php");

    $file_id = $_POST['file_id'];
    $get_id = $_POST['get_id'];

    // Use prepared statement to prevent SQL injection
    $deleteFileQuery = "DELETE FROM files WHERE file_id = ?";
    $deleteFileStmt = mysqli_prepare($conn, $deleteFileQuery);
    mysqli_stmt_bind_param($deleteFileStmt, "i", $file_id);

    // Execute the delete query
    if (mysqli_stmt_execute($deleteFileStmt)) {
        // Deletion successful
        echo'<script>
        Swal.fire({
            title: "Files removed successfully!",
            icon: "success",
            confirmButtonColor: "rgba(23, 24, 32, 0.95)",
            showCancelButton: false,
            allowOutsideClick: false,
        }).then(() => {
            window.location.href = "class_materials.php?id=' . $get_id . '";
        });
    </script>';
    } else {
        // Deletion failed
        echo "Error: " . mysqli_error($conn); // Display the specific error message
    }

    mysqli_stmt_close($deleteFileStmt);
}
?>
 