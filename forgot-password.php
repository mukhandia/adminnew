<?php
include_once'includes/dbconnection.php';
require 'vendor/autoload.php';  // Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Generate a random 6-digit reset code
    $reset_code = rand(100000, 999999);

    // Set an expiry time for the code (e.g., 1 hour from now)
    $expiry_time = time() + 3600; // 1 hour

   
    $query = "INSERT INTO password_resets (email, reset_code, expiry_time)
              VALUES ('$email', '$reset_code', '$expiry_time')
              ON DUPLICATE KEY UPDATE reset_code='$reset_code', expiry_time='$expiry_time'";
    mysqli_query($conn, $query);
 
    // Initialize PHPMailer and configure SMTP
    $mail = new PHPMailer(true);
    try {
        // SMTP server settings
        $mail->isSMTP();                                           // Send using SMTP
        $mail->Host       = 'mail.afripixelsolutions.com';         // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                  // Enable SMTP authentication
        $mail->Username   = 'system@afripixelsolutions.com';       // SMTP username
        $mail->Password   = 'mUyM,aSHw*mk';                        // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        // Enable TLS encryption
        $mail->Port       = 587;                                   // TCP port to connect to

        // Recipients
        $mail->setFrom('system@afripixelsolutions.com', 'Afripixel Solutions');
        $mail->addAddress($email);  // Add recipient's email

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Password Reset Code';
        $mail->Body    = "Your password reset code is: <b>$reset_code</b><br>This code will expire in 1 hour.";

        // Send the email
        $mail->send();
        
        // Redirect to the confirmation page
        header("Location: confirm_code.php?email=" . urlencode($email));
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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


    <!-- Begin page -->
    <div class="wrapper-page">
        <div class="card">
            <div class="card-body">
                <div class="text-center m-b-15">
                    <a style="color:#0000CB" href="/adminnew" class="logo logo-admin">
                        <img src="assets/images/logo.png" height="24" alt="logo">AFRIPIXEL
                    </a>
                </div>

                <div class="p-3">
                    <form class="form-horizontal" action="" method="POST">
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            Enter your <b>Email</b> and instructions will be sent to you!
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" name="email" type="email" required placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group text-center row m-t-20">
                            <div class="col-12">
                                <button class="btn btn-danger btn-block waves-effect waves-light" type="submit">Send Email</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery  -->
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

    <!-- App js -->
    <script src="assets/js/app.js"></script>

</body>
</html>
