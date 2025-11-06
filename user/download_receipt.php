<?php
session_start();
include 'config.php';

if (!isset($_SESSION['userid']) || !isset($_GET['id'])) {
    die("Unauthorized access.");
}

$userid = $_SESSION['userid'];
$bookingId = intval($_GET['id']);

$stmt = $conn->prepare("
    SELECT b.*, c.ComputerName, c.ComputerLocation 
    FROM tblbookings b 
    JOIN tblcomputers c ON b.computerId = c.ID 
    WHERE b.id = ? AND b.userId = ?
");
$stmt->bind_param("ii", $bookingId, $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("No such booking found.");
}

$row = $result->fetch_assoc();

// Trigger download
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=receipt_{$bookingId}.html");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Booking Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        .receipt {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        h2 {
            color: #007bff;
        }

        .line {
            margin-bottom: 10px;
        }

        .label {
            font-weight: bold;
            color: #333;
        }

        .value {
            color: #555;
        }
    </style>
</head>

<body>
    <div class="receipt">
        <h2>Cyber Cafe Booking Receipt</h2>
        <div class="line"><span class="label">Booking ID:</span> <span class="value"><?= $bookingId ?></span></div>
        <div class="line"><span class="label">Computer:</span> <span class="value"><?= $row['ComputerName'] ?>
                (<?= $row['ComputerLocation'] ?>)</span></div>
        <div class="line"><span class="label">In Time:</span> <span class="value"><?= $row['InTime'] ?></span></div>
        <div class="line"><span class="label">Out Time:</span> <span
                class="value"><?= $row['OutTime'] ?: 'Ongoing' ?></span></div>
        <div class="line"><span class="label">Fees:</span> <span class="value">₹<?= $row['Fees'] ?></span></div>
        <div class="line"><span class="label">Remark:</span> <span class="value"><?= $row['Remark'] ?></span></div>
        <div class="line" style="margin-top: 20px;">
            <em>Thank you for using our services.</em>
        </div>
    </div>
</body>

</html>