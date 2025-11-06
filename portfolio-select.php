<?php
include './partials/_session.php';
include './partials/db.php';
include './partials/head.php';

$result = mysqli_query($conn, "SELECT * FROM resume_uploads ORDER BY uploaded_at DESC");
$basePath = "./uploads/resumes/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Resume Templates</title>
  <style>
    .template-card {
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    .template-card img {
      height: 220px;
      object-fit: cover;
      object-position: top center;
    }
    .template-card .card-body {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
  </style>
</head>
<body>
  <div class="container-scroller">
    <?php include './partials/_navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include './partials/_sidebar.php'; ?>

      <div class="main-panel">
        <div class="content-wrapper">
          <h2 class="mb-4 text-center">Portfolio Templates</h2>
          <hr>
          <div class="row row-cols-1 row-cols-md-3 g-4">

            <?php while ($row = mysqli_fetch_assoc($result)) {
              $folder = $row['folder_name'];
              $templateSlug = explode("_", $folder)[0];
              $imagePath = $basePath . $folder . "/" . $templateSlug . ".png";
              $folderUrl = $basePath . $folder . "/";
            ?>
              <div class="col">
                <div class="card template-card shadow-sm">
                  <img src="<?= htmlspecialchars($imagePath) ?>" class="card-img-top" alt="Template Preview">
                  <div class="card-body text-center">
                    <h5 class="card-title"><?= htmlspecialchars($templateSlug) ?></h5>
                    <a href="<?= htmlspecialchars($folderUrl) ?>" target="_blank" class="btn btn-info btn-sm">Open Template Folder</a>
                  </div>
                </div>
              </div>
            <?php } ?>

          </div>
        </div>

        <?php include './partials/_footer.php'; ?>
      </div>
    </div>
  </div>
  <?php include './partials/scripts.php'; ?>
</body>
</html>
