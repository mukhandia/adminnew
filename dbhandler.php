<?php
require_once 'includes/dbconnection.php';

function insertUser($name, $email, $password, $role) {
    global $conn;

    // Sanitize input data
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);
    $role = $conn->real_escape_string($role);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query
    $sql = "INSERT INTO user_table (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', '$role')";

    // Execute the query and check for success
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return "Error: " . $conn->error;
    }
}
?>
