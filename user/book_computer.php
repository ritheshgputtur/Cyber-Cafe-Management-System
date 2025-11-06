<?php
session_start();
include 'config.php';
include "includes/header.php";
// Ensure user is logged in
if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
    exit;
}

// Get available computers
$sql = "SELECT * FROM tblcomputers WHERE ID NOT IN (
    SELECT computerId FROM tblbookings WHERE OutTime IS NULL
)";
$computers = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Book a Computer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #121212;
            color: #f5f5f5;
            font-family: "Segoe UI", sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: #000;
            padding: 2rem 1rem;
        }

        .sidebar a {
            color: #ddd;
            text-decoration: none;
            display: block;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .sidebar a:hover {
            background-color: #222;
            color: #00e5ff;
        }

        .sidebar h4 {
            color: #00e5ff;
        }

        .form-container {
            background: #1f1f1f;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6);
            margin-top: 2rem;
        }

        .form-control,
        .form-select {
            background-color: #2c2c2c;
            color: #fff;
            border: 1px solid #444;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #00d4ff;
            box-shadow: none;
        }

        .btn-success {
            background-color: #00c853;
            border: none;
        }

        .btn-success:hover {
            background-color: #00b248;
        }

        .btn-secondary {
            background-color: #444;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #555;
        }

        h2 {
            color: #00e5ff;
        }
    </style>
    <script>
        function calculateFees() {
            const hours = parseFloat(document.getElementById("hours").value);
            const rate = 30;
            document.getElementById("fees").value = isNaN(hours) ? "" : "₹" + (hours * rate).toFixed(2);
        }
    </script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <?php include "includes/sidebar.php"; ?>
            </div>

            <!-- Main Content -->
            <div class="col-md-10">
                <div class="container form-container">
                    <h2 class="mb-4"><i class='bx bx-desktop'></i> Book a Computer</h2>
                    <form action="process_booking.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Choose Computer</label>
                            <select name="computerId" class="form-select" required>
                                <option value="">-- Select --</option>
                                <?php while ($row = $computers->fetch_assoc()): ?>
                                    <option value="<?= $row['ID'] ?>">
                                        <?= $row['ComputerName'] ?> - <?= $row['ComputerLocation'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Expected Hours</label>
                            <input type="number" name="hours" id="hours" class="form-control" min="1" max="8"
                                onchange="calculateFees()" onkeyup="calculateFees()" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Estimated Fees</label>
                            <input type="text" id="fees" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Remark</label>
                            <input type="text" name="remark" class="form-control" placeholder="(optional)">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">Confirm Booking</button>
                            <a href="my_bookings.php" class="btn btn-secondary">View My Bookings</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include "includes/footer.php" ?>

</html>