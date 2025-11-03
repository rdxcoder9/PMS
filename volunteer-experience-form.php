<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];
$volunteer_data = [];

$query = "SELECT * FROM experience WHERE user_id = $user_id AND job_title = 'Volunteer'";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $volunteer_data[] = $row;
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
                    
                  <form class="forms-sample mb-5" action="save_volunteer.php" method="POST">
  <h4>Volunteer Experience <small class="text-muted">(Optional)</small></h4>
  <div id="volunteerContainer">
    <?php if (count($volunteer_data) > 0): ?>
      <?php foreach ($volunteer_data as $index => $vol): ?>
        <div class="volunteer-section">
          <div class="d-flex justify-content-between align-items-center">
            <div class="volunteer-heading">Volunteer-<?php echo $index + 1; ?></div>
            <button type="submit" name="delete" value="<?php echo $vol['id']; ?>" class="btn btn-sm btn-danger">Delete</button>
          </div>
          <hr>
          <input type="hidden" name="volunteer_id[]" value="<?php echo $vol['id']; ?>">

          <div class="form-group mb-3">
            <label>Organization Name</label>
            <input type="text" class="form-control" name="organizationName[]" value="<?php echo htmlspecialchars($vol['company_name']); ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Role / Position</label>
            <input type="text" class="form-control" name="volunteerRole[]" value="<?php echo htmlspecialchars($vol['job_title']); ?>" required>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>Start Date</label>
              <input type="date" class="form-control" name="startDate[]" value="<?php echo $vol['start_date']; ?>" required>
            </div>
            <div class="col-md-6">
              <label>End Date</label>
              <input type="date" class="form-control" name="endDate[]" value="<?php echo $vol['end_date']; ?>">
            </div>
          </div>

          <div class="form-group mb-3">
            <label>Description</label>
            <textarea class="form-control" name="volunteerDescription[]" rows="4" required><?php echo htmlspecialchars($vol['job_description']); ?></textarea>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="volunteer-section">
        <div class="d-flex justify-content-between align-items-center">
          <div class="volunteer-heading">Volunteer-1</div>
        </div>
        <hr>
        <input type="hidden" name="volunteer_id[]" value="">

        <div class="form-group mb-3">
          <label>Organization Name</label>
          <input type="text" class="form-control" name="organizationName[]" required>
        </div>

        <div class="form-group mb-3">
          <label>Role / Position</label>
          <input type="text" class="form-control" name="volunteerRole[]" required>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Start Date</label>
            <input type="date" class="form-control" name="startDate[]" required>
          </div>
          <div class="col-md-6">
            <label>End Date</label>
            <input type="date" class="form-control" name="endDate[]">
          </div>
        </div>

        <div class="form-group mb-3">
          <label>Description</label>
          <textarea class="form-control" name="volunteerDescription[]" rows="4" required></textarea>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <button type="button" class="btn btn-gradient-primary me-2" onclick="addVolunteer()">Add Volunteer Experience</button>

  <?php if (count($volunteer_data) > 0): ?>
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
let volunteerCount = <?php echo count($volunteer_data) ?: 1; ?>;

function addVolunteer() {
  volunteerCount++;
  const container = document.getElementById('volunteerContainer');
  const newSection = document.createElement('div');
  newSection.classList.add('volunteer-section');

  newSection.innerHTML = `
    <div class="d-flex justify-content-between align-items-center">
      <div class="volunteer-heading">Volunteer-${volunteerCount}</div>
      <button type="button" class="btn btn-sm btn-warning" onclick="removeVolunteer(this)">Remove</button>
    </div>
    <hr>
    <input type="hidden" name="volunteer_id[]" value="">
    <div class="form-group mb-3">
      <label>Organization Name</label>
      <input type="text" class="form-control" name="organizationName[]" required>
    </div>
    <div class="form-group mb-3">
      <label>Role / Position</label>
      <input type="text" class="form-control" name="volunteerRole[]" required>
    </div>
    <div class="row mb-3">
      <div class="col-md-6">
        <label>Start Date</label>
        <input type="date" class="form-control" name="startDate[]" required>
      </div>
      <div class="col-md-6">
        <label>End Date</label>
        <input type="date" class="form-control" name="endDate[]">
      </div>
    </div>
    <div class="form-group mb-3">
      <label>Description</label>
      <textarea class="form-control" name="volunteerDescription[]" rows="4" required></textarea>
    </div>
  `;

  container.appendChild(newSection);
  updateVolunteerHeadings();
}

function removeVolunteer(button) {
  button.closest('.volunteer-section').remove();
  updateVolunteerHeadings();
}

function updateVolunteerHeadings() {
  const sections = document.querySelectorAll('.volunteer-section');
  sections.forEach((section, index) => {
    const heading = section.querySelector('.volunteer-heading');
    if (heading) {
      heading.textContent = `Volunteer-${index + 1}`;
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