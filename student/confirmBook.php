<!-- confirm booking -->
<!-- by auni -->

<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}
// Retrieve the user ID from the session
$u_id = $_SESSION['u_id'];

// Retrieve form data
$ps_id = $_POST['ps_id'] ?? '';
$parking_date = $_POST['parking_date'] ?? '';
$parking_time = $_POST['parking_time'] ?? '';
$vehicle_plate_number = $_POST['vehicle_plate_number'] ?? '';

// Initialize variables
$p_name = '';
$vehicle_brand = '';
$vehicle_model = '';

// Fetch user profile information
$query = "SELECT p_name FROM profiles WHERE u_id = '$u_id'";
$result = mysqli_query($conn, $query); // Use $conn from config.php

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $p_name = $row['p_name'];
} else {
    echo "Error: " . mysqli_error($conn);
}

// Fetch vehicle information
$query = "SELECT v_brand, v_model FROM vehicle WHERE v_plateNum = '$vehicle_plate_number'";
$result = mysqli_query($conn, $query); // Use $conn from config.php

if ($result && mysqli_num_rows($result) > 0) { // Check if there are rows returned
    $row = mysqli_fetch_assoc($result);
    $vehicle_brand = $row['v_brand'];
    $vehicle_model = $row['v_model'];
} else {
    echo "Error fetching vehicle information: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking</title>
    <link rel="stylesheet" href="../css/park.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <h2>Confirm Booking</h2>
    <form action="processBooking.php" method="post">
        <div class="form-group">
            <label for="p_name">Name:</label>
            <input type="text" id="p_name" name="p_name" class="form-control" value="<?php echo htmlspecialchars($p_name); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="ps_id">Parking Space ID:</label>
            <input type="text" id="ps_id" name="ps_id" class="form-control" value="<?php echo htmlspecialchars($ps_id); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="parking_date">Parking Date:</label>
            <input type="text" id="parking_date" name="parking_date" class="form-control" value="<?php echo htmlspecialchars($parking_date); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="parking_time">Parking Time:</label>
            <input type="text" id="parking_time" name="parking_time" class="form-control" value="<?php echo htmlspecialchars($parking_time); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="vehicle_plate_number">Vehicle Plate Number:</label>
            <input type="text" id="vehicle_plate_number" name="vehicle_plate_number" class="form-control" value="<?php echo htmlspecialchars($vehicle_plate_number); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="vehicle_brand">Vehicle Brand:</label>
            <input type="text" id="vehicle_brand" name="vehicle_brand" class="form-control" value="<?php echo htmlspecialchars($vehicle_brand); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="vehicle_model">Vehicle Model:</label>
            <input type="text" id="vehicle_model" name="vehicle_model" class="form-control" value="<?php echo htmlspecialchars($vehicle_model); ?>" readonly>
        </div>
        <input type="submit" value="Confirm Booking" class="btn btn-success">
    </form><br>
    <form action="bookForm.php" method="post" class="mt-3">
        <input type="hidden" name="ps_id" value="<?php echo htmlspecialchars($ps_id); ?>">
        <input type="hidden" name="parking_date" value="<?php echo htmlspecialchars($parking_date); ?>">
        <input type="hidden" name="parking_time" value="<?php echo htmlspecialchars($parking_time); ?>">
        <input type="hidden" name="vehicle_plate_number" value="<?php echo htmlspecialchars($vehicle_plate_number); ?>">
        <input type="submit" value="Back" class="btn btn-primary">
    </form>
</div>
</div>

</body>
</html>
