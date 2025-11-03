<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];
$projects_data = [];

$query = "SELECT * FROM projects WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $projects_data[] = $row;
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
                    
<form class="forms-sample mb-5" action="save_projects.php" method="POST">
  <h4>Projects</h4>
  <div id="projectContainer">
    <?php if (count($projects_data) > 0): ?>
      <?php foreach ($projects_data as $index => $project): ?>
        <div class="project-section">
          <div class="d-flex justify-content-between align-items-center">
            <div class="project-heading">Project-<?php echo $index + 1; ?></div>
            <button type="submit" name="delete" value="<?php echo $project['id']; ?>" class="btn btn-sm btn-danger">Delete</button>
          </div>
          <hr>
          <input type="hidden" name="project_id[]" value="<?php echo $project['id']; ?>">

          <div class="form-group mb-3">
            <label>Project Title</label>
            <input type="text" class="form-control" name="projectTitle[]" value="<?php echo htmlspecialchars($project['project_title']); ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Technology Used</label>
            <input type="text" class="form-control" name="technologyUsed[]" value="<?php echo htmlspecialchars($project['technology_used']); ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Description</label>
            <textarea class="form-control" name="projectDescription[]" rows="4" required><?php echo htmlspecialchars($project['project_description']); ?></textarea>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="project-section">
        <div class="d-flex justify-content-between align-items-center">
          <div class="project-heading">Project-1</div>
        </div>
        <hr>
        <input type="hidden" name="project_id[]" value="">

        <div class="form-group mb-3">
          <label>Project Title</label>
          <input type="text" class="form-control" name="projectTitle[]" required>
        </div>

        <div class="form-group mb-3">
          <label>Technology Used</label>
          <input type="text" class="form-control" name="technologyUsed[]" required>
        </div>

        <div class="form-group mb-3">
          <label>Description</label>
          <textarea class="form-control" name="projectDescription[]" rows="4" required></textarea>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <button type="button" class="btn btn-gradient-primary me-2" onclick="addProject()">Add Project</button>

  <?php if (count($projects_data) > 0): ?>
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
let projectCount = <?php echo count($projects_data) ?: 1; ?>;

function addProject() {
  projectCount++;
  const container = document.getElementById('projectContainer');
  const newSection = document.createElement('div');
  newSection.classList.add('project-section');

  newSection.innerHTML = `
    <div class="d-flex justify-content-between align-items-center">
      <div class="project-heading">Project-${projectCount}</div>
      <button type="button" class="btn btn-sm btn-warning" onclick="removeProject(this)">Remove</button>
    </div>
    <hr>
    <input type="hidden" name="project_id[]" value="">
    <div class="form-group mb-3">
      <label>Project Title</label>
      <input type="text" class="form-control" name="projectTitle[]" required>
    </div>
    <div class="form-group mb-3">
      <label>Technology Used</label>
      <input type="text" class="form-control" name="technologyUsed[]" required>
    </div>
    <div class="form-group mb-3">
      <label>Description</label>
      <textarea class="form-control" name="projectDescription[]" rows="4" required></textarea>
    </div>
  `;

  container.appendChild(newSection);
  updateProjectHeadings();
}

function removeProject(button) {
  button.closest('.project-section').remove();
  updateProjectHeadings();
}

function updateProjectHeadings() {
  const sections = document.querySelectorAll('.project-section');
  sections.forEach((section, index) => {
    const heading = section.querySelector('.project-heading');
    if (heading) {
      heading.textContent = `Project-${index + 1}`;
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