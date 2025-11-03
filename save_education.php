<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];

// Handle delete request
if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete'];
    $delete_query = "DELETE FROM education WHERE id = $delete_id AND user_id = $user_id";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        echo "<script>
            alert('Education entry deleted successfully.');
            window.location.href = './education.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to delete education entry.');
            window.location.href = './education.php';
        </script>";
    }
    exit;
}

// Handle save (insert/update)
if (isset($_POST['save'])) {
    $edu_ids = $_POST['edu_id'];
    $courseDegrees = $_POST['courseDegree'];
    $schoolUniversities = $_POST['schoolUniversity'];
    $gradeScores = $_POST['gradeScore'];
    $years = $_POST['year'];

    $success = true;

    for ($i = 0; $i < count($courseDegrees); $i++) {
        $id = $edu_ids[$i];
        $course = mysqli_real_escape_string($conn, $courseDegrees[$i]);
        $school = mysqli_real_escape_string($conn, $schoolUniversities[$i]);
        $grade = mysqli_real_escape_string($conn, $gradeScores[$i]);
        $year = mysqli_real_escape_string($conn, $years[$i]);

        if (!empty($id)) {
            // Update existing record
            $update_query = "UPDATE education SET 
                course_degree = '$course',
                school_university = '$school',
                grade_score = '$grade',
                year = '$year'
                WHERE id = $id AND user_id = $user_id";
            $result = mysqli_query($conn, $update_query);
        } else {
            // Insert new record
            $insert_query = "INSERT INTO education (
                user_id, course_degree, school_university, grade_score, year
            ) VALUES (
                '$user_id', '$course', '$school', '$grade', '$year'
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
            alert('Education details saved successfully.');
            window.location.href = 'education.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to save education details.');
            window.location.href = 'education.php';
        </script>";
    }
}
?>
