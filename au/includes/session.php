<?php
session_start();
include "includes/dbconnection.php";
include "includes/logger.php";
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: auth/login.php"); // Assuming your login page is at auth/login.php
    exit; // Terminate the script after redirection
}

// If the user is logged in, you can access their ID like this:
$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];
?>