<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}
// Retrieve the user ID from the session
$u_id = $_SESSION['u_id'];

// Initialize variables to prevent undefined variable warnings
$ps_id = $_GET['ps_id'] ?? '';
$parking_date = $_GET['parking_date'] ?? '';
$parking_time = $_GET['parking_time'] ?? '';
$vehicle_plate_number = $_POST['vehicle_plate_number'] ?? '';

// Debugging: Print out received parameters
echo "ps_id: $ps_id<br>";
echo "parking_date: $parking_date<br>";
echo "parking_time: $parking_time<br>";

// Get parking area from parkspace table using ps_id
if (!empty($ps_id)) {
    $query = "SELECT ps_area FROM parkspace WHERE ps_id = '$ps_id'";
    $result = mysqli_query($conn, $query); // Use $conn from config.php

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $parking_area = $row['ps_area'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <h2>Booking Form</h2>
    <form action="confirmBook.php" method="post">
        <div class="form-group">
            <label for="ps_id">Parking Space ID:</label>
            <input type="text" id="ps_id" name="ps_id" class="form-control" value="<?php echo $ps_id; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="parking_date">Parking Date:</label>
            <input type="text" id="parking_date" name="parking_date" class="form-control" value="<?php echo $parking_date; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="parking_time">Parking Time:</label>
            <input type="text" id="parking_time" name="parking_time" class="form-control" value="<?php echo $parking_time; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="vehicle_plate_number">Vehicle Plate Number:</label>
            <input type="text" id="vehicle_plate_number" name="vehicle_plate_number" class="form-control" required>
        </div>
        <input type="submit" value="Submit" class="btn btn-primary">
    </form>
</div>

</body>
</html>
