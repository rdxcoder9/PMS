<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];
$awards_data = [];

$query = "SELECT * FROM awards WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $awards_data[] = $row;
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
                    
                  <form class="forms-sample mb-5" action="save_awards.php" method="POST">
  <h4>Awards & Achievements</h4>
  <div id="awardContainer">
    <?php if (count($awards_data) > 0): ?>
      <?php foreach ($awards_data as $index => $award): ?>
        <div class="award-section">
          <div class="d-flex justify-content-between align-items-center">
            <div class="award-heading">Award-<?php echo $index + 1; ?></div>
            <button type="submit" name="delete" value="<?php echo $award['id']; ?>" class="btn btn-sm btn-danger">Delete</button>
          </div>
          <hr>
          <input type="hidden" name="award_id[]" value="<?php echo $award['id']; ?>">

          <div class="form-group mb-3">
            <label>Award Title</label>
            <input type="text" class="form-control" name="awardTitle[]" value="<?php echo htmlspecialchars($award['award_title']); ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Presented By</label>
            <input type="text" class="form-control" name="presentedBy[]" value="<?php echo htmlspecialchars($award['presented_by']); ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Date Received</label>
            <input type="date" class="form-control" name="awardDate[]" value="<?php echo $award['date_received']; ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Description</label>
            <textarea class="form-control" name="awardDescription[]" rows="4" required><?php echo htmlspecialchars($award['description']); ?></textarea>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="award-section">
        <div class="d-flex justify-content-between align-items-center">
          <div class="award-heading">Award-1</div>
        </div>
        <hr>
        <input type="hidden" name="award_id[]" value="">

        <div class="form-group mb-3">
          <label>Award Title</label>
          <input type="text" class="form-control" name="awardTitle[]" required>
        </div>

        <div class="form-group mb-3">
          <label>Presented By</label>
          <input type="text" class="form-control" name="presentedBy[]" required>
        </div>

        <div class="form-group mb-3">
          <label>Date Received</label>
          <input type="date" class="form-control" name="awardDate[]" required>
        </div>

        <div class="form-group mb-3">
          <label>Description</label>
          <textarea class="form-control" name="awardDescription[]" rows="4" required></textarea>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <button type="button" class="btn btn-gradient-primary me-2" onclick="addAward()">Add Award</button>

  <?php if (count($awards_data) > 0): ?>
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
let awardCount = <?php echo count($awards_data) ?: 1; ?>;

function addAward() {
  awardCount++;
  const container = document.getElementById('awardContainer');
  const newSection = document.createElement('div');
  newSection.classList.add('award-section');

  newSection.innerHTML = `
    <div class="d-flex justify-content-between align-items-center">
      <div class="award-heading">Award-${awardCount}</div>
      <button type="button" class="btn btn-sm btn-warning" onclick="removeAward(this)">Remove</button>
    </div>
    <hr>
    <input type="hidden" name="award_id[]" value="">
    <div class="form-group mb-3">
      <label>Award Title</label>
      <input type="text" class="form-control" name="awardTitle[]" required>
    </div>
    <div class="form-group mb-3">
      <label>Presented By</label>
      <input type="text" class="form-control" name="presentedBy[]" required>
    </div>
    <div class="form-group mb-3">
      <label>Date Received</label>
      <input type="date" class="form-control" name="awardDate[]" required>
    </div>
    <div class="form-group mb-3">
      <label>Description</label>
      <textarea class="form-control" name="awardDescription[]" rows="4" required></textarea>
    </div>
  `;

  container.appendChild(newSection);
  updateAwardHeadings();
}

function removeAward(button) {
  button.closest('.award-section').remove();
  updateAwardHeadings();
}

function updateAwardHeadings() {
  const sections = document.querySelectorAll('.award-section');
  sections.forEach((section, index) => {
    const heading = section.querySelector('.award-heading');
    if (heading) {
      heading.textContent = `Award-${index + 1}`;
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