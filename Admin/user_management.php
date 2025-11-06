<?php
session_start();
include '../partials/db.php';

// Redirect if admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle Delete User
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    mysqli_query($conn, "DELETE FROM users WHERE id = $user_id");
}

// Handle Update User
if (isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', password='$password' WHERE id=$user_id");
}

// Fetch Users
$users = mysqli_query($conn, "SELECT * FROM users");
if (!$users) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Management</title>
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <?php include '../partials/_navbar_admin.php'; ?>
      <div class="container-fluid page-body-wrapper">
        <?php include '../partials/_sidebar_admin.php'; ?>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="container mt-4">
              <h2 class="mb-4">Manage Users</h2>

              <!-- User List Table -->
              <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($user = mysqli_fetch_assoc($users)) { ?>
                    <tr>
                      <form method="POST">
                        <td><?= $user['id'] ?></td>
                        <td>
                          <input type="text" name="first_name" value="<?= $user['first_name'] ?>" class="form-control">
                        </td>
                        <td>
                          <input type="text" name="last_name" value="<?= $user['last_name'] ?>" class="form-control">
                        </td>
                        <td>
                          <input type="email" name="email" value="<?= $user['email'] ?>" class="form-control">
                        </td>
                        <td><?= $user['created_at'] ?></td>
                        <td>
                          <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                          <input type="password" name="password" placeholder="New Password" class="form-control mb-2">
                          <button type="submit" name="update_user" class="btn btn-primary btn-sm">Update</button>
                          <button type="submit" name="delete_user" class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">Delete</button>
                        </td>
                      </form>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php include '../partials/_footer.php'; ?>
        </div>
      </div>
    </div>

    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/misc.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <script src="../assets/js/jquery.cookie.js"></script>
  </body>
</html>
