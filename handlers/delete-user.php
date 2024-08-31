<?php
session_start();
include "../includes/dbconnection.php";
include '../includes/logger.php';
// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    // Get the user ID from the URL
    $userId = $_GET['id'];
    // Prepare the SQL DELETE statement
    $sql = "DELETE FROM user_table WHERE id = ?";
    // Initialize a prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the user ID to the statement as an integer
        $stmt->bind_param("i", $userId);
        // Execute the statement
        if ($stmt->execute()) {
            
            // If successful, redirect to the users page with a success message
            $_SESSION['success_message'] = "User deleted successfully.";
        } else {
            // If an error occurred, redirect with an error message
            $_SESSION['error_message'] = "Error deleting user: " . $stmt->error;
        }
        // Close the statement
        $stmt->close();
    } else {
        // If the statement could not be prepared, show an error message
        $_SESSION['error_message'] = "Error preparing statement: " . $conn->error;
    }
} else {
    // If no ID is provided, redirect with an error message
    $_SESSION['error_message'] = "Invalid request. No user ID provided.";
}

// Close the database connection
$conn->close();

// Redirect back to the users page
header("Location: ../users.php");
exit();
?>
