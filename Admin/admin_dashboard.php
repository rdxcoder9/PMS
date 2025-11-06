<?php
session_start();
include '../partials/db.php';

// Redirect if admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle Add Admin
if (isset($_POST['add_admin'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO admin_users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();
}

// Handle Delete Admin
if (isset($_POST['delete_admin'])) {
    $admin_id = $_POST['admin_id'];
    $stmt = $conn->prepare("DELETE FROM admin_users WHERE id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
}

// Handle Update Admin
if (isset($_POST['update_admin'])) {
    $admin_id = $_POST['admin_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE admin_users SET username=?, email=?, password=? WHERE id=?");
    $stmt->bind_param("sssi", $username, $email, $password, $admin_id);
    $stmt->execute();
}

// Fetch Admins
$admins = mysqli_query($conn, "SELECT * FROM admin_users");
if (!$admins) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin - Dashboard</title>
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
            <h2 class="mb-4">Manage Admin Users</h2>

            <!-- Add Admin Form -->
            <form method="POST" class="mb-4">
              <div class="form-row">
                <div class="col">
                  <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="col">
                  <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="col">
                  <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="col">
                  <button type="submit" name="add_admin" class="btn btn-success btn-block">Add Admin</button>
                </div>
              </div>
            </form>

            <!-- Admin List Table -->
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($admin = mysqli_fetch_assoc($admins)) { ?>
                    <tr>
                      <form method="POST">
                        <td><?= $admin['id'] ?></td>
                        <td><input type="text" name="username" value="<?= $admin['username'] ?>" class="form-control"></td>
                        <td><input type="email" name="email" value="<?= $admin['email'] ?>" class="form-control"></td>
                        <td><?= $admin['created_at'] ?></td>
                        <td>
                          <input type="hidden" name="admin_id" value="<?= $admin['id'] ?>">
                          <input type="password" name="password" placeholder="New Password" class="form-control mb-2">
                          <button type="submit" name="update_admin" class="btn btn-primary btn-sm">Update</button>
                          <button type="submit" name="delete_admin" class="btn btn-danger btn-sm" onclick="return confirm('Delete this admin?')">Delete</button>
                        </td>
                      </form>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php include '../partials/_footer.php'; ?>
      </div>
    </div>
  </div>

  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="../assets/js/off-canvas.js"></script>
  <script src="../assets/js/misc.js"></script>
</body>
</html>
