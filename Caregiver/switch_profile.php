<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$original_user_id = isset($_SESSION['original_caregiver_id']) ? $_SESSION['original_caregiver_id'] : $_SESSION['user_id'];

if (isset($_GET['switch_to'])) {
    $target_user_id = mysqli_real_escape_string($conn, $_GET['switch_to']);
    
    if ($target_user_id == $original_user_id) {
        $_SESSION['user_id'] = $original_user_id;
        unset($_SESSION['original_caregiver_id']);
        
        $query = "SELECT full_name FROM users WHERE user_id='$original_user_id'";
        $res = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($res);
        $_SESSION['full_name'] = $user['full_name'];
    } else {
        $check = mysqli_query($conn, "SELECT full_name FROM users WHERE user_id='$target_user_id' AND caregiver_id='$original_user_id'");
        if (mysqli_num_rows($check) == 1) {
            $user = mysqli_fetch_assoc($check);
            $_SESSION['original_caregiver_id'] = $original_user_id;
            $_SESSION['user_id'] = $target_user_id;
            $_SESSION['full_name'] = $user['full_name'] . " (Acting Profile)";
        }
    }
}

header("Location: dashboard.php");
exit();
?>