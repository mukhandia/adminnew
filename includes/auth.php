<?php
session_start(); 

function checkUserAccess($allowedRoles) {
    if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], $allowedRoles)) {
         logAction("Unauthorized access attempt by user with ID {$_SESSION['user_id']}.");


        header("Location: ../403.php"); 
        exit;
    }
}
