<?php
session_start();
include '../partials/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch admin user by email
    $stmt = $conn->prepare("SELECT id, username, password FROM admin_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            echo "<script>alert('Login successful!'); window.location.href='admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Incorrect password.'); window.location.href='admin_login.php';</script>";
        }
    } else {
        echo "<script>alert('Admin account not found.'); window.location.href='admin_login.php';</script>";
    }
}
?>
