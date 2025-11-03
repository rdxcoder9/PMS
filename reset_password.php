<?php
session_start();
require './partials/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if new passwords match
    if ($new_password !== $confirm_password) {
        echo "<script>alert('New passwords do not match.'); window.location.href = 'edit-profile.php';</script>";
        exit;
    }

    // Fetch current password hash from DB
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($stored_hash);
    $stmt->fetch();
    $stmt->close();

    // Verify current password
    if (!password_verify($current_password, $stored_hash)) {
        echo "<script>alert('Current password is incorrect.'); window.location.href = 'edit-profile.php';</script>";
        exit;
    }

    // Hash new password
    $new_hash = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password in DB
    $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $update_stmt->bind_param("si", $new_hash, $user_id);
    if ($update_stmt->execute()) {
        echo "<script>alert('Password updated successfully.'); window.location.href = 'edit-profile.php';</script>";
    } else {
        echo "<script>alert('Error updating password.'); window.location.href = 'edit-profile.php';</script>";
    }

    $update_stmt->close();
    $conn->close();
}
?>