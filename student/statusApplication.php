<?php 
session_start();
require '../config.php'; // Database connection

// Check if the current user is a student
if ($_SESSION['role'] !== 'Student') {
    header("Location: ../login.php");
    exit();
}

// Retrieve the user ID from the session
$u_id = $_SESSION['u_id'];

// Get the vehicle ID from the URL parameters
$v_id = isset($_GET['v_id']) ? intval($_GET['v_id']) : 0;

// Fetch the vehicle information from the database
$stmt = $conn->prepare("SELECT v.*, p.p_name FROM vehicle v JOIN profiles p ON v.u_id = p.u_id WHERE v.v_id = ? AND v.u_id = ?");
$stmt->bind_param("ii", $v_id, $u_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $vehicle = $result->fetch_assoc();
} else {
    die("No vehicle information found.");
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Application</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!--FAVICON-->
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
                    <th>Status</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <!-- Display vehicle information -->
                <tr>
                    <td><?php echo htmlspecialchars($vehicle['p_name']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['v_vehicleType']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['v_brand']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['v_model']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['v_roadTaxValidDate']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['v_licenceValidDate']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['v_licenceClass']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['v_phoneNum']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['v_approvalStatus']); ?></td>
                    <td>Submitted for approval</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
