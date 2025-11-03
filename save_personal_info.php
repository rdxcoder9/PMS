<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];
$dob = $_POST['dob'];
$nationality = $_POST['nationality'];
$phone_number = $_POST['phoneNumber'];
$email_address = $_SESSION['email']; // Email is disabled in form
$linkedin_url = $_POST['LinkedInProfile'];
$gender = $_POST['gender'];
$address = $_POST['address'];
$dataExists = $_POST['dataExists'];

if ($dataExists == '1') {
    // UPDATE existing record
    $query = "UPDATE personal_info SET 
                dob = '$dob',
                nationality = '$nationality',
                phone_number = '$phone_number',
                email_address = '$email_address',
                linkedin_url = '$linkedin_url',
                gender = '$gender',
                address = '$address'
              WHERE user_id = $user_id";
} else {
    // INSERT new record
    $query = "INSERT INTO personal_info (
                user_id, dob, nationality, phone_number, email_address,
                linkedin_url, gender, address
              ) VALUES (
                '$user_id', '$dob', '$nationality', '$phone_number', '$email_address',
                '$linkedin_url', '$gender', '$address'
              )";
}

$result = mysqli_query($conn, $query);

if ($result) {
    echo "<script>
        alert('Personal information saved successfully.');
        window.location.href = 'personal_info.php';
    </script>";
} else {
    echo "<script>
        alert('Failed to save personal information.');
        window.location.href = 'personal_info.php';
    </script>";
}
?>
