<?php
session_start();
require '../config.php'; // Database connection

// Check if the current user is an administrator
if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

// Initialize variables to store receipt details
$sum_date = $_GET['sum_date'] ?? '';
$sum_id = $_GET['sum_id'] ?? '';
$p_name = $_GET['p_name'] ?? '';
$sum_vPlate = $_GET['sum_vPlate'] ?? '';
$p_matricNum = $_GET['p_matricNum'] ?? '';
$sum_location = $_GET['sum_location'] ?? '';
$sum_status = $_GET['sum_status'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <!--FAVICON-->
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .receipt-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .qr-image {
            display: block;
            margin: 0 auto 10px;
            max-width: 120px;
            height: 150px;
        }
        .qr-description {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
            display: block;
        }
        .receipt {
            margin-top: 20px;
        }
        .receipt label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include('../navigation/staffNav.php'); ?>
    <div class="receipt-container">
        <div class="receipt">
            <label>Date: <?php echo htmlspecialchars($sum_date); ?></label>
            <label>Summon ID: <?php echo htmlspecialchars($sum_id); ?></label>
            <label>Vehicle Owner: <?php echo htmlspecialchars($p_name); ?></label>
            <label>Plate Number: <?php echo htmlspecialchars($sum_vPlate); ?></label>
            <label>Matric ID: <?php echo htmlspecialchars($p_matricNum); ?></label>
            <label>Location: <?php echo htmlspecialchars($sum_location); ?></label>
            <label>Status: <?php echo htmlspecialchars($sum_status); ?></label>
        </div>
    </div>
</body>
</html>

