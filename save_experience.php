<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];

// Handle delete request
if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete'];
    $delete_query = "DELETE FROM experience WHERE id = $delete_id AND user_id = $user_id";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        echo "<script>
            alert('Experience entry deleted successfully.');
            window.location.href = 'experience.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to delete experience entry.');
            window.location.href = 'experience.php';
        </script>";
    }
    exit;
}

// Handle save (insert/update)
if (isset($_POST['save'])) {
    $exp_ids = $_POST['exp_id'];
    $companyNames = $_POST['companyName'];
    $jobTitles = $_POST['jobTitle'];
    $startDates = $_POST['startDate'];
    $endDates = $_POST['endDate'];
    $jobDescriptions = $_POST['jobDescription'];

    $success = true;

    for ($i = 0; $i < count($companyNames); $i++) {
        $id = $exp_ids[$i];
        $company = mysqli_real_escape_string($conn, $companyNames[$i]);
        $title = mysqli_real_escape_string($conn, $jobTitles[$i]);
        $start = mysqli_real_escape_string($conn, $startDates[$i]);
        $end = isset($endDates[$i]) ? mysqli_real_escape_string($conn, $endDates[$i]) : null;
        $desc = mysqli_real_escape_string($conn, $jobDescriptions[$i]);

        if (!empty($id)) {
            // Update existing record
            $update_query = "UPDATE experience SET 
                company_name = '$company',
                job_title = '$title',
                start_date = '$start',
                end_date = " . ($end ? "'$end'" : "NULL") . ",
                job_description = '$desc'
                WHERE id = $id AND user_id = $user_id";
            $result = mysqli_query($conn, $update_query);
        } else {
            // Insert new record
            $insert_query = "INSERT INTO experience (
                user_id, company_name, job_title, start_date, end_date, job_description
            ) VALUES (
                '$user_id', '$company', '$title', '$start', " . ($end ? "'$end'" : "NULL") . ", '$desc'
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
            alert('Experience details saved successfully.');
            window.location.href = 'experience.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to save experience details.');
            window.location.href = 'experience.php';
        </script>";
    }
}
?>
