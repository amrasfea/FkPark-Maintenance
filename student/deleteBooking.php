<!-- delete booking -->
<!-- by auni -->


<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if booking ID is set in the query string
$b_id = $_GET['b_id'] ?? '';

if (empty($b_id)) {
    die("Error: Booking ID is not set.");
}

// Delete the booking
$query = "DELETE FROM bookinfo WHERE b_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $b_id);
if ($stmt->execute()) {
    header('Location: bookList.php');
    exit();
} else {
    die("Error: Could not delete booking.");
}

$stmt->close();
$conn->close();
?>
