<?php
session_start();
include "../includes/dbconnection.php";
require_once '../includes/logger.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepare and execute SQL query
    $sql = "SELECT id, name, password, role FROM user_table WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($userId, $name, $hashedPassword, $role);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                // Start user session
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_role'] = $role;
                $userEmail = $_SESSION['user_email'];
                
                // Log successful login
                logAction("User with email $email logged in successfully.");

                // Redirect based on user role
                if ($role === 'superadmin') {
                    header("Location: ../"); 
                } elseif ($role === 'admin') {
                    header("Location: ../au"); 
                    $error = "Unauthorized role.";
                    logAction("User with email $email attempted to login with unauthorized role.");
                }
                exit;
            } else {
                $error = "Invalid email or password.";
                logAction("Failed login attempt for email $email due to incorrect password.");
            }
        } else {
            $error = "Invalid email or password.";
            logAction("Failed login attempt for email $email due to non-existent email.");
        }

        $stmt->close();
    } else {
        $error = "Error preparing statement: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Dashboard Login</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <link rel="shortcut icon" href="../assets/images/favicon.png">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css">
</head>

<body class="fixed-left">
    <div class="wrapper-page">
        <div class="card">
            <div class="card-body">
                <div class="text-center m-b-15">
                    <a style="color: red;" href="../index.php" class="logo logo-admin">Afripixel Solutions</a>
                </div>
                <div class="p-3">
                    <form class="form-horizontal m-t-20" action="login.php" method="POST">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" type="email" name="email" required placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" type="password" name="password" required placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group text-center row m-t-20">
                            <div class="col-12">
                                <button class="btn btn-danger btn-block waves-effect waves-light" type="submit">Log In</button>
                            </div>
                        </div>
                        <div class="form-group m-t-10 mb-0 row">
                            <div class="col-sm-7 m-t-20">
                                <a href="" class="text-muted"><i class="mdi mdi-lock"></i> <small>Forgot your password?</small></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/modernizr.min.js"></script>
    <script src="../assets/js/detect.js"></script>
    <script src="../assets/js/fastclick.js"></script>
    <script src="../assets/js/jquery.slimscroll.js"></script>
    <script src="../assets/js/jquery.blockUI.js"></script>
    <script src="../assets/js/waves.js"></script>
    <script src="../assets/js/jquery.nicescroll.js"></script>
    <script src="../assets/js/jquery.scrollTo.min.js"></script>
    <script src="../assets/js/app.js"></script>
</body>

</html>
