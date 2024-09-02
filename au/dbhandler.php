<?php
require_once 'includes/dbconnection.php';
require_once '../includes/logger.php';


function insertUser($conn, $name, $email, $password, $role) {
    $name = trim($name);
    $email = trim($email);
    $role = trim($role);

    // Check if email already exists
    $checkEmailSql = "SELECT id FROM user_table WHERE email = ?";
    if ($stmt = $conn->prepare($checkEmailSql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->close();
            logAction("Failed to insert user: Email already exists. Email: $email");
            return "Error: Email already exists.";
        }
        $stmt->close();
    } else {
        $error = "Error preparing email check statement: " . $conn->error;
        logAction($error);
        return $error;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query for inserting new user
    $insertSql = "INSERT INTO user_table (name, email, password, role) VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($insertSql)) {
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);
        if ($stmt->execute()) {
            $stmt->close();
            logAction("User inserted successfully. Name: $name, Email: $email, Role: $role");
            return true;
        } else {
            $stmt->close();
            $error = "Error: " . $stmt->error;
            logAction($error);
            return $error;
        }
    } else {
        $error = "Error preparing insert statement: " . $conn->error;
        logAction($error);
        return $error;
    }
}

function updateUser($id, $name, $email, $password, $role) {
    global $conn;

    $id = $conn->real_escape_string($id);
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);
    $role = $conn->real_escape_string($role);

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user_table SET name='$name', email='$email', password='$hashed_password', role='$role' WHERE id='$id'";
        $logMessage = "User updated with new password. ID: $id, Name: $name, Email: $email, Role: $role";
    } else {
        $sql = "UPDATE user_table SET name='$name', email='$email', role='$role' WHERE id='$id'";
        $logMessage = "User $name updated without changing password. ID: $id, Name: $name, Email: $email, Role: $role";
    }

    if ($conn->query($sql) === TRUE) {
        logAction($logMessage);
        return true;
    } else {
        $error = "Error: " . $conn->error;
        logAction($error);
        return $error;
    }
}
function getUserById($id) {
    global $conn;

    $id = $conn->real_escape_string($id);
    $sql = "SELECT * FROM user_table WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        logAction("Fetched user by ID. ID: $id, Name: " . $user['name'] . ", Email: " . $user['email']);
        return $user;
    } else {
        logAction("User not found. ID: $id");
        return null;
    }
}
?>
