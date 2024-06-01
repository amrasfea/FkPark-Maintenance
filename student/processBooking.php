<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}

// Retrieve the user ID from the session
$u_id = $_SESSION['u_id'];

// Retrieve form data
$ps_id = $_POST['ps_id'] ?? '';
$parking_date = $_POST['parking_date'] ?? '';
$parking_time = $_POST['parking_time'] ?? '';
$vehicle_plate_number = $_POST['vehicle_plate_number'] ?? '';

// Validate that all necessary data is provided
if (empty($ps_id) || empty($parking_date) || empty($parking_time) || empty($vehicle_plate_number)) {
    die("Error: Missing required booking details.");
}

// Insert booking details into the bookinfo table
$query = "INSERT INTO bookinfo (u_id, b_date, b_time, ps_id, b_platenum) VALUES ('$u_id', '$parking_date', '$parking_time', '$ps_id', '$vehicle_plate_number')";

if (mysqli_query($conn, $query)) {
    // Update the parking space availability status
    $update_query = "UPDATE parkspace SET ps_availableStat = 'Not Available' WHERE ps_id = '$ps_id'";
    if (mysqli_query($conn, $update_query)) {
        // Redirect to a new page for QR code generation
        header("Location: confirmBook.php?ps_id=$ps_id&parking_date=$parking_date&parking_time=$parking_time");
        exit;
    } else {
        echo "Error updating parking space status: " . mysqli_error($conn);
    }
} else {
    echo "Error inserting booking info: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
