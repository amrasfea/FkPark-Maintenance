<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}

// Retrieve booking details
$ps_id = $_GET['ps_id'] ?? '';
$parking_date = $_GET['parking_date'] ?? '';
$parking_time = $_GET['parking_time'] ?? '';

if (!$ps_id || !$parking_date || !$parking_time) {
    die("Error: Missing required booking details.");
}

// Fetch updated booking details
$query = "SELECT * FROM bookinfo WHERE u_id = '$u_id' AND ps_id = '$ps_id' AND b_date = '$parking_date' AND b_time = '$parking_time'";
$result = mysqli_query($conn, $query);
$booking = mysqli_fetch_assoc($result);

if (!$booking) {
    die("Error: Booking details not found.");
}

// Fetch vehicle details
$query = "SELECT v_brand, v_model FROM vehicles WHERE u_id = '$u_id'";
$vehicle_result = mysqli_query($conn, $query);
$vehicle = mysqli_fetch_assoc($vehicle_result);

// Fetch profile name
$query = "SELECT p_name FROM profiles WHERE u_id = '$u_id'";
$profile_result = mysqli_query($conn, $query);
$profile = mysqli_fetch_assoc($profile_result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Confirmation</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <h2>Parking Confirmation</h2>
    <p>Your parking details have been successfully confirmed.</p>
    <p><strong>Parking Space ID:</strong> <?php echo $booking['ps_id']; ?></p>
    <p><strong>Parking Date:</strong> <?php echo $booking['b_date']; ?></p>
    <p><strong>Parking Time:</strong> <?php echo $booking['b_time']; ?></p>
    <p><strong>Parking Start Time:</strong> <?php echo $booking['b_parkStart']; ?></p>
    <p><strong>Parking Duration:</strong> <?php echo $booking['b_duration']; ?> hours</p>
    <p><strong>Vehicle Brand:</strong> <?php echo $vehicle['v_brand']; ?></p>
    <p><strong>Vehicle Model:</strong> <?php echo $vehicle['v_model']; ?></p>
    <p><strong>User Name:</strong> <?php echo $profile['p_name']; ?></p>
    <a href="bookList.php" class="btn btn-primary">Go to Booking List</a>
</div>

</body>
</html>
