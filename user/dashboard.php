<?php
include "includes/header.php";
include "config.php";
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

$userid = $_SESSION['userid'];

// Fetch available computers (not booked currently)
$available = $conn->query("
    SELECT * FROM tblcomputers 
    WHERE ID NOT IN (
        SELECT computerId FROM tblbookings WHERE OutTime IS NULL
    )
");
?>

<style>
    body {
        background-color: #121212;
        color: #f5f5f5;
        font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
        background: #1e1e1e;
        padding: 2rem 1rem;
    }

    .sidebar .nav-link {
        color: #ccc;
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    .sidebar .nav-link.active {
        background: #333;
        color: #fff;
        border-radius: 0.375rem;
    }

    .dashboard-header {
        background-color: #1f1f1f;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #333;
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

    .btn-book {
        margin-top: 10px;
        background-color: #00c853;
        border: none;
        color: white;
    }

    .btn-book:hover {
        background-color: #00b248;
    }
</style>

<div class="container-fluid my-3">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <?php include "includes/sidebar.php"; ?>
        </div>

        <!-- Main Content -->
        <div class="col-md-10">
            <div class="dashboard-header d-flex justify-content-between align-items-center">
                <h3>Hello, <span class="text-info"><?= htmlspecialchars($_SESSION['username']) ?></span> 👋</h3>
                <span class="text-muted">Logged in | <?= date('d M Y, h:i A') ?></span>
            </div>

            <!-- Available Computers -->
            <div class="row px-4 mt-4">
                <h5 class="mb-4">Available Computers</h5>

                <?php if ($available->num_rows > 0): ?>
                    <?php while ($row = $available->fetch_assoc()): ?>
                        <div class="col-md-4">
                            <div class="computer-card">
                                <h5><i class='bx bx-laptop'></i> <?= htmlspecialchars($row['ComputerName']) ?></h5>
                                <p><strong>Location:</strong> <?= htmlspecialchars($row['ComputerLocation']) ?></p>
                                <p><strong>IP Address:</strong> <?= htmlspecialchars($row['IPAdd']) ?></p>
                                <p><strong>Added on:</strong> <?= date("d M Y", strtotime($row['EntryDate'])) ?></p>
                                <a href="book_computer.php" class="btn btn-book btn-sm">Book Now</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-warning">No computers are currently available.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
</body>

</html>