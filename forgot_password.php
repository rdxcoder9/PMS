<?php
session_start();
include './partials/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Store token in a new table or reuse existing one
        $conn->query("CREATE TABLE IF NOT EXISTS password_resets (
            email VARCHAR(255) NOT NULL,
            token VARCHAR(255) NOT NULL,
            expires_at DATETIME NOT NULL
        )");

        $conn->query("DELETE FROM password_resets WHERE email = '$email'");
        $insert = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $email, $token, $expiry);
        $insert->execute();

        // Send email using PHPMailer
        require './vendor/autoload.php'; // Make sure PHPMailer is installed via Composer

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            // SMTP config
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'scrolljobupdates@gmail.com'; // Your Gmail
            $mail->Password = 'lcro jpmz spmx oskp';   // App password, not Gmail password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Email content
            $mail->setFrom('scrolljobupdates@gmail.com', 'PMS Support');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "Click the link below to reset your password:<br><br>
                localhost/PMS/reset_fg_password.php?token=$token Password</a><br><br>
                This link will expire in 1 hour.";

            $mail->send();
            echo "<script>alert('Password reset link sent to your email.'); window.location.href='./';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Email could not be sent.'); window.location.href='./';</script>";
        }
    } else {
        echo "<script>alert('Email not found.'); window.location.href='./forgot_password.php';</script>";
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <?php include './partials/head.php'; ?>
</head>
<body>
<div class="container">
    <h2 class="text-center mt-5">Forgot Password</h2>
    <form method="POST" class="mt-4">
        <div class="form-group">
            <label>Enter your registered email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Send Reset Link</button>
    </form>
</div>
<?php include './partials/scripts.php'; ?>
</body>
</html>