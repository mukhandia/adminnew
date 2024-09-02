<?php
// Connect to the database
include "includes/dbconnection.php";

// Path to your log file
$logFilePath = 'logs/user_actions.log';

// Path to a file that stores the last processed position
$positionFilePath = 'logs/last_position.txt';

// Define the delay between checks (in seconds)
$checkInterval = 200; // 5 minutes

while (true) {
    // Get the last processed position
    $lastPosition = file_exists($positionFilePath) ? (int)file_get_contents($positionFilePath) : 0;

    // Open the log file for reading
    $logFile = fopen($logFilePath, 'r');
    if ($logFile === false) {
        die("Error opening log file.");
    }

    // Move to the last processed position
    fseek($logFile, $lastPosition);

    // Read new log entries
    while (($logEntry = fgets($logFile)) !== false) {
        // Example log entry: "2024-08-31 01:05:22 - Failed login attempt for email summitmobile2@fgng.com due to non-existent email."
        
        // Regular expression to match log formats
        $regex = '/^(?<date>\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}) - (?<action>.+)$/';

        if (preg_match($regex, $logEntry, $matches)) {
            $date = $matches['date'];
            $action = $matches['action'];

            $email = null; // Default to null if not set
            $details = null; // Default to null if not set
            $type = null; // Default to null if not set

            // Parse different types of actions
            if (strpos($action, 'Failed login attempt for email') !== false) {
                // Parse email and reason
                if (preg_match('/Failed login attempt for email (?<email>[^ ]+) due to (?<reason>.+)$/', $action, $details)) {
                    $email = $details['email'];
                    $reason = $details['reason'];
                    $type = 'Failed login attempt';
                    $details = "Email: $email, Reason: $reason";
                }
            } elseif (strpos($action, 'User with email') !== false) {
                // Parse email and action
                if (preg_match('/User with email (?<email>[^ ]+) (?<action>.+)$/', $action, $details)) {
                    $email = $details['email'];
                    $userAction = $details['action'];
                    $type = 'User action';
                    $details = "Email: $email, Action: $userAction";
                }
            } elseif (strpos($action, 'User updated with new password') !== false) {
                // Parse user update details
                if (preg_match('/User updated with new password. ID: (?<id>\d+), Name: (?<name>[^,]+), Email: (?<email>[^,]+), Role: (?<role>\w+)$/', $action, $details)) {
                    $id = $details['id'];
                    $name = $details['name'];
                    $email = $details['email'];
                    $role = $details['role'];
                    $type = 'User updated password';
                    $details = "ID: $id, Name: $name, Email: $email, Role: $role";
                }
            } elseif (strpos($action, 'User inserted successfully') !== false) {
                // Parse new user details
                if (preg_match('/User inserted successfully. Name: (?<name>[^,]+), Email: (?<email>[^,]+), Role: (?<role>\w+)$/', $action, $details)) {
                    $name = $details['name'];
                    $email = $details['email'];
                    $role = $details['role'];
                    $type = 'User inserted';
                    $details = "Name: $name, Email: $email, Role: $role";
                }
            } elseif (strpos($action, 'User logged out') !== false) {
                // Parse user logout details
                if (preg_match('/User logged out. ID: (?<id>\d+), Name: (?<name>[^ ]+)$/', $action, $details)) {
                    $id = $details['id'];
                    $name = $details['name'];
                    $type = 'User logged out';
                    $details = "ID: $id, Name: $name";
                }
            } elseif (strpos($action, 'User with email') !== false && strpos($action, 'attempted to login with unauthorized role') !== false) {
                // Parse unauthorized login attempt
                if (preg_match('/User with email (?<email>[^ ]+) attempted to login with unauthorized role$/', $action, $details)) {
                    $email = $details['email'];
                    $type = 'Unauthorized login attempt';
                    $details = "Email: $email";
                }
            } else {
                echo "Log format not recognized: $logEntry\n";
                continue;
            }

            // Check if type and email are set before inserting
            if ($type && $email) {
                $stmt = $conn->prepare("INSERT INTO user_actions (action_date, user_email, action_type, details) VALUES (?, ?, ?, ?)");
                $stmt->bind_param('ssss', $date, $email, $type, $details);

                if ($stmt->execute()) {
                    echo "Log entry inserted successfully.\n";
                } else {
                    echo "Error inserting log entry: " . $stmt->error . "\n";
                }
            } else {
                echo "Skipping log entry due to missing information: $logEntry\n";
            }
        } else {
            echo "Log format not recognized: $logEntry\n";
        }
    }

    // Save the new position
    $position = ftell($logFile);
    file_put_contents($positionFilePath, $position);

    // Close file handle
    fclose($logFile);

    // Sleep for the specified interval before checking again
    sleep($checkInterval);
}

// Close database connection
$conn->close();
?>
