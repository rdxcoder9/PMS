<?php
include './partials/_session.php';
include './partials/db.php';
include './partials/head.php';

// Fetch uploaded Word resumes with preview images
$result = mysqli_query($conn, "SELECT * FROM word_resume_uploads ORDER BY uploaded_at DESC");
$basePath = "./uploads/word_resumes/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Resume Templates</title>
</head>
<body>
  <div class="container-scroller">
    <?php include './partials/_navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include './partials/_sidebar.php'; ?>

      <div class="main-panel">
        <div class="content-wrapper">
          <h2 class="mb-4 text-center">Choose Your Resume Template</h2>
          <div class="row row-cols-1 row-cols-md-3 g-4">

            <?php while ($row = mysqli_fetch_assoc($result)) {
              $folder = $row['folder_name'];
              $wordFile = $row['original_filename'];
              $imageFile = $row['preview_image'];

              $wordPath = $basePath . $folder . "/" . $wordFile;
              $imagePath = $basePath . $folder . "/" . $imageFile;
            ?>
              <div class="col">
                <div class="card h-100 shadow-sm">
                  <img src="<?= htmlspecialchars($imagePath) ?>" class="card-img-top" alt="Resume Preview">
                  <div class="card-body text-center">
                    <h5 class="card-title"><?= htmlspecialchars($folder) ?></h5>
                    <a href="<?= htmlspecialchars($wordPath) ?>" class="btn btn-primary btn-sm m-1" download>Download Word</a>
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
