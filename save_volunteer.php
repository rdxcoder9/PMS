<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];

// Handle delete request
if (isset($_POST['delete'])) {
    $delete_id = intval($_POST['delete']);
    $delete_query = "DELETE FROM experience WHERE id = $delete_id AND user_id = $user_id AND job_title = 'Volunteer'";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        echo "<script>
            alert('Volunteer experience deleted successfully.');
            window.location.href = 'volunteer-experience-form.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to delete volunteer experience.');
            window.location.href = 'volunteer-experience-form.php';
        </script>";
    }
    exit;
}

// Handle save (insert/update)
if (isset($_POST['save'])) {
    $vol_ids = $_POST['volunteer_id'];
    $orgs = $_POST['organizationName'];
    $roles = $_POST['volunteerRole'];
    $starts = $_POST['startDate'];
    $ends = $_POST['endDate'];
    $descs = $_POST['volunteerDescription'];

    $success = true;

    for ($i = 0; $i < count($orgs); $i++) {
        $id = intval($vol_ids[$i]);
        $org = mysqli_real_escape_string($conn, $orgs[$i]);
        $role = mysqli_real_escape_string($conn, $roles[$i]);
        $start = mysqli_real_escape_string($conn, $starts[$i]);
        $end = !empty($ends[$i]) ? "'" . mysqli_real_escape_string($conn, $ends[$i]) . "'" : "NULL";
        $desc = mysqli_real_escape_string($conn, $descs[$i]);

        if (!empty($id)) {
            // Update existing entry
            $update_query = "UPDATE experience SET 
                company_name = '$org',
                job_title = '$role',
                start_date = '$start',
                end_date = $end,
                job_description = '$desc'
                WHERE id = $id AND user_id = $user_id AND job_title = 'Volunteer'";
            $result = mysqli_query($conn, $update_query);
        } else {
            // Insert new entry
            $insert_query = "INSERT INTO experience (
                user_id, company_name, job_title, start_date, end_date, job_description
            ) VALUES (
                '$user_id', '$org', '$role', '$start', $end, '$desc'
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
            alert('Volunteer experiences saved successfully.');
            window.location.href = 'volunteer-experience-form.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to save volunteer experiences.');
            window.location.href = 'volunteer-experience-form.php';
        </script>";
    }
}
?>
