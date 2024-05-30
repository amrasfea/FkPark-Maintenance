<?php
require '../session_check.php';
require '../config.php';
require '../phpqrcode/qrlib.php'; // Path to the PHP QR Code library

// Check if the current user is a student
if ($_SESSION['role'] !== 'Student') {
    header("Location: ../login2.php");
    exit();
}

// Retrieve the vehicle ID from the URL
$v_id = $_GET['v_id'];

// Fetch the vehicle information from the database
$stmt = $conn->prepare("SELECT v.*, p.p_name, p.p_course, p.p_icNumber 
                        FROM vehicle v 
                        JOIN profiles p ON v.u_id = p.u_id 
                        WHERE v.v_id = ?");
$stmt->bind_param("i", $v_id);
$stmt->execute();
$result = $stmt->get_result();
$vehicle = $result->fetch_assoc();
$stmt->close();

// Check if vehicle data is found
if (!$vehicle) {
    die("Vehicle not found");
}

// Concatenate vehicle information into a string
$vehicleInfo = "Name: " . $vehicle['p_name'] . "\n" .
               "Course: " . $vehicle['p_course'] . "\n" .
               "IC Number: " . $vehicle['p_icNumber'] . "\n" .
               "Vehicle Type: " . $vehicle['v_vehicleType'] . "\n" .
               "Brand: " . $vehicle['v_brand'] . "\n" .
               "Model: " . $vehicle['v_model'] . "\n" .
               "Plate Number: " . $vehicle['v_plateNum'] . "\n" .
               "Road Tax Valid: " . $vehicle['v_roadTaxValidDate'] . "\n" .
               "License Valid: " . $vehicle['v_licenceValidDate'] . "\n" .
               "License Class: " . $vehicle['v_licenceClass'] . "\n" .
               "Phone: " . $vehicle['v_phoneNum'] . "\n" .
               "Status: " . $vehicle['v_approvalStatus'];

// Generate the QR code
header('Content-Type: image/png');
QRcode::png($vehicleInfo, false, QR_ECLEVEL_L, 10);
?>

