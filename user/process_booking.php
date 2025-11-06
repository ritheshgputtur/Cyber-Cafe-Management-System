<?php
session_start();
include 'config.php';

if (!isset($_SESSION['userid']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: book_computer.php");
    exit;
}

$userId = $_SESSION['userid'];
$computerId = $_POST['computerId'];
$hours = $_POST['hours'];
$remark = $_POST['remark'];
$fees = $hours * 30; // ₹30/hour

$sql = "INSERT INTO tblbookings (userId, computerId, Fees, Remark) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $userId, $computerId, $fees, $remark);

if ($stmt->execute()) {
    header("Location: my_bookings.php");
} else {
    echo "Booking failed: " . $stmt->error;
}
