<?php
session_start();
require 'includes/dbconnection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user inputs
    $oldPassword = $_POST['oldpassword'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if user ID is set in the session
    if (!isset($_SESSION['user_id'])) {
        die('No user ID found in session. Please log in.');
    }

    $userId = $_SESSION['user_id'];

    // Validate passwords
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = "All fields are required.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "New password and confirm password do not match.";
    } else {
        // Fetch the current password from the database
        $sql = "SELECT password FROM user_table WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $currentPasswordHash = $user['password'];

            // Verify the old password
            if (!password_verify($oldPassword, $currentPasswordHash)) {
                $error = "The old password is incorrect.";
            } else {
                // Hash the new password
                $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);

                // Update the password in the database
                $updateSql = "UPDATE user_table SET password = ? WHERE id = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param('si', $newPasswordHash, $userId);

                if ($updateStmt->execute()) {
                    $success = "Password changed successfully!";
                    header('Location: auth/login.php?message=pasword uodated successfully');
                } else {
                    $error = "Error updating password.";
                }
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Reset Password</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body class="fixed-left">
    <div class="wrapper-page">
        <div class="card">
            <div class="card-body">
                <div class="text-center m-b-15">
                    <a href="./index.php" class="logo logo-admin"><img src="assets/images/logo.png" height="24" alt="logo">Afripixel</a>
                </div>
                <div class="p-3">

                    <!-- Display success or error message -->
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php elseif (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <!-- Password change form -->
                    <form class="form-horizontal" action="" method="POST">
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" type="password" name="oldpassword" required="" placeholder="Old Password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" type="password" name="password" required="" placeholder="New Password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" type="password" name="confirm_password" required="" placeholder="Re-enter Password">
                            </div>
                        </div>
                        <div class="form-group text-center row m-t-20">
                            <div class="col-12">
                                <button class="btn btn-danger btn-block waves-effect waves-light" type="submit">Change Password</button>
                            </div>
                        </div>
                        <div class="form-group m-t-10 mb-0 row">
                            <div class="col-12 m-t-20 text-center">
                                <a href="auth/login.php" class="text-muted">Login</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.nicescroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
