<?php
include("dbcon.php");

?>

<?php
$admin_user = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id'") or die(mysqli_error());

while ($row = mysqli_fetch_array($admin_user)) {
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $location = $row['location'];

}
?>                      
                      
                      
                      <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Welcome, <?php echo $firstname . ' ' . $lastname; ?></span>
                                <img class="img-profile rounded-circle" src="<?php echo $location ?>">
                            </a>

                            <!-- Dropdown menu -->
                            <div class="dropdown-menu" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="admin_profile.php"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
                                <a class="dropdown-item" href="change_password.php"> <i class="fa fa-lock" aria-hidden="true"></i> Change Password</a>
                            </div>
                        </li>