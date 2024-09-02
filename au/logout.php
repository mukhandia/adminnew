<?php
session_start();
require_once 'includes/logger.php'; 


if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $userName = $_SESSION['user_name'];
    
    if (!logAction("User logged out. ID: $userId, Name: $userName")) {
        error_log("Failed to log logout action for user ID: $userId"); 
    }
}
session_unset();
session_destroy();
header("Location: auth/login.php");
exit;
?>
