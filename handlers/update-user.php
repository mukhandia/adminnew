<?php
require_once '../dbhandler.php';
require_once '../includes/logger.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['idu'];
    $name = $_POST['nameu'];
    $email = $_POST['emailu'];
    $password = $_POST['passwordu'];
    $role = $_POST['roleu'];

    $result = updateUser($id, $name, $email, $password, $role);

    if ($result === true) {
       
        header('Location: ../users.php?message=User updated successfully');
        exit;
    } else {

        header('Location: ../users.php?error=' . urlencode($result));
        exit;
    }
}
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $user = getUserById($userId);

    if ($user) {
        // Use $user data to pre-fill the form or display user details
        // For example:
        $name = $user['name'];
        $email = $user['email'];
        $role = $user['role'];
        // etc.
    } else {
        echo "User not found.";
    }
} else {
    echo "No user ID specified.";
}
?>
