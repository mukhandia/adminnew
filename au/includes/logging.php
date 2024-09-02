<?php
function logAction($message) {
    $logFile = 'path/to/your/logs/user_actions.log'; // Update this path
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "$timestamp - $message\n";

    file_put_contents($logFile, $logMessage, FILE_APPEND);
}
?>
