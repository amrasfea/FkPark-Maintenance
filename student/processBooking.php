<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}

// Retrieve the user ID from the session
$u_id = $_SESSION['u_id'];

// Ensure all required POST data is set
$ps_id = $_POST['ps_id'] ?? '';
$parking_date = $_POST['parking_date'] ?? '';
$parking_time = $_POST['parking_time'] ?? '';
$vehicle_plate_number = $_POST['vehicle_plate_number'] ?? '';

if (empty($ps_id) || empty($parking_date) || empty($parking_time) || empty($vehicle_plate_number)) {
    die("Error: Missing required booking details.");
}

// Fetch the vehicle ID using the vehicle plate number
$query = "SELECT v_id FROM vehicle WHERE v_plateNum = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $vehicle_plate_number);
$stmt->execute();
$stmt->bind_result($v_id);
$stmt->fetch();
$stmt->close();

if (empty($v_id)) {
    die("Error: Vehicle not found.");
}

// Insert the booking details into the bookinfo table
$query = "INSERT INTO bookinfo (u_id, b_date, b_time, ps_id, b_platenum, v_id, b_status) VALUES (?, ?, ?, ?, ?, ?, 'Pending')";
$stmt = $conn->prepare($query);
$stmt->bind_param('isssii', $u_id, $parking_date, $parking_time, $ps_id, $vehicle_plate_number, $v_id);

if ($stmt->execute()) {
    // Booking successful, display the confirmation page
    $b_id = $stmt->insert_id;
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking Confirmation</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

    <?php include('../navigation/studentNav.php'); ?>

    <div class="container mt-5">
        <div class="alert alert-success" role="alert">
            Booking Successful! Your booking ID is <?php echo htmlspecialchars($b_id); ?>. It is now pending approval.
        </div>
        <a href="bookList.php" class="btn btn-primary">Go to Booking List</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
