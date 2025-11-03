<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];

// Handle delete request
if (isset($_POST['delete'])) {
    $delete_id = intval($_POST['delete']);
    $delete_query = "DELETE FROM certifications WHERE id = $delete_id AND user_id = $user_id";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        echo "<script>
            alert('Certification entry deleted successfully.');
            window.location.href = 'certifications.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to delete certification entry.');
            window.location.href = 'certifications.php';
        </script>";
    }
    exit;
}

// Handle save (insert/update)
if (isset($_POST['save'])) {
    $cert_ids = $_POST['certification_id'];
    $names = $_POST['certificationName'];
    $orgs = $_POST['issuingOrg'];
    $issue_dates = $_POST['issueDate'];
    $expiry_dates = $_POST['expiryDate'];
    $urls = $_POST['credentialUrl'];

    $success = true;

    for ($i = 0; $i < count($names); $i++) {
        $id = intval($cert_ids[$i]);
        $name = mysqli_real_escape_string($conn, $names[$i]);
        $org = mysqli_real_escape_string($conn, $orgs[$i]);
        $issue = mysqli_real_escape_string($conn, $issue_dates[$i]);
        $expiry = !empty($expiry_dates[$i]) ? "'" . mysqli_real_escape_string($conn, $expiry_dates[$i]) . "'" : "NULL";
        $url = mysqli_real_escape_string($conn, $urls[$i]);

        if (!empty($id)) {
            // Update existing certification
            $update_query = "UPDATE certifications SET 
                certification_name = '$name',
                issuing_organization = '$org',
                issue_date = '$issue',
                expiry_date = $expiry,
                credential_url = '$url'
                WHERE id = $id AND user_id = $user_id";
            $result = mysqli_query($conn, $update_query);
        } else {
            // Insert new certification
            $insert_query = "INSERT INTO certifications (
                user_id, certification_name, issuing_organization, issue_date, expiry_date, credential_url
            ) VALUES (
                '$user_id', '$name', '$org', '$issue', $expiry, '$url'
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
            alert('Certifications saved successfully.');
            window.location.href = 'certifications.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to save certifications.');
            window.location.href = 'certifications.php';
        </script>";
    }
}
?>
