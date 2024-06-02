<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session and if the user is an admin
if (!isset($_SESSION['u_id']) || $_SESSION['role'] !== 'Administrators') {
    die("Error: You do not have permission to view this page.");
}

// Retrieve booking ID from query string
$b_id = $_GET['b_id'] ?? '';

if (empty($b_id)) {
    die("Error: Booking ID is not set.");
}

// Update the booking status to 'Rejected'
$sql = "UPDATE bookinfo SET b_status = 'Rejected' WHERE b_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $b_id);

if ($stmt->execute()) {
    echo "<script>alert('Booking Rejected'); window.location.href='listApproveBook.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
