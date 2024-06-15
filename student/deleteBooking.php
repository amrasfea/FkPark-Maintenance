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

// Fetch the parking space ID (ps_id) associated with this booking
$query = "SELECT ps_id FROM bookinfo WHERE b_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $b_id);
$stmt->execute();
$stmt->bind_result($ps_id);
$stmt->fetch();
$stmt->close();

if (empty($ps_id)) {
    die("Error: Parking Space ID not found for this booking.");
}

// Start a transaction for atomicity
$conn->begin_transaction();

try {
    // Delete the booking from bookinfo table
    $queryDelete = "DELETE FROM bookinfo WHERE b_id = ?";
    $stmtDelete = $conn->prepare($queryDelete);
    $stmtDelete->bind_param('i', $b_id);
    $stmtDelete->execute();
    
    // Check if booking was deleted successfully
    if ($stmtDelete->affected_rows > 0) {
        // Update parkSpace table to set ps_availableStat back to 'available'
        $queryUpdate = "UPDATE parkSpace SET ps_availableStat = 'available' WHERE ps_id = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param('i', $ps_id);
        $stmtUpdate->execute();

        // Commit transaction if everything is successful
        $conn->commit();
        
        // Redirect to a success page or back to booking list
        header("Location: bookList.php");
        exit();
    } else {
        throw new Exception("Error: Booking ID not found or could not delete booking.");
    }
} catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();
    die("Error: " . $e->getMessage());
}

$stmtDelete->close();
$conn->close();
?>
