<?php
session_start();
include '../partials/db.php';

// Redirect if admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Directory to extract resumes
$targetDir = "../uploads/resumes/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

// Handle Upload
if (isset($_POST['upload'])) {
    foreach ($_FILES['resume_zip']['name'] as $key => $name) {
        $tmpName = $_FILES['resume_zip']['tmp_name'][$key];
        $originalName = pathinfo($name, PATHINFO_FILENAME);
        $uniqueFolder = $originalName . "_" . time();
        $extractPath = $targetDir . $uniqueFolder;

        mkdir($extractPath, 0777, true);

        $zip = new ZipArchive;
        if ($zip->open($tmpName) === TRUE) {
            $zip->extractTo($extractPath);
            $zip->close();

            // Save to DB
            $stmt = $conn->prepare("INSERT INTO resume_uploads (folder_name, original_filename) VALUES (?, ?)");
            $stmt->bind_param("ss", $uniqueFolder, $name);
            $stmt->execute();
        }
    }
}

// Handle Delete
if (isset($_POST['delete'])) {
    $folder = $_POST['folder_name'];
    $fullPath = $targetDir . $folder;

    // Delete folder and contents
    if (is_dir($fullPath)) {
        $files = glob($fullPath . '/*');
        foreach ($files as $file) {
            if (is_file($file)) unlink($file);
        }
        rmdir($fullPath);
    }

    // Remove from DB
    $stmt = $conn->prepare("DELETE FROM resume_uploads WHERE folder_name = ?");
    $stmt->bind_param("s", $folder);
    $stmt->execute();
}

// Fetch uploaded folders
$result = mysqli_query($conn, "SELECT * FROM resume_uploads ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Resume Upload</title>
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
            <h2 class="mb-4">Upload HTML/CSS Resume ZIP Files</h2>

            <!-- Upload Form -->
            <form method="POST" enctype="multipart/form-data" class="mb-4">
              <div class="form-group">
                <label>Select ZIP files (single or multiple):</label>
                <input type="file" name="resume_zip[]" multiple class="form-control" accept=".zip" required>
              </div>
              <button type="submit" name="upload" class="btn btn-success">Upload & Extract</button>
            </form>

            <!-- Uploaded Directory List -->
            <h4 class="mt-5">Uploaded Resume Folders</h4>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th>ID</th>
                    <th>Folder Name</th>
                    <th>Original Filename</th>
                    <th>Uploaded At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                      <td><?= $row['id'] ?></td>
                      <td><?= $row['folder_name'] ?></td>
                      <td><?= $row['original_filename'] ?></td>
                      <td><?= $row['uploaded_at'] ?></td>
                      <td>
                        <a href="<?= $targetDir . $row['folder_name'] ?>" target="_blank" class="btn btn-info btn-sm">Open Folder</a>
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
