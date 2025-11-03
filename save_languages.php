<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle delete request
    if (isset($_POST['delete'])) {
        $delete_id = intval($_POST['delete']);
        $delete_query = "DELETE FROM languages WHERE id = $delete_id AND user_id = $user_id";
        mysqli_query($conn, $delete_query);
        header("Location: languages-form.php");
        exit();
    }

    // Handle save/update request
    if (isset($_POST['save'])) {
        $language_ids = $_POST['language_id'];
        $language_names = $_POST['languageName'];
        $proficiency_levels = $_POST['proficiencyLevel'];

        for ($i = 0; $i < count($language_names); $i++) {
            $id = intval($language_ids[$i]);
            $name = mysqli_real_escape_string($conn, $language_names[$i]);
            $level = mysqli_real_escape_string($conn, $proficiency_levels[$i]);

            if ($id > 0) {
                // Update existing record
                $update_query = "UPDATE languages SET language_name = '$name', proficiency_level = '$level' WHERE id = $id AND user_id = $user_id";
                mysqli_query($conn, $update_query);
            } else {
                // Insert new record
                $insert_query = "INSERT INTO languages (user_id, language_name, proficiency_level) VALUES ($user_id, '$name', '$level')";
                mysqli_query($conn, $insert_query);
            }
        }

        header("Location: languages-form.php");
        exit();
    }
}
?>