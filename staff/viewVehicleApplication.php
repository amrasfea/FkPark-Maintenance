<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if the current user is a staff
if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

// Fetch vehicle details based on v_id from the URL
if (isset($_GET['v_id'])) {
    $v_id = intval($_GET['v_id']);

    // Updated query to include all necessary profile fields
    $stmt = $conn->prepare("
        SELECT v.*, 
               p.p_name, p.p_course, p.p_icNumber, p.p_matricNum, 
               p.p_email, p.p_phoneNum, p.p_address, p.p_faculty 
        FROM vehicle v 
        JOIN profiles p ON v.u_id = p.u_id 
        WHERE v.v_id = ?
    ");
    $stmt->bind_param("i", $v_id);
    $stmt->execute();
    $result = $stmt->get_result();

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

    <style>
        /* Structure */
.container {
    max-width: 800px;
    margin: 40px auto;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Section Headings */
.section {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #eeeeee;
}

.section h3 {
    font-size: 1.4em;
    color: #333333;
    border-left: 6px solid #007bff;
    padding-left: 10px;
    margin-bottom: 15px;
}

/* Data List */
.section ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.section ul li {
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
    font-size: 1em;
}

.section ul li strong {
    display: inline-block;
    width: 180px;
    color: #555555;
}

/* Links (e.g., View Grant) */
a.pdf {
    color: #007bff;
    text-decoration: underline;
    font-weight: bold;
}

/* Back Button */
.back-button {
    display: inline-block;
    margin-top: 20px;
    background-color: #007bff;
    color: #ffffff;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.back-button:hover {
    background-color: #0056b3;
}

        </style>
</head>
<body>
    <?php include('../navigation/staffNav.php'); ?>
    <div class="container mt-5">
        <h2>View Vehicle Application</h2>

        <!-- Student Information Section -->
        <div class="section">
            <h3>Student Information</h3>
            <ul>
                <li><strong>Full Name:</strong> <?php echo $vehicle['p_name'] ?? 'N/A'; ?></li>
                <li><strong>Matric Number:</strong> <?php echo $vehicle['p_matricNum'] ?? 'N/A'; ?></li>
                <li><strong>Course:</strong> <?php echo $vehicle['p_course'] ?? 'N/A'; ?></li>
                <li><strong>Faculty:</strong> <?php echo $vehicle['p_faculty'] ?? 'N/A'; ?></li>
                <li><strong>IC Number:</strong> <?php echo $vehicle['p_icNumber'] ?? 'N/A'; ?></li>
                <li><strong>Email:</strong> <?php echo $vehicle['p_email'] ?? 'N/A'; ?></li>
                <li><strong>Phone Number:</strong> <?php echo $vehicle['p_phoneNum'] ?? 'N/A'; ?></li>
                <li><strong>Address:</strong> <?php echo $vehicle['p_address'] ?? 'N/A'; ?></li>
            </ul>
        </div>

        <!-- Vehicle Information Section -->
        <div class="section">
            <h3>Vehicle Information</h3>
            <ul>
                <li><strong>Type:</strong> <?php echo $vehicle['v_vehicleType'] ?? 'N/A'; ?></li>
                <li><strong>Brand:</strong> <?php echo $vehicle['v_brand'] ?? 'N/A'; ?></li>
                <li><strong>Model:</strong> <?php echo $vehicle['v_model'] ?? 'N/A'; ?></li>
                <li><strong>Plate Number:</strong> <?php echo $vehicle['v_plateNum'] ?? 'N/A'; ?></li>
                <li><strong>Road Tax Valid Date:</strong> <?php echo $vehicle['v_roadTaxValidDate'] ?? 'N/A'; ?></li>
                <li><strong>Licence Valid Date:</strong> <?php echo $vehicle['v_licenceValidDate'] ?? 'N/A'; ?></li>
                <li><strong>Licence Class:</strong> <?php echo $vehicle['v_licenceClass'] ?? 'N/A'; ?></li>
                <li><strong>Phone Number:</strong> <?php echo $vehicle['v_phoneNum'] ?? 'N/A'; ?></li>
                <li><strong>Vehicle Grant:</strong>
                    <?php if (!empty($vehicle['v_vehicleGrant'])): ?>
                        <a href="../uploads/<?php echo $vehicle['v_vehicleGrant']; ?>" class="pdf" target="_blank">View Grant</a>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </li>
            </ul>
        </div>

        <!-- Back button -->
        <a href="../staff/listVehicleApplication.php" class="back-button">Back</a>
    </div>
</body>
</html>
