<?php
include './partials/_session.php';
include './partials/head.php';
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

            <!-- Template Card 1 -->
            <div class="col">
              <div class="card h-100">
                <img src="./templates/tem1.jpeg" class="card-img-top" alt="Professional Resume">
                <div class="card-body">
                  <h5 class="card-title">Professional Resume</h5>
                  <a href="template1.docx" class="btn btn-primary btn-sm">Download Word</a>
                  <a href="template1.pdf" class="btn btn-danger btn-sm">Download PDF</a>
                </div>
              </div>
            </div>

            <!-- Template Card 2 -->
            <div class="col">
              <div class="card h-100">
                <img src="./templates/temp2.jpeg" class="card-img-top" alt="Creative Resume">
                <div class="card-body">
                  <h5 class="card-title">Creative Resume</h5>
                  <a href="template2.docx" class="btn btn-primary btn-sm">Download Word</a>
                  <a href="template2.pdf" class="btn btn-danger btn-sm">Download PDF</a>
                </div>
              </div>
            </div>

            <!-- Template Card 3 -->
            <div class="col">
              <div class="card h-100">
                <img src="./templates/temp3.jpeg" class="card-img-top" alt="Academic Resume">
                <div class="card-body">
                  <h5 class="card-title">Academic Resume</h5>
                  <a href="template3.docx" class="btn btn-primary btn-sm">Download Word</a>
                  <a href="template3.pdf" class="btn btn-danger btn-sm">Download PDF</a>
                </div>
              </div>
            </div>

          </div>
        </div>

        <?php include './partials/_footer.php'; ?>
      </div>
    </div>
  </div>
  <?php include './partials/scripts.php'; ?>
</body>
</html>
