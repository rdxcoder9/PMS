<?php
include './partials/_session.php';
include './partials/db.php';

$query = "SELECT * FROM `personal_info` WHERE user_id={$_SESSION['user_id']}";
$result = mysqli_query($conn, $query);
$row_info = mysqli_fetch_assoc($result);
$dataExists = $row_info ? true : false;
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
                    <h4 class="card-title">Personal Information</h4>
                    


<form class="forms-sample" id="personalInfoForm" action="save_personal_info.php" method="POST" enctype="multipart/form-data" novalidate>
  <input type="hidden" name="dataExists" value="<?php echo $dataExists ? '1' : '0'; ?>">

  <div class="form-group mb-3">
    <label for="exampleInputName1">Name</label>
    <input type="text" class="form-control" id="exampleInputName1" name="name" placeholder="Name"
      value="<?php echo htmlspecialchars($_SESSION['name']); ?>" disabled>
  </div>

  <div class="form-group mb-3">
    <label for="dateOfBirth">Date of Birth</label>
    <input type="date" class="form-control" id="dateOfBirth" name="dob" required
      value="<?php echo $dataExists ? htmlspecialchars($row_info['dob']) : ''; ?>">
  </div>

  <div class="form-group mb-3">
    <label for="nationality">Nationality</label>
    <input type="text" class="form-control" id="nationality" name="nationality" placeholder="Nationality" required
      value="<?php echo $dataExists ? htmlspecialchars($row_info['nationality']) : ''; ?>">
  </div>

  <div class="form-group mb-3">
    <label for="phoneNumber">Phone Number <span class="text-muted">(+91)</span></label>
    <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="+91 9876543210"
      pattern="^\+91\s?[6-9]\d{9}$" required
      value="<?php echo $dataExists ? htmlspecialchars($row_info['phone_number']) : ''; ?>">
  </div>

  <div class="form-group mb-3">
    <label for="emailAddress">Email address</label>
    <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Email"
      value="<?php echo htmlspecialchars($_SESSION['email']); ?>" disabled>
  </div>

  <div class="form-group mb-3">
    <label for="LinkedInProfile">LinkedIn Profile <span class="text-muted">(Optional)</span></label>
    <input type="url" class="form-control" id="LinkedInProfile" name="LinkedInProfile" placeholder="LinkedIn Profile Link"
      value="<?php echo $dataExists ? htmlspecialchars($row_info['linkedin_url']) : ''; ?>">
  </div>

  <div class="form-group mb-3">
    <label for="exampleSelectGender">Gender</label>
    <select class="form-select" id="exampleSelectGender" name="gender" required>
      <option value="">Select Gender</option>
      <option value="Male" <?php echo ($dataExists && $row_info['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
      <option value="Female" <?php echo ($dataExists && $row_info['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
    </select>
  </div>

  <!-- <div class="form-group mb-3">
    <label for="passportPhoto">Passport Size Photo</label>
    <input type="file" class="form-control" id="passportPhoto" name="passportPhoto" accept="image/*" <?php //echo $dataExists ? '' : 'required'; ?>>
    <?php //if ($dataExists && !empty($row_info['photo'])): ?>
      <small class="form-text text-muted">Current photo: <a href="<?php //echo $row_info['photo']; ?>" target="_blank">View</a></small>
    <?php //endif; ?>
  </div> -->

  <div class="form-group mb-3">
    <label for="exampleTextarea1">Address</label>
    <textarea class="form-control" id="exampleTextarea1" name="address" rows="4" required><?php echo $dataExists ? htmlspecialchars($row_info['address']) : ''; ?></textarea>
  </div>

  <button type="submit" class="btn btn-gradient-primary me-2">
    <?php echo $dataExists ? 'Update' : 'Submit'; ?>
  </button>
</form>





                  </div>
                </div>
              </div>

          </div>
          <!-- content-wrapper ends -->





        <!-- Form Validation Script -->
        
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('personalInfoForm');
    const inputs = form.querySelectorAll('input, textarea, select');

    inputs.forEach(input => {
      input.addEventListener('input', () => {
        if (input.checkValidity()) {
          input.classList.remove('is-invalid');
          input.classList.add('is-valid');
        } else {
          input.classList.remove('is-valid');
          input.classList.add('is-invalid');
        }
      });
    });

    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    });
  });

  document.addEventListener('DOMContentLoaded', () => {
    const photoInput = document.getElementById('passportPhoto');

    photoInput.addEventListener('change', function () {
      const file = this.files[0];
      const maxSizeKB = 200;

      if (!file) return;

      // Check file size
      if (file.size > maxSizeKB * 1024) {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
        return;
      }

      // Check image dimensions
      const img = new Image();
      img.src = URL.createObjectURL(file);
      img.onload = () => {
        const width = img.width;
        const height = img.height;

        // Approx passport size in pixels: 413x531
        if (width >= 400 && width <= 430 && height >= 520 && height <= 550) {
          photoInput.classList.remove('is-invalid');
          photoInput.classList.add('is-valid');
        } else {
          photoInput.classList.add('is-invalid');
          photoInput.classList.remove('is-valid');
        }
      };
    });
  });
  
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