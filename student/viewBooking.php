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
    <title>View Booking</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <h2>Booking Details</h2>
    <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($row['b_id']); ?></p>
    <p><strong>Parking Space ID:</strong> <?php echo htmlspecialchars($row['ps_id']); ?></p>
    <p><strong>Parking Date:</strong> <?php echo htmlspecialchars($row['b_date']); ?></p>
    <p><strong>Parking Time:</strong> <?php echo htmlspecialchars($row['b_time']); ?></p>
    <p><strong>Vehicle Plate Number:</strong> <?php echo htmlspecialchars($row['v_plateNum']); ?></p>
    <p><strong>Vehicle Brand:</strong> <?php echo htmlspecialchars($row['v_brand']); ?></p>
    <p><strong>Vehicle Model:</strong> <?php echo htmlspecialchars($row['v_model']); ?></p>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($row['p_name']); ?></p>
    <a href="bookList.php" class="btn btn-primary">Go to Booking List</a>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
