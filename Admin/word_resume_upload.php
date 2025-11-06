<?php
session_start();
include '../partials/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$targetDir = "../uploads/word_resumes/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

// Handle Upload
if (isset($_POST['upload'])) {
    $wordFile = $_FILES['word_file'];
    $imageFile = $_FILES['preview_image'];

    $wordName = pathinfo($wordFile['name'], PATHINFO_FILENAME);
    $wordExt = pathinfo($wordFile['name'], PATHINFO_EXTENSION);
    $imageExt = pathinfo($imageFile['name'], PATHINFO_EXTENSION);

    if (!in_array(strtolower($wordExt), ['doc', 'docx'])) {
        echo "<script>alert('Invalid Word file format');</script>";
    } else {
        $uniqueFolder = $wordName . "_" . time();
        $folderPath = $targetDir . $uniqueFolder;
        mkdir($folderPath, 0777, true);

        // Rename files to avoid conflicts
        $wordFilename = $wordName . "_" . uniqid() . "." . $wordExt;
        $imageFilename = "preview_" . uniqid() . "." . $imageExt;

        move_uploaded_file($wordFile['tmp_name'], $folderPath . "/" . $wordFilename);
        move_uploaded_file($imageFile['tmp_name'], $folderPath . "/" . $imageFilename);

        $stmt = $conn->prepare("INSERT INTO word_resume_uploads (folder_name, original_filename, preview_image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $uniqueFolder, $wordFilename, $imageFilename);
        $stmt->execute();
    }
}

// Handle Delete
if (isset($_POST['delete'])) {
    $folder = $_POST['folder_name'];
    $fullPath = $targetDir . $folder;

    if (is_dir($fullPath)) {
        $files = glob($fullPath . '/*');
        foreach ($files as $file) {
            if (is_file($file)) unlink($file);
        }
        rmdir($fullPath);
    }

    $stmt = $conn->prepare("DELETE FROM word_resume_uploads WHERE folder_name = ?");
    $stmt->bind_param("s", $folder);
    $stmt->execute();
}

// Fetch uploaded folders
$result = mysqli_query($conn, "SELECT * FROM word_resume_uploads ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Word Resume Upload</title>
  <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="shortcut icon" href="../assets/images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <?php include '../partials/_navbar_admin.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include '../partials/_sidebar_admin.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container mt-4">
            <h2 class="mb-4">Upload Word Resume with Preview Image</h2>

            <!-- Upload Form -->
            <form method="POST" enctype="multipart/form-data" class="mb-4">
              <div class="form-group">
                <label>Word File (.doc, .docx):</label>
                <input type="file" name="word_file" class="form-control" accept=".doc,.docx" required>
              </div>
              <div class="form-group">
                <label>Preview Image (JPG, PNG):</label>
                <input type="file" name="preview_image" class="form-control" accept=".jpg,.jpeg,.png" required>
              </div>
              <button type="submit" name="upload" class="btn btn-success">Upload</button>
            </form>

            <!-- Uploaded Directory List -->
            <h4 class="mt-5">Uploaded Word Resume Folders</h4>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th>ID</th>
                    <th>Folder Name</th>
                    <th>Word File</th>
                    <th>Preview</th>
                    <th>Uploaded At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                      <td><?= $row['id'] ?></td>
                      <td><?= $row['folder_name'] ?></td>
                      <td>
                        <?php
                          $filename = $row['original_filename'];
                          $shortName = strlen($filename) > 30 ? substr($filename, 0, 27) . '...' : $filename;
                          echo $shortName;
                        ?>
                      </td>
                      <td>
                        <?php if ($row['preview_image']) { ?>
                          <img src="<?= $targetDir . $row['folder_name'] . "/" . $row['preview_image'] ?>" width="100" alt="Preview">
                        <?php } ?>
                      </td>
                      <td><?= $row['uploaded_at'] ?></td>
                      <td>
                        <form method="POST" style="display:inline;">
                          <input type="hidden" name="folder_name" value="<?= $row['folder_name'] ?>">
                          <button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirm('Delete this folder?')">Delete</button>
                        </form>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php include '../partials/_footer.php'; ?>
      </div>
    </div>
  </div>

  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="../assets/js/off-canvas.js"></script>
  <script src="../assets/js/misc.js"></script>
</body>
</html>
