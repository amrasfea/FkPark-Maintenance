<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}

// Retrieve the booking details from the URL or GET parameters
$ps_id = $_GET['ps_id'] ?? '';
$parking_date = $_GET['parking_date'] ?? '';
$parking_time = $_GET['parking_time'] ?? '';

if (!$ps_id || !$parking_date || !$parking_time) {
    die("Error: Missing required booking details.");
}

// Fetch vehicle details and profile name
$query = "SELECT v_brand, v_model FROM vehicles WHERE u_id = '$u_id'";
$vehicle_result = mysqli_query($conn, $query);
$vehicle = mysqli_fetch_assoc($vehicle_result);

$query = "SELECT p_name FROM profiles WHERE u_id = '$u_id'";
$profile_result = mysqli_query($conn, $query);
$profile = mysqli_fetch_assoc($profile_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Details</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <h2>Parking Details</h2>
    <form action="processParking.php" method="post">
        <input type="hidden" name="ps_id" value="<?php echo $ps_id; ?>">
        <input type="hidden" name="parking_date" value="<?php echo $parking_date; ?>">
        <input type="hidden" name="parking_time" value="<?php echo $parking_time; ?>">
        <div class="form-group">
            <label for="vehicle_plate_number">Vehicle Plate Number:</label>
            <input type="text" id="vehicle_plate_number" name="vehicle_plate_number" class="form-control" value="<?php echo $vehicle['v_model']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="parking_start_time">Parking Start Time:</label>
            <input type="time" id="parking_start_time" name="parking_start_time" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="parking_duration">Parking Duration (hours):</label>
            <input type="number" id="parking_duration" name="parking_duration" class="form-control" required>
        </div>
        <input type="submit" value="Confirm Parking" class="btn btn-primary">
    </form>
</div>

</body>
</html>
