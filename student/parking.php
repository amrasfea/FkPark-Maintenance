<?php
// Verify QR code and retrieve booking details from database
require '../config.php'; // Database connection

// Check if QR code data is passed via GET method
if (!isset($_GET['b_id'])) {
    die("Error: Booking ID not provided.");
}

$b_id = $_GET['b_id'];

// Fetch booking details from database using $b_id
$query = "SELECT * FROM bookinfo WHERE b_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $b_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $booking = $result->fetch_assoc();
    // Extract relevant booking information
    $ps_id = $booking['ps_id'];
    $parking_date = $booking['b_date'];
    $parking_time = $booking['b_time'];
    $vehicle_plate_number = $booking['b_platenum'];

    // Display parking form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Parking Page</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

    <div class="container mt-5">
        <h2>Parking Page</h2>
        <p>Car Plate Number: <?php echo htmlspecialchars($vehicle_plate_number); ?></p>
        <p>Parking Start Date: <?php echo htmlspecialchars($parking_date); ?></p>
        <p>Parking Start Time: <?php echo htmlspecialchars($parking_time); ?></p>
        <form action="processParking.php" method="post">
            <div class="form-group">
                <label for="duration">Expected Parking Duration (in hours):</label>
                <input type="number" id="duration" name="duration" class="form-control" required>
            </div>
            <input type="hidden" name="b_id" value="<?php echo $b_id; ?>">
            <input type="submit" value="Submit" class="btn btn-primary">
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
} else {
    die("Error: Booking not found.");
}

$stmt->close();
$conn->close();
?>
