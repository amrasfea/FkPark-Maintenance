<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}

// Retrieve form data
$ps_id = $_POST['ps_id'] ?? '';
$parking_date = $_POST['parking_date'] ?? '';
$parking_time = $_POST['parking_time'] ?? '';
$parking_start_time = $_POST['parking_start_time'] ?? '';
$parking_duration = $_POST['parking_duration'] ?? '';

if (empty($ps_id) || empty($parking_date) || empty($parking_time) || empty($parking_start_time) || empty($parking_duration)) {
    die("Error: Missing required parking details.");
}

// Update bookinfo table with parking start time and duration
$query = "UPDATE bookinfo SET b_parkStart = '$parking_start_time', b_duration = '$parking_duration' WHERE u_id = '$u_id' AND ps_id = '$ps_id' AND b_date = '$parking_date' AND b_time = '$parking_time'";

if (mysqli_query($conn, $query)) {
    // Redirect to a success page or display a success message
    header("Location: parkingSuccess.php?ps_id=$ps_id&parking_date=$parking_date&parking_time=$parking_time");
    exit;
} else {
    echo "Error updating parking info: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
