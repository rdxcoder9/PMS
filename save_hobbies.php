<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];

// Handle delete request
if (isset($_POST['delete'])) {
    $delete_id = intval($_POST['delete']);
    $delete_query = "DELETE FROM hobbies WHERE id = $delete_id AND user_id = $user_id";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        echo "<script>
            alert('Hobby entry deleted successfully.');
            window.location.href = 'hobbies-interests-form.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to delete hobby entry.');
            window.location.href = 'hobbies-interests-form.php';
        </script>";
    }
    exit;
}

// Handle save (insert/update)
if (isset($_POST['save'])) {
    $hobby_ids = $_POST['hobby_id'];
    $names = $_POST['hobbyName'];
    $descriptions = $_POST['hobbyDescription'];

    $success = true;

    for ($i = 0; $i < count($names); $i++) {
        $id = intval($hobby_ids[$i]);
        $name = mysqli_real_escape_string($conn, $names[$i]);
        $desc = mysqli_real_escape_string($conn, $descriptions[$i]);

        if (!empty($id)) {
            // Update existing hobby
            $update_query = "UPDATE hobbies SET 
                hobby_interest = '$name',
                description = '$desc'
                WHERE id = $id AND user_id = $user_id";
            $result = mysqli_query($conn, $update_query);
        } else {
            // Insert new hobby
            $insert_query = "INSERT INTO hobbies (user_id, hobby_interest, description)
                VALUES ('$user_id', '$name', '$desc')";
            $result = mysqli_query($conn, $insert_query);
        }

        if (!$result) {
            $success = false;
            break;
        }
    }

    if ($success) {
        echo "<script>
            alert('Hobbies saved successfully.');
            window.location.href = 'hobbies-interests-form.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to save hobbies.');
            window.location.href = 'hobbies-interests-form.php';
        </script>";
    }
}
?>
