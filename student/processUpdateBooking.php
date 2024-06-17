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
$ps_availableStat = $_POST['ps_availableStat'] ?? ''; // Get the selected availability status

if (empty($b_id) || empty($parking_date) || empty($parking_time) || empty($b_parkStart) || empty($b_duration) || empty($v_id) || empty($ps_availableStat)) {
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
        // Fetch ps_id associated with the booking
        $query_fetch_ps_id = "SELECT ps_id FROM bookinfo WHERE b_id = ?";
        $stmt_fetch_ps_id = $conn->prepare($query_fetch_ps_id);
        $stmt_fetch_ps_id->bind_param('i', $b_id);
        $stmt_fetch_ps_id->execute();
        $result_fetch_ps_id = $stmt_fetch_ps_id->get_result();

        if ($result_fetch_ps_id->num_rows > 0) {
            $row_fetch_ps_id = $result_fetch_ps_id->fetch_assoc();
            $ps_id = $row_fetch_ps_id['ps_id'];

            // Update parking space availability status in parkspace table
            $query_update_ps = "UPDATE parkspace SET ps_availableStat = ? WHERE ps_id = ?";
            $stmt_update_ps = $conn->prepare($query_update_ps);
            $stmt_update_ps->bind_param('ss', $ps_availableStat, $ps_id);
            
            if ($stmt_update_ps->execute()) {
                echo "Update successful.";
                // Redirect to booking list page
                header("Location: bookList.php");
                exit;
            } else {
                // Error handling for parkspace update
                echo "Error updating parkspace availability status: " . $stmt_update_ps->error;
            }

            $stmt_update_ps->close();
        } else {
            // No ps_id found for the booking
            echo "Error: Parking space ID not found for the booking.";
        }

        $stmt_fetch_ps_id->close();
    } else {
        // Error handling for booking info update
        echo "Error updating booking information: " . $stmt_update->error;
    }

    $stmt_update->close();
} else {
    // No vehicle found with the provided v_id
    echo "Error: Vehicle details not found for the selected vehicle ID.";
}

$stmt_fetch_plate->close();
$conn->close();
?>

