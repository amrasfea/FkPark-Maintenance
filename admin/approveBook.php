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

// Begin a transaction
$conn->begin_transaction();

try {
    // Update the booking status to 'Approved'
    $sql = "UPDATE bookinfo SET b_status = 'Approved' WHERE b_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $b_id);

    if (!$stmt->execute()) {
        throw new Exception("Error: " . $stmt->error);
    }

    // Retrieve the parking space ID associated with this booking
    $sql = "SELECT ps_id FROM bookinfo WHERE b_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $b_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $ps_id = $row['ps_id'];

    // Update the parking space status to 'Not Available'
    $sql = "UPDATE parkspace SET ps_availableStat = 'occupied' WHERE ps_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $ps_id);

    if (!$stmt->execute()) {
        throw new Exception("Error: " . $stmt->error);
    }

    // Commit the transaction
    $conn->commit();

    echo "<script>alert('Booking Approved'); window.location.href='listApproveBook.php';</script>";
} catch (Exception $e) {
    // Rollback the transaction if an error occurs
    $conn->rollback();
    echo $e->getMessage();
}

$stmt->close();
$conn->close();
?>
