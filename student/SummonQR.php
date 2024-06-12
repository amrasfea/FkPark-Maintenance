<?php
require '../session_check.php';
require '../config.php';
require '../phpqrcode/qrlib.php'; // Path to the PHP QR Code library

// Check if the current user is a student
if ($_SESSION['role'] !== 'Student') {
    header("Location: ../login2.php");
    exit();
}

// Retrieve the summon ID from the URL and validate it
$sumId = isset($_GET['sum_id']) ? intval($_GET['sum_id']) : 0;

// Check if the user ID is set in the session
$userId = isset($_SESSION['u_id']) ? intval($_SESSION['u_id']) : 0;

// Check if $sumId and $userId are valid
if ($sumId == 0 || $userId == 0) {
    die("Invalid request");
}

// Prepare the SQL statement to fetch summon details
if ($stmt = $conn->prepare("SELECT summon.*, vehicle.*, user.*, profiles.*
                            FROM summon 
                            INNER JOIN vehicle ON summon.v_id = vehicle.v_id 
                            INNER JOIN user ON vehicle.u_id = user.u_id 
                            INNER JOIN profiles ON user.u_id = profiles.u_id
                            WHERE user.u_id = ? AND summon.sum_id = ?")) {
    $stmt->bind_param("ii", $userId, $sumId);
    $stmt->execute();
    $result = $stmt->get_result();
    $summon = $result->fetch_assoc();
    $stmt->close();

    // Check if summon data is found
    if (!$summon) {
        die("Summon not found");
    }

    // Concatenate summon information into a string
    $summonInfo = "Name: " . $summon['p_name'] . "\n" .
                  "Course: " . $summon['p_course'] . "\n" .
                  "IC Number: " . $summon['p_icNumber'] . "\n" .
                  "Vehicle Type: " . $summon['v_vehicleType'] . "\n" .
                  "Brand: " . $summon['v_brand'] . "\n" .
                  "Model: " . $summon['v_model'] . "\n" .
                  "Plate Number: " . $summon['v_plateNum'] . "\n" .
                  "Summon Date: " . $summon['sum_date'] . "\n" .
                  "Violation Type: " . $summon['sum_violationType'] . "\n" . 
                  "Demerit Point: " . $summon['sum_demerit'] . "\n". 
                  "Current Status: " . $summon['sum_status'] . "\n";

    // Filepath to save the QR code image
    $qrCodeFilePath = '../qrcodes/summon_' . $sumId . '.png';

    // Generate the QR code and save it to a file
    QRcode::png($summonInfo, $qrCodeFilePath, QR_ECLEVEL_L, 10);

    // Redirect to the HTML page to display the QR code
    header("Location: displaySumQR.php?file=" . urlencode($qrCodeFilePath));
    exit();
} else {
    die("Failed to prepare the SQL statement.");
}
?>
