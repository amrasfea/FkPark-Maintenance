<?php
session_start();
require '../config.php'; // Database connection

// Check if the current user is a staff
if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

// Fetch vehicle details based on v_id from the URL
if (isset($_GET['v_id'])) {
    $v_id = intval($_GET['v_id']);

    $stmt = $conn->prepare("SELECT v.*, p.p_name, p.p_course, p.p_icNumber FROM vehicle v JOIN profiles p ON v.u_id = p.u_id WHERE v.v_id = ?");
    $stmt->bind_param("i", $v_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if vehicle details are found
    if ($result->num_rows > 0) {
        $vehicle = $result->fetch_assoc();
    } else {
        echo "No vehicle application found.";
        exit();
    }

    $stmt->close();
} else {
    echo "No vehicle ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registration</title>
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
</head>
<body>
    <?php include('../navigation/staffNav.php'); ?>
    <div class="container mt-5">
        <h2>View vehicle Application</h2>
        <div>
            <p>Type: <?php echo isset($vehicle['v_vehicleType']) ? $vehicle['v_vehicleType'] : 'N/A'; ?></p>
            <p>Brand: <?php echo isset($vehicle['v_brand']) ? $vehicle['v_brand'] : 'N/A'; ?></p>
            <p>Model: <?php echo isset($vehicle['v_model']) ? $vehicle['v_model'] : 'N/A'; ?></p>
            <p>Road Tax Valid Date: <?php echo isset($vehicle['v_roadTaxValidDate']) ? $vehicle['v_roadTaxValidDate'] : 'N/A'; ?></p>
            <p>Licence Valid Date: <?php echo isset($vehicle['v_licenceValidDate']) ? $vehicle['v_licenceValidDate'] : 'N/A'; ?></p>
            <p>Licence Class: <?php echo isset($vehicle['v_licenceClass']) ? $vehicle['v_licenceClass'] : 'N/A'; ?></p>
            <p>Phone Number: <?php echo isset($vehicle['v_phoneNum']) ? $vehicle['v_phoneNum'] : 'N/A'; ?></p>
            <p>Vehicle Grant: <a href="../uploads/<?php echo isset($vehicle['v_vehicleGrant']) ? $vehicle['v_vehicleGrant'] : ''; ?>" class="pdf">View Grant</a></p>
            <!-- Additional registration details go here -->
        </div>
        <!-- Back button to navigate to the listRegistration page -->
        <a href="../staff/listVehicleApplication.php" class="back-button">Back</a>
        
    </div>
</body>
</html>

