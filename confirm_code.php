<?php
// Assuming you've connected to the database
require 'includes/dbconnection.php'; // Make sure to include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $entered_code = $_POST['reset_code'];

    // Check if the reset code matches and if it hasn't expired
    $query = "SELECT reset_code, expiry_time FROM password_resets WHERE email = ? AND reset_code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $email, $entered_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $expiry_time = $row['expiry_time'];

        // Check if the reset code has expired
        if (time() < $expiry_time) {
            // Code is valid and not expired
            header("Location: reset-password.php?email=" . urlencode($email) . "&code=" . urlencode($entered_code));
            exit();
        } else {
            $error = "Reset code has expired. Please request a new one.";
        }
    } else {
        $error = "Invalid reset code.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Reset Code</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="card mt-5">
        <div class="card-body">
            <h3 class="card-title text-center">Confirm Reset Code</h3>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['email']) ?>" />
                
                <div class="form-group">
                    <label for="reset_code">Enter Reset Code</label>
                    <input type="text" class="form-control" name="reset_code" required placeholder="Enter code">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Confirm Code</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
