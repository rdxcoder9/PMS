<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];

// Handle delete request
if (isset($_POST['delete'])) {
    $delete_id = intval($_POST['delete']);
    $delete_query = "DELETE FROM skills WHERE id = $delete_id AND user_id = $user_id";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        echo "<script>
            alert('Skill entry deleted successfully.');
            window.location.href = 'skills.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to delete skill entry.');
            window.location.href = 'skills.php';
        </script>";
    }
    exit;
}

// Handle save (insert/update)
if (isset($_POST['save'])) {
    $skill_ids = $_POST['skill_id'];
    $skill_names = $_POST['skillName'];
    $skill_levels = $_POST['skillLevel'];

    $success = true;

    for ($i = 0; $i < count($skill_names); $i++) {
        $id = intval($skill_ids[$i]);
        $name = mysqli_real_escape_string($conn, $skill_names[$i]);
        $level = mysqli_real_escape_string($conn, $skill_levels[$i]);

        if (!empty($id)) {
            // Update existing record
            $update_query = "UPDATE skills SET 
                skill_name = '$name',
                skill_level = '$level'
                WHERE id = $id AND user_id = $user_id";
            $result = mysqli_query($conn, $update_query);
        } else {
            // Insert new record
            $insert_query = "INSERT INTO skills (user_id, skill_name, skill_level)
                VALUES ('$user_id', '$name', '$level')";
            $result = mysqli_query($conn, $insert_query);
        }

        if (!$result) {
            $success = false;
            break;
        }
    }

    if ($success) {
        echo "<script>
            alert('Skills saved successfully.');
            window.location.href = 'skills.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to save skills.');
            window.location.href = 'skills.php';
        </script>";
    }
}
?>
