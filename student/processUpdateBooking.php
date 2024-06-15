<!-- handle update booking -->
<!-- by auni -->

<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}

// Ensure all required POST data is set
$b_id = $_POST['b_id'] ?? '';
$parking_date = $_POST['parking_date'] ?? '';
$parking_time = $_POST['parking_time'] ?? '';
$b_parkStart = $_POST['b_parkStart'] ?? '';
$b_duration = $_POST['b_duration'] ?? '';

if (empty($b_id) || empty($parking_date) || empty($parking_time) || empty($b_parkStart) || empty($b_duration)) {
    die("Error: Missing required booking details.");
}

// Debugging output
echo "b_id: $b_id\n";
echo "parking_date: $parking_date\n";
echo "parking_time: $parking_time\n";
echo "b_parkStart: $b_parkStart\n";
echo "b_duration: $b_duration\n";

// Update the booking details in the bookinfo table
$query = "UPDATE bookinfo SET b_date = ?, b_time = ?, b_parkStart = ?, b_duration = ? WHERE b_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('sssii', $parking_date, $parking_time, $b_parkStart, $b_duration,  $b_id);

if ($stmt->execute()) {
    // Debugging output for successful execution
    echo "Update successful.";
    // Redirect to booking list page
    header("Location: bookList.php");
    exit;
} else {
    // Error handling
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
