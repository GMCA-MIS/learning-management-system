
<?php
// Include your database connection file here (e.g., dbcon.php)
include('../dbcon.php');

// Check if a user ID is provided in the URL (you may want to add more error handling)
if (isset($_GET['student_id'])) {
    $user_id = $_GET['student_id'];

    // Query to retrieve user data
    $query = "SELECT * FROM student WHERE student_id = $user_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Fetch user data
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $dob = $row['dob'];
            $photo = $row['location'];
            $email = $row['email'];
            $lrn = $row['username'];
            $class_id = $row['class_id'];


        } else {
            echo "User not found.";
        }
    } else {
        echo "Error fetching user data: " . mysqli_error($conn);
    }
} else {
    echo "User ID not provided.";
}

// Close the database connection
mysqli_close($conn);
?>

<!--Website: wwww.codingdung.com-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodingDung | Profile Template</title>
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
            Student Information
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links" style = "border-bottom: 1px gray solid;">
                        <div class="card-body media align-items-center" style = "border-bottom: 1px gray solid;">
                            <img src="../img/Admin-Profile-PNG-Isolated-Pic.png" alt="" class="d-block mx-auto" style="width: 150px;">
                        </div>
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General Infromation</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Classes</a>
                        </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label"><?php  echo "<p><strong>First Name:</strong> $firstname "." $lastname</p>";?></label>
                                </div>
                                <div class="form-group">
                                    <label class="form-label"><?php  echo "<p><strong>LRN:</strong> $lrn</p>";?></label>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><?php  echo "<p><strong>Email Address:</strong> $email</p>";?></label>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><?php  echo "<p><strong>Date of Birth:</strong> $dob</p>";?></label>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <h4> Classes </h4>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><?php  echo "<p><strong>Class Enrolled:</strong> STEM 11-A</p>";?></label>
                                </div>

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>