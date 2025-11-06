<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ccmsaid'] == 0)) {
    header('location:logout.php');
    exit;
}
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <title>CCMS | Manage New Users</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include_once('includes/sidebar.php'); ?>

    <div id="right-panel" class="right-panel">
        <?php include_once('includes/header.php'); ?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <h1>New Users</h1>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <ol class="breadcrumb text-right">
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">New Users</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">List of New Users</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($con, "SELECT * FROM tblusers  ORDER BY id DESC");
                                $cnt = 1;
                                if (mysqli_num_rows($query) > 0) {
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        ?>
                                        <tr>
                                            <td><?= $cnt ?></td>
                                            <td>CCMS-USER-<?= str_pad($row['id'], 4, '0', STR_PAD_LEFT) ?></td>
                                            <td><?= htmlspecialchars($row['username']) ?></td>
                                            <td><?= htmlspecialchars($row['email']) ?></td>
                                            <td><?= htmlspecialchars($row['mobile']) ?></td>
                                            <td>
                                                <a href="view-user-detail.php?upid=<?= $row['id'] ?>"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-pencil"></i> Update
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        $cnt++;
                                    }
                                } else {
                                    echo '<tr><td colspan="6" class="text-center text-warning">No new users found.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>