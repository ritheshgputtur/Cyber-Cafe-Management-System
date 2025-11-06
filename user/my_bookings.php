<?php
session_start();
include 'config.php';
include 'includes/header.php';

if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION["userid"];
$result = $conn->query("
    SELECT b.*, c.ComputerName 
    FROM tblbookings b 
    JOIN tblcomputers c ON b.computerId = c.ID 
    WHERE b.userId = $userId 
    ORDER BY b.InTime DESC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #fff;
            font-family: "Segoe UI", sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: #000;
            padding: 2rem 1rem;
        }

        .sidebar h4 {
            color: #00e5ff;
        }

        .sidebar a {
            display: block;
            padding: 12px 16px;
            color: #ccc;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background-color: #1f1f1f;
            color: #00e5ff;
        }

        .table-container {
            margin-top: 2rem;
            background: #1e1e1e;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
        }

        .table-dark th,
        .table-dark td {
            color: #eaeaea;
            vertical-align: middle;
        }

        .btn-sm {
            padding: 0.3rem 0.6rem;
            font-size: 0.85rem;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
        }

        .badge-active {
            background-color: #ff6f00;
            color: #fff;
        }

        .badge-complete {
            background-color: #00c853;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <?php include "includes/sidebar.php"; ?>
            </div>

            <!-- Main content -->
            <div class="col-md-10 p-4">
                <h2><i class='bx bx-history'></i> My Bookings</h2>

                <div class="table-container">
                    <table class="table table-dark table-bordered table-hover text-center align-middle">
                        <thead class="table-secondary table-dark ">
                            <tr>
                                <th>Computer</th>
                                <th>In Time</th>
                                <th>Out Time</th>
                                <th>Fees</th>
                                <th>Remark</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['ComputerName']) ?></td>
                                    <td><?= date("d M Y, h:i A", strtotime($row['InTime'])) ?></td>
                                    <td>
                                        <?= $row['OutTime'] ? date("d M Y, h:i A", strtotime($row['OutTime'])) : '—' ?>
                                    </td>
                                    <td>₹<?= $row['Fees'] ?></td>
                                    <td><?= htmlspecialchars($row['Remark']) ?></td>
                                    <td>
                                        <?php if ($row['OutTime'] === NULL): ?>
                                            <span class="status-badge badge-active">Active</span>
                                        <?php else: ?>
                                            <span class="status-badge badge-complete">Completed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($row['OutTime'] === NULL): ?>
                                            <a href="cancel_booking.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">
                                                <i class='bx bx-x'></i> Cancel
                                            </a>

                                        <?php else: ?>
                                            <i class='bx bx-check-circle text-success'></i>
                                        <?php endif; ?>
                                        <a href="download_receipt.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">
                                            <i class='bx bx-download'></i> Receipt
                                        </a>

                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <a href="book_computer.php" class="btn btn-primary mt-3">
                        <i class='bx bx-plus-circle'></i> New Booking
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include "includes/footer.php"; ?>

</html>