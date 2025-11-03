<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM education WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$education_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $education_data[] = $row;
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
                    <h4 class="card-title">Education Details</h4>
                    <hr>
  <form id="mainForm" class="forms-sample" action="save_education.php" method="POST">
  <div id="educationContainer">
    <?php if (count($education_data) > 0): ?>
      <?php foreach ($education_data as $index => $edu): ?>
        <div class="education-section">
  <div class="d-flex justify-content-between align-items-center">
    <div class="education-heading">Education-<?php echo $index + 1; ?></div>
    <button type="submit" name="delete" value="<?php echo $edu['id']; ?>" class="btn btn-sm btn-danger">Delete</button>
  </div>
  <hr>

          <input type="hidden" name="edu_id[]" value="<?php echo $edu['id']; ?>">

          <div class="form-group">
            <label>Course / Degree</label>
            <input type="text" class="form-control" name="courseDegree[]" value="<?php echo htmlspecialchars($edu['course_degree']); ?>" required>
          </div>

          <div class="form-group">
            <label>School / University</label>
            <input type="text" class="form-control" name="schoolUniversity[]" value="<?php echo htmlspecialchars($edu['school_university']); ?>" required>
          </div>

          <div class="form-group">
            <label>Grade / Score</label>
            <input type="text" class="form-control" name="gradeScore[]" value="<?php echo htmlspecialchars($edu['grade_score']); ?>" required>
          </div>

          <div class="form-group">
            <label>Year</label>
            <input type="text" class="form-control" name="year[]" value="<?php echo htmlspecialchars($edu['year']); ?>" required>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <!-- Empty form for new entry -->
      <div class="education-section">
  <div class="d-flex justify-content-between align-items-center">
    <div class="education-heading">Education-<?php echo $index + 1; ?></div>
    <button type="submit" name="delete" value="<?php echo $edu['id']; ?>" class="btn btn-sm btn-danger">Delete</button>
  </div>
  <hr>

        <input type="hidden" name="edu_id[]" value="">

        <div class="form-group">
          <label>Course / Degree</label>
          <input type="text" class="form-control" name="courseDegree[]" required>
        </div>

        <div class="form-group">
          <label>School / University</label>
          <input type="text" class="form-control" name="schoolUniversity[]" required>
        </div>

        <div class="form-group">
          <label>Grade / Score</label>
          <input type="text" class="form-control" name="gradeScore[]" required>
        </div>

        <div class="form-group">
          <label>Year</label>
          <input type="text" class="form-control" name="year[]" required>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <button type="button" onclick="addEducation()" class="btn btn-gradient-primary me-2">Add Education</button>
  <?php if (count($education_data) > 0): ?>
  <button type="submit" name="save" class="btn btn-gradient-primary me-2">Update</button>
<?php else: ?>
  <button type="submit" name="save" class="btn btn-gradient-primary me-2">Submit</button>
<?php endif; ?>

</form>


 <script>
let educationCount = <?php echo count($education_data) ?: 1; ?>;

function addEducation() {
  const container = document.getElementById('educationContainer');
  const newSection = document.createElement('div');
  newSection.classList.add('education-section');

  newSection.innerHTML = `
    <div class="d-flex justify-content-between align-items-center">
      <div class="education-heading">Education-${educationCount + 1}</div>
      <button type="button" class="btn btn-sm btn-warning" onclick="removeEducation(this)">Remove</button>
    </div>
    <hr>
    <input type="hidden" name="edu_id[]" value="">
    <div class="form-group">
      <label>Course / Degree</label>
      <input type="text" class="form-control" name="courseDegree[]" required>
    </div>
    <div class="form-group">
      <label>School / University</label>
      <input type="text" class="form-control" name="schoolUniversity[]" required>
    </div>
    <div class="form-group">
      <label>Grade / Score</label>
      <input type="text" class="form-control" name="gradeScore[]" required>
    </div>
    <div class="form-group">
      <label>Year</label>
      <input type="number" class="form-control" name="year[]" min="1900" max="2099" required>
    </div>
  `;

  container.appendChild(newSection);
  updateEducationHeadings();
}

function removeEducation(button) {
  const section = button.closest('.education-section');
  section.remove();
  updateEducationHeadings();
}

function updateEducationHeadings() {
  const sections = document.querySelectorAll('.education-section');
  sections.forEach((section, index) => {
    const heading = section.querySelector('.education-heading');
    if (heading) {
      heading.textContent = `Education-${index + 1}`;
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