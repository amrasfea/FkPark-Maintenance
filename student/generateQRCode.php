<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../config.php';
require_once '../phpqrcode/qrlib.php'; // Ensure the path to phpqrcode is correct

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
           . "Phone Number: {$vehicle['v_phoneNum']}\n"
           . "Plate Number: {$vehicle['v_plateNum']}";

// Debug: Output the QR content
// echo nl2br(htmlspecialchars($qrContent));

header('Content-Type: image/png');

// Generate QR code and output it directly
QRcode::png($qrContent);
?>
