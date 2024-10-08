<?php
require 'vendor/autoload.php'; // Ensure Composer's autoload is included
require 'includes/dbconnection.php'; // Ensure your database connection is included

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Process the form when submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate that the passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check if the token exists and is valid
        $query = "SELECT email FROM password_resets WHERE token = ? AND expiry_time > NOW()";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $email = $row['email'];

            // Update the user's password
            $update_query = "UPDATE users SET password = ? WHERE email = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param('ss', $hashed_password, $email);
            $update_stmt->execute();

            // Optionally delete the token from the database
            $delete_query = "DELETE FROM password_resets WHERE token = ?";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bind_param('s', $token);
            $delete_stmt->execute();

            // Redirect to login or success page
            header("Location: auth/login.php?reset_success=1");
            exit();
        } else {
            $error = "Invalid or expired token.";
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
    <div class="accountbg"></div>
    <div class="wrapper-page">
        <div class="card">
            <div class="card-body">
                <div class="text-center m-b-15">
                    <a href="index.html" class="logo logo-admin"><img src="assets/images/logo.png" height="24" alt="logo"></a>
                </div>
                <div class="p-3">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    <form class="form-horizontal" action="" method="POST">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
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
                                <button class="btn btn-danger btn-block waves-effect waves-light" type="submit">Reset Password</button>
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
