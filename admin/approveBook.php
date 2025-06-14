<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Ensure user is admin
if (!isset($_SESSION['u_id']) || $_SESSION['role'] !== 'Administrators') {
    die("Error: You do not have permission to view this page.");
}

session_start();

// Get booking ID
$b_id = $_GET['b_id'] ?? '';
if (empty($b_id)) {
    die("Error: Booking ID is not set.");
}

// Start transaction
$conn->begin_transaction();

try {
    // 1. Get booking details
    $stmt = $conn->prepare("SELECT ps_id, b_date, b_time FROM bookinfo WHERE b_id = ?");
    $stmt->bind_param('i', $b_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();

    if (!$booking) {
        throw new Exception("Booking not found.");
    }

    $ps_id = $booking['ps_id'];
    $b_date = $booking['b_date'];
    $b_time = $booking['b_time'];

    // 2. Check if parking space is already occupied
    $stmt = $conn->prepare("SELECT ps_availableStat FROM parkspace WHERE ps_id = ?");
    $stmt->bind_param('s', $ps_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $ps = $result->fetch_assoc();

    if (!$ps) {
        throw new Exception("Parking space not found.");
    }

    if (strtolower($ps['ps_availableStat']) === 'occupied') {
        $_SESSION['flash'] = "Error: Parking space is already occupied.";
        $conn->rollback();
        header('Location: listApproveBook.php');
        exit;
    }

    // 3. Check for booking clash at the same date & time
    $stmt = $conn->prepare("
        SELECT COUNT(*) AS clash_count
        FROM bookinfo 
        WHERE ps_id = ? AND b_date = ? AND b_time = ? AND b_status = 'Approved'
    ");
    $stmt->bind_param('sss', $ps_id, $b_date, $b_time);
    $stmt->execute();
    $result = $stmt->get_result();
    $clash = $result->fetch_assoc();

    if ($clash['clash_count'] > 0) {
        $_SESSION['flash'] = "Error: Booking clash detected. Another booking is already approved for this slot.";
        $conn->rollback();
        header('Location: listApproveBook.php');
        exit;
    }

    // 4. Approve booking
    $stmt = $conn->prepare("UPDATE bookinfo SET b_status = 'Approved' WHERE b_id = ?");
    $stmt->bind_param('i', $b_id);
    if (!$stmt->execute()) {
        throw new Exception("Error approving booking: " . $stmt->error);
    }

    // 5. Mark parking space as occupied
    $stmt = $conn->prepare("UPDATE parkspace SET ps_availableStat = 'occupied' WHERE ps_id = ?");
    $stmt->bind_param('s', $ps_id);
    if (!$stmt->execute()) {
        throw new Exception("Error updating parking space status: " . $stmt->error);
    }

    // 6. Commit transaction
    $conn->commit();
    $_SESSION['flash'] = "Booking approved successfully.";
    header('Location: listApproveBook.php');
    exit;

} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['flash'] = "Error: " . $e->getMessage();
    header('Location: listApproveBook.php');
    exit;
}

// Cleanup
$stmt->close();
$conn->close();
?>
