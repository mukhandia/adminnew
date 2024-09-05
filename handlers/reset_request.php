<?php
session_start();
require '../includes/dbconnection.php'; // Include your database connection file
require '../vendor/autoload.php'; // Include Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email address');
    }

    // Check if email exists in the database
    $sql = "SELECT id FROM user_table WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

        // Generate a unique token
        $token = bin2hex(random_bytes(16));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Store the token in the database
        $sql = "INSERT INTO password_resets (user_id, token, expires) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iss', $user_id, $token, $expires);
        $stmt->execute();

        // Send the reset email
        $reset_link = "https://192.168.1.133/adminnew/reset-password.php?token=$token";
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'mail.afripixelsolutions.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'system@afripixelsolutions.com';
            $mail->Password   = 'mUyM,aSHw*mk';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('fwasike@afripixelsolutions.com', 'Afrpixel');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Please click the following link to reset your password: <a href=\"$reset_link\">Reset Password</a>";
            $mail->AltBody = "Please copy and paste the following link to reset your password: $reset_link";

            $mail->send();
            echo 'Password reset email sent!';
        } catch (Exception $e) {
            die("Error sending email: {$mail->ErrorInfo}");
        }
    } else {
        die('Email not found');
    }
} else {
    die('Invalid request method');
}
?>
