<?php
session_start();
include '../partials/db.php';

if (!isset($_GET['token'])) {
    echo "<script>alert('Invalid or missing token.'); window.location.href='./';</script>";
    exit();
}

$token = $_GET['token'];

// Check if token is valid and not expired
$stmt = $conn->prepare("SELECT email, expires_at FROM password_resets WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Invalid or expired token.'); window.location.href='./';</script>";
    exit();
}

$data = $result->fetch_assoc();
$email = $data['email'];
$expires_at = $data['expires_at'];

if (strtotime($expires_at) < time()) {
    echo "<script>alert('Token has expired.'); window.location.href='./';</script>";
    exit();
}

// Handle password reset form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // ✅ Update password in admin_users table
        $update = $conn->prepare("UPDATE admin_users SET password = ? WHERE email = ?");
        $update->bind_param("ss", $hashed_password, $email);
        $update->execute();

        // Delete the token
        $delete = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
        $delete->bind_param("s", $email);
        $delete->execute();

        echo "<script>alert('Password reset successful. Please login.'); window.location.href='./';</script>";
        exit();
    }
}
?>


<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Admin Password</title>
    <?php include '../partials/head.php'; ?>
</head>
<body>
<div class="container">
    <h2 class="text-center mt-5">Reset Admin Password</h2>
    <form method="POST" class="mt-4">
        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="password" class="form-control" required minlength="6">
        </div>
        <div class="form-group">
            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" required minlength="6">
        </div>
        <button type="submit" class="btn btn-success mt-3">Reset Password</button>
    </form>
</div>
<?php include '../partials/scripts.php'; ?>
</body>
</html>