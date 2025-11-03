<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];
$certifications_data = [];

$query = "SELECT * FROM certifications WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $certifications_data[] = $row;
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
                    
                  <form class="forms-sample mb-5" action="save_certifications.php" method="POST">
  <h4>Certifications</h4>
  <div id="certificationContainer">
    <?php if (count($certifications_data) > 0): ?>
      <?php foreach ($certifications_data as $index => $cert): ?>
        <div class="certification-section">
          <div class="d-flex justify-content-between align-items-center">
            <div class="certification-heading">Certification-<?php echo $index + 1; ?></div>
            <button type="submit" name="delete" value="<?php echo $cert['id']; ?>" class="btn btn-sm btn-danger">Delete</button>
          </div>
          <hr>
          <input type="hidden" name="certification_id[]" value="<?php echo $cert['id']; ?>">

          <div class="form-group mb-3">
            <label>Certification Name</label>
            <input type="text" class="form-control" name="certificationName[]" value="<?php echo htmlspecialchars($cert['certification_name']); ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Issuing Organization</label>
            <input type="text" class="form-control" name="issuingOrg[]" value="<?php echo htmlspecialchars($cert['issuing_organization']); ?>" required>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>Issue Date</label>
              <input type="date" class="form-control" name="issueDate[]" value="<?php echo $cert['issue_date']; ?>" required>
            </div>
            <div class="col-md-6">
              <label>Expiry Date</label>
              <input type="date" class="form-control" name="expiryDate[]" value="<?php echo $cert['expiry_date']; ?>">
            </div>
          </div>

          <div class="form-group mb-3">
            <label>Credential URL (Optional)</label>
            <input type="url" class="form-control" name="credentialUrl[]" value="<?php echo htmlspecialchars($cert['credential_url']); ?>">
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="certification-section">
        <div class="d-flex justify-content-between align-items-center">
          <div class="certification-heading">Certification-1</div>
        </div>
        <hr>
        <input type="hidden" name="certification_id[]" value="">

        <div class="form-group mb-3">
          <label>Certification Name</label>
          <input type="text" class="form-control" name="certificationName[]" required>
        </div>

        <div class="form-group mb-3">
          <label>Issuing Organization</label>
          <input type="text" class="form-control" name="issuingOrg[]" required>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Issue Date</label>
            <input type="date" class="form-control" name="issueDate[]" required>
          </div>
          <div class="col-md-6">
            <label>Expiry Date</label>
            <input type="date" class="form-control" name="expiryDate[]">
          </div>
        </div>

        <div class="form-group mb-3">
          <label>Credential URL (Optional)</label>
          <input type="url" class="form-control" name="credentialUrl[]">
        </div>
      </div>
    <?php endif; ?>
  </div>

  <button type="button" class="btn btn-gradient-primary me-2" onclick="addCertification()">Add Certification</button>

  <?php if (count($certifications_data) > 0): ?>
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
let certificationCount = <?php echo count($certifications_data) ?: 1; ?>;

function addCertification() {
  certificationCount++;
  const container = document.getElementById('certificationContainer');
  const newSection = document.createElement('div');
  newSection.classList.add('certification-section');

  newSection.innerHTML = `
    <div class="d-flex justify-content-between align-items-center">
      <div class="certification-heading">Certification-${certificationCount}</div>
      <button type="button" class="btn btn-sm btn-warning" onclick="removeCertification(this)">Remove</button>
    </div>
    <hr>
    <input type="hidden" name="certification_id[]" value="">
    <div class="form-group mb-3">
      <label>Certification Name</label>
      <input type="text" class="form-control" name="certificationName[]" required>
    </div>
    <div class="form-group mb-3">
      <label>Issuing Organization</label>
      <input type="text" class="form-control" name="issuingOrg[]" required>
    </div>
    <div class="row mb-3">
      <div class="col-md-6">
        <label>Issue Date</label>
        <input type="date" class="form-control" name="issueDate[]" required>
      </div>
      <div class="col-md-6">
        <label>Expiry Date</label>
        <input type="date" class="form-control" name="expiryDate[]">
      </div>
    </div>
    <div class="form-group mb-3">
      <label>Credential URL (Optional)</label>
      <input type="url" class="form-control" name="credentialUrl[]">
    </div>
  `;

  container.appendChild(newSection);
  updateCertificationHeadings();
}

function removeCertification(button) {
  button.closest('.certification-section').remove();
  updateCertificationHeadings();
}

function updateCertificationHeadings() {
  const sections = document.querySelectorAll('.certification-section');
  sections.forEach((section, index) => {
    const heading = section.querySelector('.certification-heading');
    if (heading) {
      heading.textContent = `Certification-${index + 1}`;
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