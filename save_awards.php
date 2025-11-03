<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];

// Handle delete request
if (isset($_POST['delete'])) {
    $delete_id = intval($_POST['delete']);
    $delete_query = "DELETE FROM awards WHERE id = $delete_id AND user_id = $user_id";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        echo "<script>
            alert('Award entry deleted successfully.');
            window.location.href = 'awards-achievements-form.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to delete award entry.');
            window.location.href = 'awards-achievements-form.php';
        </script>";
    }
    exit;
}

// Handle save (insert/update)
if (isset($_POST['save'])) {
    $award_ids = $_POST['award_id'];
    $titles = $_POST['awardTitle'];
    $presenters = $_POST['presentedBy'];
    $dates = $_POST['awardDate'];
    $descriptions = $_POST['awardDescription'];

    $success = true;

    for ($i = 0; $i < count($titles); $i++) {
        $id = intval($award_ids[$i]);
        $title = mysqli_real_escape_string($conn, $titles[$i]);
        $presented_by = mysqli_real_escape_string($conn, $presenters[$i]);
        $date_received = mysqli_real_escape_string($conn, $dates[$i]);
        $description = mysqli_real_escape_string($conn, $descriptions[$i]);

        if (!empty($id)) {
            // Update existing award
            $update_query = "UPDATE awards SET 
                award_title = '$title',
                presented_by = '$presented_by',
                date_received = '$date_received',
                description = '$description'
                WHERE id = $id AND user_id = $user_id";
            $result = mysqli_query($conn, $update_query);
        } else {
            // Insert new award
            $insert_query = "INSERT INTO awards (
                user_id, award_title, presented_by, date_received, description
            ) VALUES (
                '$user_id', '$title', '$presented_by', '$date_received', '$description'
            )";
            $result = mysqli_query($conn, $insert_query);
        }

        if (!$result) {
            $success = false;
            break;
        }
    }

    if ($success) {
        echo "<script>
            alert('Awards saved successfully.');
            window.location.href = 'awards-achievements-form.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to save awards.');
            window.location.href = 'awards-achievements-form.php';
        </script>";
    }
}
?>
