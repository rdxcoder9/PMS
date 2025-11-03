<?php

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "pms";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    $_SESSION['form_data'] = $_POST;
    echo "<script>alert('Database connection failed: " . $conn->connect_error . "'); window.location.href='./personal_info.php';</script>";
    exit;
}