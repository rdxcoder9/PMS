<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];
$publications_data = [];

$query = "SELECT * FROM publications WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $publications_data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PMS Dashboard</title>
    <?php
    include './partials/head.php'
    ?>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.php -->
      <?php
        include './partials/_navbar.php'
      ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.php -->
        <?php
        include './partials/_sidebar.php';
        ?>
        <!-- partial -->







        <div class="main-panel">
          <div class="content-wrapper">
          <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    
                  <form class="forms-sample mb-5" action="save_publications.php" method="POST">
  <h4>Publications / Research <small class="text-muted">(if applicable)</small></h4>
  <div id="publicationContainer">
    <?php if (count($publications_data) > 0): ?>
      <?php foreach ($publications_data as $index => $pub): ?>
        <div class="publication-section">
          <div class="d-flex justify-content-between align-items-center">
            <div class="publication-heading">Publication-<?php echo $index + 1; ?></div>
            <button type="submit" name="delete" value="<?php echo $pub['id']; ?>" class="btn btn-sm btn-danger">Delete</button>
          </div>
          <hr>
          <input type="hidden" name="publication_id[]" value="<?php echo $pub['id']; ?>">

          <div class="form-group mb-3">
            <label>Title of Publication / Research</label>
            <input type="text" class="form-control" name="publicationTitle[]" value="<?php echo htmlspecialchars($pub['title']); ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Published In / Journal</label>
            <input type="text" class="form-control" name="journalName[]" value="<?php echo htmlspecialchars($pub['published_in']); ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Publication Date</label>
            <input type="date" class="form-control" name="publicationDate[]" value="<?php echo $pub['publication_date']; ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Link / DOI</label>
            <input type="url" class="form-control" name="publicationLink[]" value="<?php echo htmlspecialchars($pub['link_doi']); ?>">
          </div>

          <div class="form-group mb-3">
            <label>Description / Abstract</label>
            <textarea class="form-control" name="publicationDescription[]" rows="4" required><?php echo htmlspecialchars($pub['abstract']); ?></textarea>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="publication-section">
        <div class="d-flex justify-content-between align-items-center">
          <div class="publication-heading">Publication-1</div>
        </div>
        <hr>
        <input type="hidden" name="publication_id[]" value="">

        <div class="form-group mb-3">
          <label>Title of Publication / Research</label>
          <input type="text" class="form-control" name="publicationTitle[]" required>
        </div>

        <div class="form-group mb-3">
          <label>Published In / Journal</label>
          <input type="text" class="form-control" name="journalName[]" required>
        </div>

        <div class="form-group mb-3">
          <label>Publication Date</label>
          <input type="date" class="form-control" name="publicationDate[]" required>
        </div>

        <div class="form-group mb-3">
          <label>Link / DOI</label>
          <input type="url" class="form-control" name="publicationLink[]" >
        </div>

        <div class="form-group mb-3">
          <label>Description / Abstract</label>
          <textarea class="form-control" name="publicationDescription[]" rows="4" required></textarea>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <button type="button" class="btn btn-gradient-primary me-2" onclick="addPublication()">Add Publication</button>

  <?php if (count($publications_data) > 0): ?>
    <button type="submit" name="save" class="btn btn-gradient-primary me-2">Update</button>
  <?php else: ?>
    <button type="submit" name="save" class="btn btn-gradient-primary me-2">Submit</button>
  <?php endif; ?>
</form>










                  </div>
                </div>
              </div>

          </div>
          <!-- content-wrapper ends -->

          <script>
let publicationCount = <?php echo count($publications_data) ?: 1; ?>;

function addPublication() {
  publicationCount++;
  const container = document.getElementById('publicationContainer');
  const newSection = document.createElement('div');
  newSection.classList.add('publication-section');

  newSection.innerHTML = `
    <div class="d-flex justify-content-between align-items-center">
      <div class="publication-heading">Publication-${publicationCount}</div>
      <button type="button" class="btn btn-sm btn-warning" onclick="removePublication(this)">Remove</button>
    </div>
    <hr>
    <input type="hidden" name="publication_id[]" value="">
    <div class="form-group mb-3">
      <label>Title of Publication / Research</label>
      <input type="text" class="form-control" name="publicationTitle[]" required>
    </div>
    <div class="form-group mb-3">
      <label>Published In / Journal</label>
      <input type="text" class="form-control" name="journalName[]" required>
    </div>
    <div class="form-group mb-3">
      <label>Publication Date</label>
      <input type="date" class="form-control" name="publicationDate[]" required>
    </div>
    <div class="form-group mb-3">
      <label>Link / DOI</label>
      <input type="url" class="form-control" name="publicationLink[]" >
    </div>
    <div class="form-group mb-3">
      <label>Description / Abstract</label>
      <textarea class="form-control" name="publicationDescription[]" rows="4" required></textarea>
    </div>
  `;

  container.appendChild(newSection);
  updatePublicationHeadings();
}

function removePublication(button) {
  button.closest('.publication-section').remove();
  updatePublicationHeadings();
}

function updatePublicationHeadings() {
  const sections = document.querySelectorAll('.publication-section');
  sections.forEach((section, index) => {
    const heading = section.querySelector('.publication-heading');
    if (heading) {
      heading.textContent = `Publication-${index + 1}`;
    }
  });
}
</script>












          <!-- partial:../../partials/_footer.php -->
          <?php
            include './partials/_footer.php';
          ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <?php
     include './partials/scripts.php';
    ?>
  </body>
</html>