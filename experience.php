<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM experience WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$experience_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $experience_data[] = $row;
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
                    <h4 class="card-title">Experience</h4>
                    <hr>
                    <form id="mainForm" class="forms-sample" action="save_experience.php" method="POST">
  <div id="experienceContainer">
    <?php if (count($experience_data) > 0): ?>
      <?php foreach ($experience_data as $index => $exp): ?>
        <div class="education-section">
          <div class="d-flex justify-content-between align-items-center">
            <div class="education-heading">Experience-<?php echo $index + 1; ?></div>
            <button type="submit" name="delete" value="<?php echo $exp['id']; ?>" class="btn btn-sm btn-danger">Delete</button>
          </div>
          <hr>
          <input type="hidden" name="exp_id[]" value="<?php echo $exp['id']; ?>">

          <div class="form-group mb-3">
            <label>Company Name</label>
            <input type="text" class="form-control" name="companyName[]" value="<?php echo htmlspecialchars($exp['company_name']); ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Job Title</label>
            <input type="text" class="form-control" name="jobTitle[]" value="<?php echo htmlspecialchars($exp['job_title']); ?>" required>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>Start Date</label>
              <input type="date" class="form-control" name="startDate[]" value="<?php echo $exp['start_date']; ?>" required>
            </div>
            <div class="col-md-6">
              <label>End Date</label>
              <input type="date" class="form-control" name="endDate[]" value="<?php echo $exp['end_date']; ?>" required>
            </div>
          </div>

          <div class="form-group mb-3">
            <label>Description</label>
            <textarea class="form-control" name="jobDescription[]" rows="4" required><?php echo htmlspecialchars($exp['job_description']); ?></textarea>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <!-- Empty form for new entry -->
      <div class="education-section">
        <div class="d-flex justify-content-between align-items-center">
          <div class="education-heading">Experience-1</div>
        </div>
        <hr>
        <input type="hidden" name="exp_id[]" value="">

        <div class="form-group mb-3">
          <label>Company Name</label>
          <input type="text" class="form-control" name="companyName[]" required>
        </div>

        <div class="form-group mb-3">
          <label>Job Title</label>
          <input type="text" class="form-control" name="jobTitle[]" required>
        </div>

        
<div class="row mb-3">
  <div class="col-md-6">
    <label>Start Date</label>
    <input type="date" class="form-control" name="startDate[]" required>
  </div>
  <div class="col-md-6">
    <label>End Date</label>
    <input type="date" class="form-control end-date" name="endDate[]" required>
    <div class="form-check mt-2">
      <input class="form-check-input current-checkbox" type="checkbox">
      <label class="form-check-label">Currently working here</label>
    </div>
  </div>
</div>


        <div class="form-group mb-3">
          <label>Description</label>
          <textarea class="form-control" name="jobDescription[]" rows="4" required></textarea>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <button type="button" onclick="addExperience()" class="btn btn-gradient-primary me-2">Add Experience</button>

  <?php if (count($experience_data) > 0): ?>
    <button type="submit" name="save" class="btn btn-gradient-primary me-2">Update</button>
  <?php else: ?>
    <button type="submit" name="save" class="btn btn-gradient-primary me-2">Submit</button>
  <?php endif; ?>
</form>


<script>
let experienceCount = <?php echo count($experience_data) ?: 1; ?>;

function addExperience() {
  experienceCount++;
  const container = document.getElementById('experienceContainer');
  const newSection = document.createElement('div');
  newSection.classList.add('education-section');

  newSection.innerHTML = `
    <div class="d-flex justify-content-between align-items-center">
      <div class="education-heading">Experience-${experienceCount}</div>
      <button type="button" class="btn btn-sm btn-outline-danger remove-btn">Remove</button>
    </div>
    <hr>
    <input type="hidden" name="exp_id[]" value="">
    <div class="form-group mb-3">
      <label>Company Name</label>
      <input type="text" class="form-control" name="companyName[]" required>
    </div>
    <div class="form-group mb-3">
      <label>Job Title</label>
      <input type="text" class="form-control" name="jobTitle[]" required>
    </div>
    <div class="row mb-3">
      <div class="col-md-6">
        <label>Start Date</label>
        <input type="date" class="form-control" name="startDate[]" required>
      </div>
      <div class="col-md-6">
        <label>End Date</label>
        <div class="end-date-wrapper">
          <input type="date" class="form-control end-date" name="endDate[]" required>
        </div>
        <div class="form-check mt-2">
          <input class="form-check-input current-checkbox" type="checkbox">
          <label class="form-check-label">Currently working here</label>
        </div>
      </div>
    </div>
    <div class="form-group mb-3">
      <label>Description</label>
      <textarea class="form-control" name="jobDescription[]" rows="4" required></textarea>
    </div>
  `;

  container.appendChild(newSection);
  updateExperienceHeadings();
}

// Remove dynamically added experience blocks
document.addEventListener('click', function (e) {
  if (e.target.classList.contains('remove-btn')) {
    e.target.closest('.education-section').remove();
    updateExperienceHeadings();
  }
});

// Handle "Currently working here" checkbox
document.addEventListener('change', function (e) {
  if (e.target.classList.contains('current-checkbox')) {
    const wrapper = e.target.closest('.col-md-6');
    const endDateInput = wrapper.querySelector('.end-date');
    const endDateWrapper = wrapper.querySelector('.end-date-wrapper');

    if (e.target.checked) {
      endDateInput.value = '';
      endDateInput.disabled = true;
      endDateInput.removeAttribute('required');
      endDateWrapper.style.display = 'none';
    } else {
      endDateInput.disabled = false;
      endDateInput.setAttribute('required', 'required');
      endDateWrapper.style.display = 'block';
    }
  }
});

// Update headings after add/remove
function updateExperienceHeadings() {
  const sections = document.querySelectorAll('.education-section');
  sections.forEach((section, index) => {
    const heading = section.querySelector('.education-heading');
    if (heading) {
      heading.textContent = `Experience-${index + 1}`;
    }
  });
}
</script>







                  </div>
                </div>
              </div>

          </div>
          <!-- content-wrapper ends -->










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