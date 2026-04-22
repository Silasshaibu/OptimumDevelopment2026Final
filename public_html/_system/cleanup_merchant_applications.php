<?php
/**
 * Cleanup Script for Merchant Applications
 * 
 * This script deletes unconfirmed merchant applications older than 1 hour.
 * Run this script via cron job every 15-30 minutes:
 */ 

require_once __DIR__ . '/../db.php';

// Delete unconfirmed applications older than 1 hour
$sql = "DELETE FROM merchant_applications 
        WHERE confirmed = 0 
        AND created_at < DATE_SUB(NOW(), INTERVAL 1 HOUR)";

if ($conn->query($sql)) {
    $deleted_count = $conn->affected_rows;
    $timestamp = date('Y-m-d H:i:s');
    
    // Log the cleanup
    $log_message = "[{$timestamp}] Cleanup completed: {$deleted_count} unconfirmed application(s) deleted.\n";
    file_put_contents(__DIR__ . '/cleanup_log.txt', $log_message, FILE_APPEND);
    
    echo $log_message;
} else {
    $error_message = "[" . date('Y-m-d H:i:s') . "] Cleanup failed: " . $conn->error . "\n";
    file_put_contents(__DIR__ . '/cleanup_log.txt', $error_message, FILE_APPEND);
    
    echo $error_message;
}

$conn->close();
?>
