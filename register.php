<?php
session_start();
if(!empty($_SESSION['email'])){
  ?>
  <script>
    window.location.href="./dashboard.php";
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
    <title>Purple Admin</title>
    <?php
    include './partials/head.php'
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
                <h4 class="text-center">Portfolio Management System</h4>
                <hr>
                </div>
                <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                
<form class="pt-3" method="POST" action="user-register.php">
  <div class="form-group">
    <input type="text" class="form-control form-control-lg" id="exampleInputUsername1" name="first_name" placeholder="First Name" required>
  </div>
  <div class="form-group">
    <input type="text" class="form-control form-control-lg" id="exampleInputUsername1" name="last_name" placeholder="Last Name" required>
  </div>
  <div class="form-group">
    <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" name="email" placeholder="Email" required>
  </div>
  <div class="form-group">
    <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="password" placeholder="Password" required>
  </div>
  <div class="mb-4">
    <div class="form-check">
      <label class="form-check-label text-muted">
        <input type="checkbox" class="form-check-input" required> I agree to all Terms & Conditions
      </label>
    </div>
  </div>
  <div class="mt-3 d-grid gap-2">
    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SIGN UP</button>
  </div>
  <div class="text-center mt-4 font-weight-light">
    Already have an account? <a href="./" class="text-primary">Login</a>
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
     include './partials/scripts.php';
    ?>
  </body>
</html>