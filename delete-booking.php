<?php
session_start();
include('includes/dbconnection.php');

if (!isset($_SESSION['ccmsaid'])) {
    header('location:logout.php');
    exit;
}

if (isset($_GET['bid'])) {
    $bid = intval($_GET['bid']);
    $check = mysqli_query($con, "SELECT id FROM tblbookings WHERE id='$bid'");

    if (mysqli_num_rows($check) > 0) {
        $delete = mysqli_query($con, "DELETE FROM tblbookings WHERE id='$bid'");
        if ($delete) {
            echo "<script>alert('Booking deleted successfully.'); window.location.href='manage-bookings.php';</script>";
        } else {
            echo "<script>alert('Failed to delete booking.'); window.location.href='manage-bookings.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid booking ID.'); window.location.href='manage-bookings.php';</script>";
    }
}
?>