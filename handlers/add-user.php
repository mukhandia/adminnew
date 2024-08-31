<?php
require_once '../dbhandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $result = insertUser($conn,$name, $email, $password, $role);

    if ($result === true) {
        echo "New user created successfully";
        header('Location: ../users.php?message=User Added successfully');
    } else {
        echo $result; 
    }
}
?>
