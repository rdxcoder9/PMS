
<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];
$name_parts = explode(' ', $_SESSION['name']);
$first_name = htmlspecialchars($name_parts[0] ?? '');
$last_name = htmlspecialchars($name_parts[1] ?? '');
$email = htmlspecialchars($_SESSION['email']);
$photo = null;

// Fetch profile photo from DB
$stmt = $conn->prepare("SELECT photo FROM personal_info WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $photo = $row['photo'];
}

if (!empty($photo) && file_exists($photo)) {
    $_SESSION['photo'] = $photo;
} else {
    $_SESSION['photo'] = '';
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
                    <h4>Profile Details</h4>
                    <hr>
                    

<?php if (!empty($photo) && file_exists($photo)): $_SESSION['photo']== $photo?>
  <div class="card mb-4">
    <div class="card-body text-center">
      <img src="<?php echo $photo; ?>" class="img-fluid rounded" style="max-height: 200px;" alt="Profile Photo">
    </div>
  </div>
<?php endif; ?>


                  <form class="forms-sample" action="save_profile.php" method="POST" enctype="multipart/form-data" id="editProfileForm">
                    <div class="form-group mb-3">
                      <label for="firstName">First Name</label>
                      <input type="text" class="form-control" id="firstName" name="first_name" value="<?php echo $first_name; ?>" required>
                    </div>

                    <div class="form-group mb-3">
                      <label for="lastName">Last Name</label>
                      <input type="text" class="form-control" id="lastName" name="last_name" value="<?php echo $last_name; ?>" required>
                    </div>

                    <div class="form-group mb-3">
                      <label for="email">Email address</label>
                      <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                    </div>

                    <div class="form-group mb-3">
                      <label for="profile_photo">Profile Photo (optional)</label>
                      <input type="file" class="form-control" id="profile_photo" name="profile_photo">
                    </div>

                    <button type="submit" name="save" class="btn btn-gradient-primary me-2">Update Profile</button>
                    <!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Reset Password
</button>
                  </form>

                  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Reset Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Password Reset (Bootstrap 5) -->

          <form action='./reset_password.php' method="POST" enctype="multipart/form-data"> 
            <!-- Current Password -->
            <div class="mb-3">
              <label for="currentPassword" class="form-label">Current Password</label>
              <div class="input-group">
                <input type="password" class="form-control" id="currentPassword" name="current_password" required autocomplete="current-password">
                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#currentPassword">Show</button>
                <div class="invalid-feedback">Please enter your current password.</div>
              </div>
            </div>

            <!-- New Password -->
            <div class="mb-3">
              <label for="newPassword" class="form-label">New Password</label>
              <div class="input-group">
                <input type="password" class="form-control" id="newPassword" name="new_password" minlength="8" required autocomplete="new-password" aria-describedby="passwordHelp">
                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#newPassword">Show</button>
                <div class="invalid-feedback">Use at least 8 characters.</div>
              </div>
              <div id="passwordHelp" class="form-text">Use 8+ characters with a mix of letters, numbers & symbols.</div>

              <!-- Strength Meter -->
              <div class="mt-2">
                <div class="d-flex justify-content-between small mb-1">
                  <span>Password strength</span>
                  <span id="strengthLabel" class="fw-semibold">—</span>
                </div>
                <div class="progress" style="height: 8px;">
                  <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"></div>
                </div>
              </div>
            </div>

            <!-- Confirm New Password -->
            <div class="mb-4">
              <label for="confirmPassword" class="form-label">Confirm New Password</label>
              <div class="input-group">
                <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required autocomplete="new-password">
                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#confirmPassword">Show</button>
                <div class="invalid-feedback">Passwords must match.</div>
              </div>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Update Password</button>
            </div>
          </form>

<!-- Script: Bootstrap validation + strength meter + show/hide -->
<script>
  (function () {
    'use strict';

    const form = document.getElementById('resetPasswordForm');
    const newPwd = document.getElementById('newPassword');
    const confirmPwd = document.getElementById('confirmPassword');
    const bar = document.getElementById('strengthBar');
    const label = document.getElementById('strengthLabel');

    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(btn => {
      btn.addEventListener('click', () => {
        const input = document.querySelector(btn.dataset.target);
        const showing = input.type === 'text';
        input.type = showing ? 'password' : 'text';
        btn.textContent = showing ? 'Show' : 'Hide';
      });
    });

    // Password strength calculation
    function getStrength(pwd) {
      let score = 0;
      if (pwd.length >= 8) score += 20;
      if (pwd.length >= 12) score += 10;
      if (/[a-z]/.test(pwd)) score += 20;
      if (/[A-Z]/.test(pwd)) score += 20;
      if (/\d/.test(pwd)) score += 15;
      if (/[^A-Za-z0-9]/.test(pwd)) score += 15;
      return Math.min(score, 100);
    }

    function updateStrengthUI(pwd) {
      const s = getStrength(pwd);
      bar.style.width = s + '%';
      bar.setAttribute('aria-valuenow', s);

      // Color & label
      let cls = 'bg-danger', txt = 'Weak';
      if (s >= 75) { cls = 'bg-success'; txt = 'Strong'; }
      else if (s >= 50) { cls = 'bg-warning'; txt = 'Medium'; }

      bar.className = 'progress-bar ' + cls;
      label.textContent = pwd.length ? txt : '—';
    }

    newPwd.addEventListener('input', () => {
      updateStrengthUI(newPwd.value);
      // If user edited new password, re-check confirmation match
      if (confirmPwd.value) checkMatch();
    });

    function checkMatch() {
      if (confirmPwd.value !== newPwd.value) {
        confirmPwd.setCustomValidity('Mismatch');
      } else {
        confirmPwd.setCustomValidity('');
      }
    }

    confirmPwd.addEventListener('input', checkMatch);

    // Bootstrap validation styling
    form.addEventListener('submit', function (e) {
      checkMatch();
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  })();
</script>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>






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
    
<script>
    document.getElementById('editProfileForm').addEventListener('submit', function (e) {
      const firstName = document.getElementById('firstName').value.trim();
      const lastName = document.getElementById('lastName').value.trim();
      const email = document.getElementById('email').value.trim();

      if (!firstName || !lastName || !email) {
        alert('Please fill in all required fields.');
        e.preventDefault();
        return;
      }

      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email)) {
        alert('Please enter a valid email address.');
        e.preventDefault();
      }
    });
    </script>

  </body>
</html>