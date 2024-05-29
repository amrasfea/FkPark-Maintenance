<?php
require '../config.php';
include('../libs/phpqrcode/qrlib.php'); // Include the library

if (!isset($_GET['v_id'])) {
    die("Vehicle ID is required.");
}

$v_id = intval($_GET['v_id']);

// Fetch vehicle information from the database
$stmt = $conn->prepare("SELECT v.*, p.p_name 
                        FROM vehicle v 
                        JOIN profiles p ON v.u_id = p.u_id 
                        WHERE v.v_id = ?");
$stmt->bind_param("i", $v_id);
$stmt->execute();
$result = $stmt->get_result();
$vehicle = $result->fetch_assoc();

if (!$vehicle) {
    die("Vehicle not found.");
}

$stmt->close();

// Generate QR code content
$qrContent = "Name: {$vehicle['p_name']}\n"
           . "Vehicle Type: {$vehicle['v_vehicleType']}\n"
           . "Brand: {$vehicle['v_brand']}\n"
           . "Model: {$vehicle['v_model']}\n"
           . "Road Tax Valid Date: {$vehicle['v_roadTaxValidDate']}\n"
           . "License Valid Date: {$vehicle['v_licenceValidDate']}\n"
           . "License Class: {$vehicle['v_licenceClass']}\n"
           . "Phone Number: {$vehicle['v_phoneNum']}";

// Output QR code
header('Content-Type: image/png');
QRcode::png($qrContent);
?>
