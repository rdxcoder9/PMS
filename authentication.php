<?php
session_start();
include './partials/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, first_name, last_name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['email'] = $user['email'];

            // Fetch profile photo from personal_info table
            $photo_stmt = $conn->prepare("SELECT photo FROM personal_info WHERE user_id = ?");
            $photo_stmt->bind_param("i", $user['id']);
            $photo_stmt->execute();
            $photo_result = $photo_stmt->get_result();

            if ($photo_result->num_rows > 0) {
                $photo_data = $photo_result->fetch_assoc();
                $_SESSION['photo'] = !empty($photo_data['photo']) ? $photo_data['photo'] : '';
            } else {
                $_SESSION['photo'] = '';
            }

            $photo_stmt->close();

            echo "<script>
                    alert('Login Successful');
                    window.location.href = './dashboard.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Incorrect Password');
                    window.location.href = './';
                  </script>";
        }
    } else {
        echo "<script>
                alert('User not found');
                window.location.href = './';
              </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>
            window.location.href = './';
          </script>";
}
?>