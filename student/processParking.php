<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}

// Ensure all required POST data is set
$b_id = $_POST['b_id'] ?? '';
$duration = $_POST['duration'] ?? '';

if (empty($b_id) || empty($duration)) {
    die("Error: Missing required information.");
}

// Update the booking with parking duration
$query = "UPDATE bookinfo SET b_duration = ? WHERE b_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $duration, $b_id);

if ($stmt->execute()) {
    // Redirect to booking list or confirmation page
    header("Location: bookList.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
