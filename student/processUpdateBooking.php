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
$v_id = $_POST['vehicle_plateNum'] ?? ''; // Get the selected vehicle id

if (empty($b_id) || empty($parking_date) || empty($parking_time) || empty($b_parkStart) || empty($b_duration) || empty($v_id)) {
    die("Error: Missing required booking details.");
}

// Fetch the vehicle plate number associated with the selected v_id
$query_fetch_plate = "SELECT v_plateNum FROM vehicle WHERE v_id = ?";
$stmt_fetch_plate = $conn->prepare($query_fetch_plate);
$stmt_fetch_plate->bind_param('i', $v_id);
$stmt_fetch_plate->execute();
$result_fetch_plate = $stmt_fetch_plate->get_result();

if ($result_fetch_plate->num_rows > 0) {
    $row_fetch_plate = $result_fetch_plate->fetch_assoc();
    $v_plateNum = $row_fetch_plate['v_plateNum'];

    // Update the booking details in the bookinfo table
    $query_update = "UPDATE bookinfo SET b_date = ?, b_time = ?, b_parkStart = ?, b_duration = ?, v_id = ?, b_platenum = ? WHERE b_id = ?";
    $stmt_update = $conn->prepare($query_update);
    $stmt_update->bind_param('ssssisi', $parking_date, $parking_time, $b_parkStart, $b_duration, $v_id, $v_plateNum, $b_id);
    

    if ($stmt_update->execute()) {
        // Debugging output for successful execution
        echo "Update successful.";
        // Redirect to booking list page
        header("Location: bookList.php");
        exit;
    } else {
        // Error handling
        echo "Error: " . $stmt_update->error;
    }

    $stmt_update->close();
} else {
    // No vehicle found with the provided v_id
    echo "Error: Vehicle details not found for the selected vehicle ID.";
}

$stmt_fetch_plate->close();
$conn->close();


?>
