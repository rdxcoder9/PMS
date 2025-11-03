<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];

// Sanitize input
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$email = trim($_POST['email']);

// Update `users` table
$stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ? WHERE id = ?");
$stmt->bind_param("ssi", $first_name, $last_name, $user_id);
$stmt->execute();

// Update session variables
$_SESSION['name'] = $first_name . ' ' . $last_name;
$_SESSION['email'] = $email;

// Prepare image path
$imagePath = null;
$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['profile_photo']['tmp_name'];
    $fileName = 'profile_' . $user_id . '_' . time() . '.' . pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
    $imagePath = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmp, $imagePath)) {
        // Image saved successfully
    } else {
        $imagePath = null; // fallback if upload fails
    }
}

// Check if personal_info row exists
$checkStmt = $conn->prepare("SELECT user_id FROM personal_info WHERE user_id = ?");
$checkStmt->bind_param("i", $user_id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult && $checkResult->num_rows > 0) {
    // Update email and photo
    if ($imagePath) {
        $updateStmt = $conn->prepare("UPDATE personal_info SET email_address = ?, photo = ? WHERE user_id = ?");
        $updateStmt->bind_param("ssi", $email, $imagePath, $user_id);
    } else {
        $updateStmt = $conn->prepare("UPDATE personal_info SET email_address = ? WHERE user_id = ?");
        $updateStmt->bind_param("si", $email, $user_id);
    }
    $updateStmt->execute();
} else {
    // Insert new row
    if ($imagePath) {
        $insertStmt = $conn->prepare("INSERT INTO personal_info (user_id, email_address, photo) VALUES (?, ?, ?)");
        $insertStmt->bind_param("iss", $user_id, $email, $imagePath);
    } else {
        $insertStmt = $conn->prepare("INSERT INTO personal_info (user_id, email_address) VALUES (?, ?)");
        $insertStmt->bind_param("is", $user_id, $email);
    }
    $insertStmt->execute();
}

// Redirect back with success flag
header("Location: edit-profile.php?success=1");
exit;
