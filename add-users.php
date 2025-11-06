<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ccmsaid'] == 0)) {
    header('location:logout.php');
    exit;
}

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Securely hashed

    $query = mysqli_query($con, "INSERT INTO tblusers(username, address, mobile, email, password) 
                                 VALUES ('$username', '$address', '$mobile', '$email', '$password')");

    if ($query) {
        echo '<script>alert("User added successfully."); window.location.href = "add-users.php";</script>';
    } else {
        echo '<script>alert("Something went wrong. Please try again.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CCMS Admin - Add User</title>
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
                <div class="page-header float-left">
                    <h1>Add User</h1>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="card">
                    <div class="card-header"><strong>User</strong> <small>Details</small></div>
                    <form method="POST" action="">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="username">Full Name</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" class="form-control" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="mobile">Mobile Number</label>
                                <input type="text" name="mobile" class="form-control" pattern="[0-9]{10}" maxlength="10"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email ID</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <button type="submit" name="submit" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Add User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>