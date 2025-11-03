<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];

// Handle delete request
if (isset($_POST['delete'])) {
    $delete_id = intval($_POST['delete']);
    $delete_query = "DELETE FROM projects WHERE id = $delete_id AND user_id = $user_id";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        echo "<script>
            alert('Project entry deleted successfully.');
            window.location.href = 'project.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to delete project entry.');
            window.location.href = 'project.php';
        </script>";
    }
    exit;
}

// Handle save (insert/update)
if (isset($_POST['save'])) {
    $project_ids = $_POST['project_id'];
    $titles = $_POST['projectTitle'];
    $technologies = $_POST['technologyUsed'];
    $descriptions = $_POST['projectDescription'];

    $success = true;

    for ($i = 0; $i < count($titles); $i++) {
        $id = intval($project_ids[$i]);
        $title = mysqli_real_escape_string($conn, $titles[$i]);
        $tech = mysqli_real_escape_string($conn, $technologies[$i]);
        $desc = mysqli_real_escape_string($conn, $descriptions[$i]);

        if (!empty($id)) {
            // Update existing project
            $update_query = "UPDATE projects SET 
                project_title = '$title',
                technology_used = '$tech',
                project_description = '$desc'
                WHERE id = $id AND user_id = $user_id";
            $result = mysqli_query($conn, $update_query);
        } else {
            // Insert new project
            $insert_query = "INSERT INTO projects (user_id, project_title, technology_used, project_description)
                VALUES ('$user_id', '$title', '$tech', '$desc')";
            $result = mysqli_query($conn, $insert_query);
        }

        if (!$result) {
            $success = false;
            break;
        }
    }

    if ($success) {
        echo "<script>
            alert('Projects saved successfully.');
            window.location.href = 'project.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to save projects.');
            window.location.href = 'project.php';
        </script>";
    }
}
?>
