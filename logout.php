<?php
session_start();
require_once 'includes/logger.php';

// Log the logout action
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $userName = $_SESSION['user_name'];
    logAction("User logged out. ID: $userId, Name: $userName");
}

// Clear session and redirect
session_unset();
session_destroy();
header("Location: auth/login.php");
exit;
?>
