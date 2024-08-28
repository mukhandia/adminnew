<?php
require_once '../dbhandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $result = insertUser($name, $email, $password, $role);

    if ($result === true) {
        echo "New user created successfully";
        
    } else {
        echo $result; // This will output the error message if the insertion failed
    }
}
?>
