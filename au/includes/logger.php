<?php
function logAction($message) {
    $logFile = '../logs/user_actions.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "$timestamp - $message\n";

    file_put_contents($logFile, $logMessage, FILE_APPEND);
}
?>
