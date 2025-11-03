<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];

// Handle delete request
if (isset($_POST['delete'])) {
    $delete_id = intval($_POST['delete']);
    $delete_query = "DELETE FROM publications WHERE id = $delete_id AND user_id = $user_id";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        echo "<script>
            alert('Publication entry deleted successfully.');
            window.location.href = 'publications-research-form.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to delete publication entry.');
            window.location.href = 'publications-research-form.php';
        </script>";
    }
    exit;
}

// Handle save (insert/update)
if (isset($_POST['save'])) {
    $pub_ids = $_POST['publication_id'];
    $titles = $_POST['publicationTitle'];
    $journals = $_POST['journalName'];
    $dates = $_POST['publicationDate'];
    $links = $_POST['publicationLink'];
    $abstracts = $_POST['publicationDescription'];

    $success = true;

    for ($i = 0; $i < count($titles); $i++) {
        $id = intval($pub_ids[$i]);
        $title = mysqli_real_escape_string($conn, $titles[$i]);
        $journal = mysqli_real_escape_string($conn, $journals[$i]);
        $date = mysqli_real_escape_string($conn, $dates[$i]);
        $link = mysqli_real_escape_string($conn, $links[$i]);
        $abstract = mysqli_real_escape_string($conn, $abstracts[$i]);

        if (!empty($id)) {
            // Update existing publication
            $update_query = "UPDATE publications SET 
                title = '$title',
                published_in = '$journal',
                publication_date = '$date',
                link_doi = '$link',
                abstract = '$abstract'
                WHERE id = $id AND user_id = $user_id";
            $result = mysqli_query($conn, $update_query);
        } else {
            // Insert new publication
            $insert_query = "INSERT INTO publications (
                user_id, title, published_in, publication_date, link_doi, abstract
            ) VALUES (
                '$user_id', '$title', '$journal', '$date', '$link', '$abstract'
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
            alert('Publications saved successfully.');
            window.location.href = 'publications-research-form.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to save publications.');
            window.location.href = 'publications-research-form.php';
        </script>";
    }
}
?>
