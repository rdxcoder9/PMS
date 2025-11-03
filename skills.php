
<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM skills WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$skills_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $skills_data[] = $row;
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
                    <h4 class="card-title">Skills</h4>
                    <hr>
                    
<form id="skillsForm" class="forms-sample" action="save_skills.php" method="POST">
  <div id="skillsContainer">
    <?php if (count($skills_data) > 0): ?>
      <?php foreach ($skills_data as $index => $skill): ?>
        <div class="skill-section">
          <div class="d-flex justify-content-between align-items-center">
            <div class="skill-heading">Skill-<?php echo $index + 1; ?></div>
            <button type="submit" name="delete" value="<?php echo $skill['id']; ?>" class="btn btn-sm btn-danger">Delete</button>
          </div>
          <hr>
          <input type="hidden" name="skill_id[]" value="<?php echo $skill['id']; ?>">

          <div class="form-group mb-3">
            <label>Skill Name</label>
            <input type="text" class="form-control" name="skillName[]" value="<?php echo htmlspecialchars($skill['skill_name']); ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Skill Level</label>
            <select class="form-control" name="skillLevel[]" required>
              <option value="">Select Level</option>
              <option value="Beginner" <?php echo $skill['skill_level'] == 'Beginner' ? 'selected' : ''; ?>>Beginner</option>
              <option value="Intermediate" <?php echo $skill['skill_level'] == 'Intermediate' ? 'selected' : ''; ?>>Intermediate</option>
              <option value="Advanced" <?php echo $skill['skill_level'] == 'Advanced' ? 'selected' : ''; ?>>Advanced</option>
              <option value="Expert" <?php echo $skill['skill_level'] == 'Expert' ? 'selected' : ''; ?>>Expert</option>
            </select>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <!-- Empty form for new entry -->
      <div class="skill-section">
        <div class="d-flex justify-content-between align-items-center">
          <div class="skill-heading">Skill-1</div>
        </div>
        <hr>
        <input type="hidden" name="skill_id[]" value="">

        <div class="form-group mb-3">
          <label>Skill Name</label>
          <input type="text" class="form-control" name="skillName[]" required>
        </div>

        <div class="form-group mb-3">
          <label>Skill Level</label>
          <select class="form-control" name="skillLevel[]" required>
            <option value="">Select Level</option>
            <option value="Beginner">Beginner</option>
            <option value="Intermediate">Intermediate</option>
            <option value="Advanced">Advanced</option>
            <option value="Expert">Expert</option>
          </select>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <button type="button" onclick="addSkill()" class="btn btn-gradient-primary me-2">Add Skill</button>

  <?php if (count($skills_data) > 0): ?>
    <button type="submit" name="save" class="btn btn-gradient-primary me-2">Update</button>
  <?php else: ?>
    <button type="submit" name="save" class="btn btn-gradient-primary me-2">Submit</button>
  <?php endif; ?>
</form>




<script>
let skillCount = <?php echo count($skills_data) ?: 1; ?>;

function addSkill() {
  skillCount++;
  const container = document.getElementById('skillsContainer');
  const newSection = document.createElement('div');
  newSection.classList.add('skill-section');

  newSection.innerHTML = `
    <div class="d-flex justify-content-between align-items-center">
      <div class="skill-heading">Skill-${skillCount}</div>
      <button type="button" class="btn btn-sm btn-warning" onclick="removeSkill(this)">Remove</button>
    </div>
    <hr>
    <input type="hidden" name="skill_id[]" value="">
    <div class="form-group mb-3">
      <label>Skill Name</label>
      <input type="text" class="form-control" name="skillName[]" required>
    </div>
    <div class="form-group mb-3">
      <label>Skill Level</label>
      <select class="form-control" name="skillLevel[]" required>
        <option value="">Select Level</option>
        <option value="Beginner">Beginner</option>
        <option value="Intermediate">Intermediate</option>
        <option value="Advanced">Advanced</option>
        <option value="Expert">Expert</option>
      </select>
    </div>
  `;

  container.appendChild(newSection);
  updateSkillHeadings();
}

function removeSkill(button) {
  button.closest('.skill-section').remove();
  updateSkillHeadings();
}


document.addEventListener('click', function (e) {
  if (e.target.classList.contains('remove-btn')) {
    e.target.closest('.skill-section').remove();
    updateSkillHeadings();
  }
});

function updateSkillHeadings() {
  const sections = document.querySelectorAll('.skill-section');
  sections.forEach((section, index) => {
    const heading = section.querySelector('.skill-heading');
    if (heading) {
      heading.textContent = `Skill-${index + 1}`;
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