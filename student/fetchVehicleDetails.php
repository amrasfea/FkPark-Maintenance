<?php
require '../config.php'; // Database connection

// Check if v_id is set in the POST request
if (!isset($_POST['v_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vehicle ID not provided.']);
    exit;
}

$v_id = $_POST['v_id'];

// Prepare query to fetch vehicle details based on vehicle ID
$query = "SELECT v_brand, v_model FROM vehicle WHERE v_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $v_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Vehicle details found
    $row = $result->fetch_assoc();
    $vehicleDetails = [
        'v_brand' => $row['v_brand'],
        'v_model' => $row['v_model']
    ];
    echo json_encode(['success' => true, 'data' => $vehicleDetails]);
} else {
    // No vehicle found with the provided vehicle ID
    echo json_encode(['success' => false, 'message' => 'Vehicle details not found.']);
}

$stmt->close();
$conn->close();
?>
