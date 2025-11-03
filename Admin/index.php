
<?php
session_start();
if (!empty($_SESSION['admin_email'])) {
?>
  <script>
    window.location.href = "/PMS/Admin/admin_dashboard.php";
  </script>
<?php
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login - PMS</title>
    <?php
    include '../partials/head.php'
    ?>
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                 
                </div>
                <h4 class="text-center">Admin Login - Portfolio Management System</h4>
                <hr>
                <form class="pt-3" method="POST" action="./admin_authentication.php">
  <div class="form-group">
    <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" name="email" placeholder="Admin Email" required>
  </div>
  <div class="form-group">
    <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="password" placeholder="Password" required>
  </div>
  <div class="mt-3 d-grid gap-2">
    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
  </div>
  <div class="my-2 d-flex justify-content-between align-items-center">
    <a href="./admin_forgot_password.php" class="auth-link text-primary">Forgot password?</a>
  </div>
  </div>
</form>

              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    

    <?php
     include '../partials/scripts.php';
    ?>
  </body>
</html>