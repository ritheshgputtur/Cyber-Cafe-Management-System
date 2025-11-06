<?php
session_start();
include 'config.php';

if (!isset($_SESSION["userid"]) || !isset($_GET["id"])) {
    header("Location: my_bookings.php");
    exit;
}

$bookingId = $_GET["id"];
$userId = $_SESSION["userid"];

// Set OutTime to now for cancellation
$stmt = $conn->prepare("UPDATE tblbookings SET OutTime = NOW(), Remark = CONCAT(Remark, ' (Cancelled)') WHERE id = ? AND userId = ? AND OutTime IS NULL");
$stmt->bind_param("ii", $bookingId, $userId);
$stmt->execute();

header("Location: my_bookings.php");
