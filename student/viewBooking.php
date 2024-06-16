<!-- view dettail booking-->
<!-- by auni -->



<?php
require '../session_check.php';
require '../config.php'; // Database connection
require '../phpqrcode/qrlib.php'; // PHP QR Code library

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

    $local_ip = '192.168.0.113'; // Replace with your local IP address or domain
    // URL to updateBooking.php with booking ID
    $updateBookingUrl = "http://$local_ip/FKPark/student/updateBooking.php?b_id=$b_id";

    // Generate QR code data
    $qrData = "Booking ID: " . $row['b_id'] . "\n"
            . "Parking Space ID: " . $row['ps_id'] . "\n"
            . "Parking Date: " . $row['b_date'] . "\n"
            . "Parking Time: " . $row['b_time'] . "\n"
            . "Vehicle Plate Number: " . $row['v_plateNum'] . "\n"
            . "Update URL: " . $updateBookingUrl;

    // Path to save the QR code image
    $qrFilename = "../qrcodes/booking_" . $row['b_id'] . ".png";
    
    // Generate QR code
    QRcode::png($qrData, $qrFilename, 'L', 4, 2);
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
    <link rel="stylesheet" href="../css/park.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
    
        .qr-code {
            margin-top: 20px;
            text-align: center;
        }
        .booking-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }
        .booking-details h2 {
            margin-bottom: 20px;
        }
        .booking-details p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <div class="booking-details">
        <h2>Booking Details</h2>
        <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($row['b_id']); ?></p>
        <p><strong>Parking Space ID:</strong> <?php echo htmlspecialchars($row['ps_id']); ?></p>
        <p><strong>Parking Date:</strong> <?php echo htmlspecialchars($row['b_date']); ?></p>
        <p><strong>Parking Time:</strong> <?php echo htmlspecialchars($row['b_time']); ?></p>
        <p><strong>Vehicle Plate Number:</strong> <?php echo htmlspecialchars($row['v_plateNum']); ?></p>
        <p><strong>Vehicle Brand:</strong> <?php echo htmlspecialchars($row['v_brand']); ?></p>
        <p><strong>Vehicle Model:</strong> <?php echo htmlspecialchars($row['v_model']); ?></p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($row['p_name']); ?></p>
        
        <!-- Display QR code -->
        <div class="qr-code">
            <h4>QR Code</h4>
            <img src="<?php echo $qrFilename; ?>" alt="Booking QR Code" class="img-fluid">
        </div>
        
        <a href="bookList.php" class="btn btn-primary mt-3">Go to Booking List</a>
    </div>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
