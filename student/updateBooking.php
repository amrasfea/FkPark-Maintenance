<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if booking ID is set in the query string
$b_id = $_GET['b_id'] ?? '';

if (empty($b_id)) {
    die("Error: Booking ID is not set.");
}

// Fetch the booking details
$query = "
    SELECT 
        b.*, 
        v.v_plateNum, 
        v.v_brand, 
        v.v_model, 
        p.p_name 
    FROM 
        bookinfo b
    JOIN 
        vehicle v ON b.v_id = v.v_id
    JOIN 
        profiles p ON b.u_id = p.u_id
    WHERE 
        b.b_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $b_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    // Data is fetched successfully
} else {
    die("Error: Booking not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Booking</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <h2>Update Booking</h2>
    <form action="processUpdateBooking.php" method="post">
        <input type="hidden" name="b_id" value="<?php echo htmlspecialchars($row['b_id']); ?>">
        <div class="form-group">
            <label for="ps_id">Parking Space ID:</label>
            <input type="text" id="ps_id" name="ps_id" class="form-control" value="<?php echo htmlspecialchars($row['ps_id']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="parking_date">Parking Date:</label>
            <input type="date" id="parking_date" name="parking_date" class="form-control" value="<?php echo htmlspecialchars($row['b_date']); ?>" required>
        </div>
        <div class="form-group">
            <label for="parking_time">Parking Time:</label>
            <input type="time" id="parking_time" name="parking_time" class="form-control" value="<?php echo htmlspecialchars($row['b_time']); ?>" required>
        </div>
        <div class="form-group">
            <label for="vehicle_plateNum">Vehicle Plate Number:</label>
            <input type="text" id="vehicle_plateNum" name="vehicle_plateNum" class="form-control" value="<?php echo htmlspecialchars($row['v_plateNum']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="vehicle_brand">Vehicle Brand:</label>
            <input type="text" id="vehicle_brand" name="vehicle_brand" class="form-control" value="<?php echo htmlspecialchars($row['v_brand']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="vehicle_model">Vehicle Model:</label>
            <input type="text" id="vehicle_model" name="vehicle_model" class="form-control" value="<?php echo htmlspecialchars($row['v_model']); ?>" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Update Booking</button>
    </form>
    <a href="bookList.php" class="btn btn-secondary mt-2">Go to Booking List</a>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
