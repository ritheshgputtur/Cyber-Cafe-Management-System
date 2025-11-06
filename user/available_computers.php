<?php include "includes/header.php"; ?>
<?php

include 'config.php';
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

// Fetch available computers (not currently booked)
$query = "
    SELECT * FROM tblcomputers
    WHERE ID NOT IN (
        SELECT computerId FROM tblbookings WHERE OutTime IS NULL
    )
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Available Computers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #121212;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
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

        .computer-card {
            background-color: #1e1e1e;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            color: #fff;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
        }

        .computer-card:hover {
            transform: scale(1.02);
        }

        .computer-card h5 {
            color: #00e5ff;
        }

        .back-btn {
            margin-top: 20px;
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
                <h2 class="mb-4"><i class='bx bx-desktop'></i> Available Computers</h2>

                <?php if ($result->num_rows > 0): ?>
                    <div class="row">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="col-md-4">
                                <div class="computer-card">
                                    <h5><i class='bx bx-laptop'></i> <?= htmlspecialchars($row['ComputerName']) ?></h5>
                                    <p><strong>Location:</strong> <?= htmlspecialchars($row['ComputerLocation']) ?></p>
                                    <p><strong>IP Address:</strong> <?= htmlspecialchars($row['IPAdd']) ?></p>
                                    <p><strong>Added on:</strong> <?= date("d M Y", strtotime($row['EntryDate'])) ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">No computers are currently available.</div>
                <?php endif; ?>

                <a href="book_computer.php" class="btn btn-primary back-btn"><i class='bx bx-arrow-back'></i> Back to
                    Booking</a>
            </div>
        </div>
    </div>
</body>

</html>