<?php
require '../includes/dbconnection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate the token
    $sql = "SELECT * FROM password_resets WHERE token = ? AND expires > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $reset = $result->fetch_assoc();
        $user_id = $reset['user_id'];

        // Validate password and confirm password match
        if ($password === $confirm_password) {
            // Hash the new password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Update the user's password
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $hashed_password, $user_id);
            $stmt->execute();

            // Delete the reset token
            $sql = "DELETE FROM password_resets WHERE token = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $token);
            $stmt->execute();

            echo 'Password has been reset. You can now <a href="auth/login.php">login</a>';
        } else {
            die('Passwords do not match');
        }
    } else {
        die('Invalid or expired token');
    }
} else {
    die('Invalid request method');
}
?>
