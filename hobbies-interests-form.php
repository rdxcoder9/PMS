<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];
$hobbies_data = [];

$query = "SELECT * FROM hobbies WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $hobbies_data[] = $row;
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
                    
                  <form class="forms-sample mb-5" action="save_hobbies.php" method="POST">
  <h4>Hobbies & Interests <small class="text-muted">(Optional)</small></h4>
  <div id="hobbyContainer">
    <?php if (count($hobbies_data) > 0): ?>
      <?php foreach ($hobbies_data as $index => $hobby): ?>
        <div class="hobby-section">
          <div class="d-flex justify-content-between align-items-center">
            <div class="hobby-heading">Hobby-<?php echo $index + 1; ?></div>
            <button type="submit" name="delete" value="<?php echo $hobby['id']; ?>" class="btn btn-sm btn-danger">Delete</button>
          </div>
          <hr>
          <input type="hidden" name="hobby_id[]" value="<?php echo $hobby['id']; ?>">

          <div class="form-group mb-3">
            <label>Hobby / Interest</label>
            <input type="text" class="form-control" name="hobbyName[]" value="<?php echo htmlspecialchars($hobby['hobby_interest']); ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Description</label>
            <textarea class="form-control" name="hobbyDescription[]" rows="3" required><?php echo htmlspecialchars($hobby['description']); ?></textarea>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="hobby-section">
        <div class="d-flex justify-content-between align-items-center">
          <div class="hobby-heading">Hobby-1</div>
        </div>
        <hr>
        <input type="hidden" name="hobby_id[]" value="">

        <div class="form-group mb-3">
          <label>Hobby / Interest</label>
          <input type="text" class="form-control" name="hobbyName[]" required>
        </div>

        <div class="form-group mb-3">
          <label>Description</label>
          <textarea class="form-control" name="hobbyDescription[]" rows="3" required></textarea>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <button type="button" class="btn btn-gradient-primary me-2" onclick="addHobby()">Add Hobby</button>

  <?php if (count($hobbies_data) > 0): ?>
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
let hobbyCount = <?php echo count($hobbies_data) ?: 1; ?>;

function addHobby() {
  hobbyCount++;
  const container = document.getElementById('hobbyContainer');
  const newSection = document.createElement('div');
  newSection.classList.add('hobby-section');

  newSection.innerHTML = `
    <div class="d-flex justify-content-between align-items-center">
      <div class="hobby-heading">Hobby-${hobbyCount}</div>
      <button type="button" class="btn btn-sm btn-warning" onclick="removeHobby(this)">Remove</button>
    </div>
    <hr>
    <input type="hidden" name="hobby_id[]" value="">
    <div class="form-group mb-3">
      <label>Hobby / Interest</label>
      <input type="text" class="form-control" name="hobbyName[]" required>
    </div>
    <div class="form-group mb-3">
      <label>Description</label>
      <textarea class="form-control" name="hobbyDescription[]" rows="3" required></textarea>
    </div>
  `;

  container.appendChild(newSection);
  updateHobbyHeadings();
}

function removeHobby(button) {
  button.closest('.hobby-section').remove();
  updateHobbyHeadings();
}

function updateHobbyHeadings() {
  const sections = document.querySelectorAll('.hobby-section');
  sections.forEach((section, index) => {
    const heading = section.querySelector('.hobby-heading');
    if (heading) {
      heading.textContent = `Hobby-${index + 1}`;
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