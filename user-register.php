<?php
include './partials/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $email      = trim($_POST['email']);
    $password   = $_POST['password'];

    // Check if email already exists
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<script>
                alert('Email already registered.');
                window.location.href = './register.php';
              </script>";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $insertStmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $insertStmt->bind_param("ssss", $first_name, $last_name, $email, $hashedPassword);

        if ($insertStmt->execute()) {
            echo "<script>
                    alert('Registration successful. Please login.');
                    window.location.href = './';
                  </script>";
        } else {
            echo "<script>
                    alert('Registration failed. Please try again.');
                    window.location.href = './register.php';
                  </script>";
        }

        $insertStmt->close();
    }

    $checkStmt->close();
    $conn->close();
} else {
    echo "<script>
            window.location.href = './register.php';
          </script>";
}
?>
