<?php
require '../session_check.php';
require '../config.php'; // Database connection
require 'phpqrcode/qrlib.php'; // Include the PHP QR Code library

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}

// Retrieve the booking details from the URL
$ps_id = $_GET['ps_id'] ?? '';
$parking_date = $_GET['parking_date'] ?? '';
$parking_time = $_GET['parking_time'] ?? '';

if (!$ps_id || !$parking_date || !$parking_time) {
    die("Error: Missing required booking details.");
}

// Generate QR code data
$qr_data = "http://yourwebsite.com/student/parkingPage.php?ps_id=$ps_id&parking_date=$parking_date&parking_time=$parking_time";
$qr_file = '../qrcodes/' . $ps_id . '.png';
QRcode::png($qr_data, $qr_file, 'L', 10, 2);

// Close the database connection
mysqli_close($conn);
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
    <h2>Booking Confirmation</h2>
    <p>Your booking has been successfully confirmed.</p>
    <p><strong>Parking Space ID:</strong> <?php echo $ps_id; ?></p>
    <p><strong>Parking Date:</strong> <?php echo $parking_date; ?></p>
    <p><strong>Parking Time:</strong> <?php echo $parking_time; ?></p>
    <p><strong>QR Code:</strong></p>
    <img src="<?php echo $qr_file; ?>" alt="QR Code">
    <br><br>
    <a href="bookList.php" class="btn btn-primary">Go to Booking List</a>
</div>

</body>
</html>
