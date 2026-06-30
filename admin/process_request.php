<?php
require_once '../config/database.php';

$validActions = ['Approved', 'Completed', 'Cancelled'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id']) && isset($_POST['action'])) {
    $requestId = (int) $_POST['request_id'];
    $action = $_POST['action'];

    if (in_array($action, $validActions)) {
        $stmt = mysqli_prepare($conn, "UPDATE service_requests SET status = ? WHERE request_id = ?");
        mysqli_stmt_bind_param($stmt, "si", $action, $requestId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $msg = "Request #$requestId marked as $action.";
    } else {
        $msg = "Invalid action.";
    }
} else {
    $msg = "Invalid request.";
}

header("Location: dashboard.php?msg=" . urlencode($msg));
exit;
