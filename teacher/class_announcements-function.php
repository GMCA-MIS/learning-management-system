<?php 
include('teacher_session.php');  ?>

<?php
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
include('dbcon.php');
include('initialize.php');
?>
             
     <?php
if (isset($_POST['add_announcement'])) {
    // Ensure you have a database connection established

    // Sanitize and validate the input
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    // Get the teacher_id from a session variable, assuming you have it stored
    $teacher_id = $_SESSION['teacher_id'];

    // Get the teacher_class_id from the URL parameter
    $teacher_class_id = $_GET['id'];

    // Define the directory to store uploads
    $upload_dir = '../uploads/'; // You should create this directory if it doesn't exist

    $attachment_paths = []; // Array to store attachment paths

    // Check if files were uploaded
    if (isset($_FILES['attachment'])) {
        // Iterate through the uploaded files
        foreach ($_FILES['attachment']['tmp_name'] as $key => $tmp_name) {
            $filename = $_FILES['attachment']['name'][$key];
            $filetmp = $_FILES['attachment']['tmp_name'][$key];

            // Check if the file is not empty
            if (!empty($filename)) {
                $fileext = pathinfo($filename, PATHINFO_EXTENSION);

                // Generate a unique filename
                $attachment_path = $upload_dir . uniqid('', true) . '.' . $fileext;

                // Check if the uploaded file is an image
                $is_image = getimagesize($filetmp);

                if ($is_image) {
                    // Move the uploaded image to the directory
                    move_uploaded_file($filetmp, $attachment_path);

                    // Add the attachment path to the array
                    $attachment_paths[] = $attachment_path;
                }
            }
        }
    }

    // Insert the announcement with the attachment paths into the teacher_class_announcements table
    $attachment_paths_str = !empty($attachment_paths) ? "'" . implode("','", $attachment_paths) . "'" : 'NULL';
    $insert_announcement_query = "INSERT INTO teacher_class_announcements (teacher_class_id, teacher_id, content, date, attachment_path) VALUES ('$teacher_class_id', '$teacher_id', '$content', NOW(), $attachment_paths_str)";
    
    if (mysqli_query($conn, $insert_announcement_query)) {
        // Insertion into teacher_class_announcements was successful
        $link = "class_announcements.php?id=".$teacher_class_id;
        // Insert a notification, assuming you have a notifications table
        $notification_query = "INSERT INTO notification (teacher_class_id, notification, date_of_notification, link) VALUES ('$teacher_class_id', 'Add Announcements', NOW(), '$link')";

        if (mysqli_query($conn, $notification_query)) {
            // Notification insertion was successful
            echo '<script>
                Swal.fire({
                    title: "Announcement added successfully!",
                    icon: "success",
                    confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                }).then(() => {
                    window.location.href = "class_announcements.php?id=' . $teacher_class_id . '";
                });
            </script>';
        } else {
            echo "Error inserting notification: " . mysqli_error($conn);
        }
    } else {
        echo "Error inserting announcement: " . mysqli_error($conn);
    }
}
?>




    <!-- edit Announcement-->

    <?php
if (isset($_POST['edit_announcement'])) {
    // Ensure you have a database connection established

    // Sanitize and validate the input
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $teacher_class_announcements_id = $_POST['teacher_class_announcements_id'];
    $get_id = $_GET['teacher_class_id'];
    $modalID = "edit_announcementModal_$teacher_class_announcements_id";

    // Get the teacher_id from a session variable, assuming you have it stored
    $teacher_id = $_SESSION['teacher_id'];

    // Initialize an array to store attachment paths
    $attachment_paths = [];

    // Handle file uploads
    if (isset($_FILES['attachment']) && count($_FILES['attachment']['name']) > 0) {
        $uploadDir = "../uploads/"; // Update with your directory path

        for ($i = 0; $i < count($_FILES['attachment']['name']); $i++) {
            $uploadedFile = $uploadDir . basename($_FILES['attachment']['name'][$i]);

            // Check if the uploaded file is an image
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['attachment']['type'][$i], $allowedTypes)) {
                if (move_uploaded_file($_FILES['attachment']['tmp_name'][$i], $uploadedFile)) {
                    $attachment_paths[] = $uploadedFile;
                }
            }
        }
    }

    // Convert the array of attachment paths to a string
    $attachment_path_str = implode(', ', $attachment_paths);

    // Update the announcement in the teacher_class_announcements table, including the attachment paths
    $update_announcement_query = "UPDATE teacher_class_announcements SET content = '$content', attachment_path = '$attachment_path_str' WHERE teacher_class_announcements_id = $teacher_class_announcements_id";

    if (mysqli_query($conn, $update_announcement_query)) {
        // Success: Display SweetAlert and then redirect
        echo '<script>
            Swal.fire({
                title: "Announcement Updated",
                icon: "success",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "class_announcements.php?id=' . $get_id . '";
            });
        </script>';
    } else {
        // Error: Display SweetAlert with a window location for error
        echo '<script>
            Swal.fire({
                title: "Error updating announcement",
                text: "An error occurred while updating the announcement.",
                icon: "error",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "class_announcements.php?id=' . $get_id . '";
            });
        </script>';
    }
}
?>


<!-- Delete Announcement !--> 

<?php
if (isset($_POST['delete_announcement'])) {
    // Ensure you have a database connection established

    // Sanitize and validate the input
    $teacher_class_announcements_id = mysqli_real_escape_string($conn, $_POST['teacher_class_announcements_id']);
    $get_id = $_GET['teacher_class_id'];
    // You can add additional validation here to ensure the announcement belongs to the logged-in teacher or has the appropriate permissions before deleting it.

    // Perform the delete operation
    $delete_announcement_query = "DELETE FROM teacher_class_announcements WHERE teacher_class_announcements_id = '$teacher_class_announcements_id'";

    if (mysqli_query($conn, $delete_announcement_query)) {
        // Deletion was successful
        echo '<script>
            Swal.fire({
                title: "Announcement deleted successfully!",
                icon: "success",
                confirmButtonColor: "rgba(23, 24, 32, 0.95)",
            }).then(() => {
                window.location.href = "class_announcements.php?id=' . $get_id . '";
            });
        </script>';
    } else {
        echo "Error deleting announcement: " . mysqli_error($conn);
    }
} else {
    // Handle the case when the 'teacher_class_announcements_id' is not set in the POST data or any other error handling you need.
    // echo "Invalid request or missing data.";
}
?>
