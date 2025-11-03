<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['save'])) {
    $objective = mysqli_real_escape_string($conn, $_POST['objective']);

    // Check if objective already exists
    $check_query = "SELECT * FROM career_objective WHERE user_id = $user_id";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Update existing objective
        $update_query = "UPDATE career_objective SET objective = '$objective' WHERE user_id = $user_id";
        $result = mysqli_query($conn, $update_query);
        $message = $result ? 'Career objective updated successfully.' : 'Failed to update career objective.';
    } else {
        // Insert new objective
        $insert_query = "INSERT INTO career_objective (user_id, objective) VALUES ($user_id, '$objective')";
        $result = mysqli_query($conn, $insert_query);
        $message = $result ? 'Career objective submitted successfully.' : 'Failed to submit career objective.';
    }

    echo "<script>
        alert('$message');
        window.location.href = 'objective.php';
    </script>";
}
?>
