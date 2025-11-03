<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];
$objective_text = '';
$isUpdate = false;

$query = "SELECT objective FROM career_objective WHERE user_id = $user_id LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $objective_text = $row['objective'];
    $isUpdate = true;
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
                    <form class="forms-sample" action="save_objective.php" method="POST">
  <div class="card p-4 mb-4">
    <h4 class="mb-3">Career Objective</h4>

    <div class="form-group mb-3">
      <label for="objective">Objective</label>
      <textarea class="form-control" id="objective" name="objective" rows="5" placeholder="Write your career objective here..." required><?php echo htmlspecialchars($objective_text); ?></textarea>
    </div>

    <button type="submit" name="save" class="btn btn-gradient-primary me-2">
      <?php echo $isUpdate ? 'Update Objective' : 'Submit Objective'; ?>
    </button>
  </div>
</form>





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