<?php 
session_start();
require '../config.php'; // Database connection

// Check if the current user is a student
if ($_SESSION['role'] !== 'Student') {
    header("Location: ../login2.php");
    exit();
}

// Retrieve the user ID from the session
$u_id = $_SESSION['u_id'];

// Fetch all vehicle information for the student from the database
$vehicles = [];

$vehicleQuery = "SELECT v.*, p.p_name 
                 FROM vehicle v 
                 JOIN profiles p ON v.u_id = p.u_id 
                 WHERE v.u_id = ?";
$stmt = $conn->prepare($vehicleQuery);
$stmt->bind_param("i", $u_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $vehicles[] = $row;
}

$stmt->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Application</title>
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
</head>
<body>
    <?php include('../navigation/studentNav.php'); ?>
    <div class="container mt-5">
        <h2>Status Application</h2>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Vehicle Type</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Road Tax Valid Date</th>
                    <th>License Valid Date</th>
                    <th>License Class</th>
                    <th>Phone Number</th>
                    <th>Vehicle Grant</th>
                    <th>Approval Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehicles as $vehicle): ?>
                <tr>
                    <td><?php echo htmlspecialchars($vehicle['p_name']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['v_vehicleType']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['v_brand']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['v_model']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['v_roadTaxValidDate']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['v_licenceValidDate']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['v_licenceClass']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['v_phoneNum']); ?></td>
                    <td><a href="../uploads/<?php echo htmlspecialchars($vehicle['v_vehicleGrant']); ?>" target="_blank">View Grant</a></td>
                    <td><?php echo htmlspecialchars($vehicle['v_approvalStatus']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
