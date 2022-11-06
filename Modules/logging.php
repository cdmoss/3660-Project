<?php
function logError($message) {
    $datetime = new DateTime();
    $datetime->setTimezone(new DateTimeZone('America/Edmonton'));
    $logEntry = $datetime->format('Y/m/d H:i:s') . ' ' . $message;

    // log to default error_log destination
    error_log($logEntry);
}

?>