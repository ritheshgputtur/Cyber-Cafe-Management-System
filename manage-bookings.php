<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ccmsaid']) == 0) {
    header('location:logout.php');
    exit;
}

// Handle update submission
if (isset($_POST['update_booking'])) {
    $id = intval($_POST['booking_id']);
    $fees = floatval($_POST['fees']);
    $remark = mysqli_real_escape_string($con, $_POST['remark']);
    $outTime = $_POST['outTime'];
    $updateDate = date('Y-m-d H:i:s');

    $query = mysqli_query($con, "UPDATE tblbookings SET OutTime='$outTime', Fees='$fees', Remark='$remark', UpdationDate='$updateDate' WHERE id='$id'");

    $msg = $query ? "Booking updated successfully!" : "Update failed. Please try again.";
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>CCMS | Manage Bookings</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include_once('includes/sidebar.php'); ?>

    <div id="right-panel" class="right-panel">
        <?php include_once('includes/header.php'); ?>

        <div class="breadcrumbs row m-0 p-3 bg-light">
            <div class="col-sm-6">
                <h3>Manage Bookings</h3>
            </div>
            <div class="col-sm-6 text-right">
                <ol class="breadcrumb">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li class="active">Bookings</li>
                </ol>
            </div>
        </div>

        <div class="content mt-3">
            <?php if (isset($msg)): ?>
                <div class="alert alert-info text-center"><?= $msg ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <strong class="card-title">All Bookings</strong>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped table-dark">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>User ID</th>
                                <th>Computer ID</th>
                                <th>In Time</th>
                                <th>Out Time</th>
                                <th>Fees</th>
                                <th>Remark</th>
                                <th>Updated On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $ret = mysqli_query($con, "SELECT * FROM tblbookings ORDER BY id DESC");
                            $cnt = 1;
                            while ($row = mysqli_fetch_array($ret)) {
                                $bid = $row['id'];
                                ?>
                                <tr>
                                    <td><?= $cnt ?></td>
                                    <td><?= htmlspecialchars($row['userId']) ?></td>
                                    <td><?= htmlspecialchars($row['computerId']) ?></td>
                                    <td><?= $row['InTime'] ?></td>
                                    <td><?= $row['OutTime'] && $row['OutTime'] != '0000-00-00 00:00:00' ? $row['OutTime'] : '<span class="text-warning">Active</span>' ?>
                                    </td>
                                    <td>₹<?= number_format($row['Fees'], 2) ?></td>
                                    <td><?= $row['Remark'] ?: '<em>—</em>' ?></td>
                                    <td><?= $row['UpdationDate'] ?: '<em>—</em>' ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info mb-1" data-toggle="modal"
                                            data-target="#editModal<?= $bid ?>">
                                            <i class="fa fa-pencil"></i> Edit
                                        </button>
                                        <a href="delete-booking.php?bid=<?= $bid ?>" class="btn btn-sm btn-danger mb-1"
                                            onclick="return confirm('Delete this booking?')">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal<?= $bid ?>" tabindex="-1" role="dialog"
                                    aria-labelledby="editModalLabel<?= $bid ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content bg-dark text-white">
                                            <form method="POST" action="">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Booking #<?= $bid ?></h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="booking_id" value="<?= $bid ?>">

                                                    <div class="form-group">
                                                        <label>Fees (₹)</label>
                                                        <input type="number" step="0.01" name="fees" class="form-control"
                                                            value="<?= $row['Fees'] ?>" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Out Time</label>
                                                        <input type="datetime-local" name="outTime" class="form-control"
                                                            value="<?= $row['OutTime'] && $row['OutTime'] != '0000-00-00 00:00:00' ? date('Y-m-d\TH:i', strtotime($row['OutTime'])) : '' ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Remark</label>
                                                        <textarea name="remark" class="form-control"
                                                            rows="2"><?= htmlspecialchars($row['Remark']) ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="update_booking" class="btn btn-success">
                                                        Save Changes
                                                    </button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php $cnt++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- JS dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>