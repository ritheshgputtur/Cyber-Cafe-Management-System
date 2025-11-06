<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ccmsaid'] == 0)) {
  header('location:logout.php');
  exit;
}

$cid = intval($_GET['upid']);
$msg = '';

if (isset($_POST['update'])) {
  $username = mysqli_real_escape_string($con, $_POST['username']);
  $address = mysqli_real_escape_string($con, $_POST['address']);
  $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  $update = mysqli_query($con, "UPDATE tblusers SET 
        username='$username',
        address='$address',
        mobile='$mobile',
        email='$email',
        password='$password'
        WHERE id='$cid'");

  if ($update) {
    echo "<script>alert('User updated successfully'); window.location.href='view-user-detail.php?upid=$cid';</script>";
  } else {
    $msg = "Update failed. Please try again.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>CCMS | View & Edit User</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

  <?php include_once('includes/sidebar.php'); ?>

  <div id="right-panel" class="right-panel">
    <?php include_once('includes/header.php'); ?>

    <div class="breadcrumbs">
      <div class="col-sm-6">
        <h1>User Detail</h1>
      </div>
      <div class="col-sm-6 text-end">
        <ol class="breadcrumb text-right">
          <li><a href="dashboard.php">Dashboard</a></li>
          <li class="active">View User</li>
        </ol>
      </div>
    </div>

    <div class="content mt-3">
      <div class="card">
        <div class="card-header">
          <strong>Edit User Information</strong>
        </div>

        <div class="card-body">
          <?php
          $ret = mysqli_query($con, "SELECT * FROM tblusers WHERE id='$cid'");
          if ($row = mysqli_fetch_array($ret)) {
            ?>
            <form method="POST" action="">
              <div class="form-group">
                <label>User ID</label>
                <input type="text" class="form-control" value="CCMS-USER-<?= str_pad($row['id'], 4, '0', STR_PAD_LEFT) ?>"
                  readonly>
              </div>

              <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($row['username']) ?>"
                  required>
              </div>

              <div class="form-group">
                <label>Address</label>
                <textarea name="address" class="form-control" required><?= htmlspecialchars($row['address']) ?></textarea>
              </div>

              <div class="form-group">
                <label>Mobile</label>
                <input type="text" name="mobile" class="form-control" value="<?= htmlspecialchars($row['mobile']) ?>"
                  pattern="[0-9]{10}" required>
              </div>

              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($row['email']) ?>"
                  required>
              </div>

              <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
              </div>

              <div class="form-group text-center mt-4">
                <button type="submit" name="update" class="btn btn-primary"><i class="fa fa-save"></i> Update
                  User</button>
              </div>
            </form>
          <?php } else { ?>
            <div class="alert alert-warning">User not found.</div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  <script src="vendors/jquery/dist/jquery.min.js"></script>
  <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>