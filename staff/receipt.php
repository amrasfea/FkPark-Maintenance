<?php
require '../session_check.php';
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

// Function to handle notification (dummy function for example purposes)
function sendNotification($sum_id, $p_name, $sum_status) {
    // Here you would add code to send a notification, e.g., email or SMS.
    // For now, we'll just return a success message.
    return "Notification sent to $p_name regarding summon $sum_id with status $sum_status.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notify'])) {
    $notificationMessage = sendNotification($sum_id, $p_name, $sum_status);
    echo "<script>alert('$notificationMessage');</script>";
}
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
            background-color: #f2f4f8;
            color: #333;
        }
        .receipt-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #dcdde1;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 20px;
            color: #444;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-header img {
            max-width: 80px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .receipt-header h2 {
            margin: 10px 0;
            color: #0056b3;
        }
        .receipt-details {
            margin-bottom: 20px;
        }
        .receipt-details label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #0056b3;
        }
        .receipt-details span {
            font-weight: normal;
            color: #333;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        .receipt-footer a {
            color: #0056b3;
            text-decoration: none;
        }
        .receipt-footer a:hover {
            text-decoration: underline;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .notify-button {
            background-color: #0056b3;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .notify-button:hover {
            background-color: #003d82;
        }
    </style>
</head>
<body>
    <?php include('../navigation/staffNav.php'); ?>
    <div class="receipt-container">
        <div class="receipt-header">
            <img src="../img/logo.png" alt="Logo">
            <h2>Summon Receipt</h2>
        </div>
        <div class="receipt-details">
            <label>Date: <span><?php echo htmlspecialchars($sum_date); ?></span></label>
            <label>Summon ID: <span><?php echo htmlspecialchars($sum_id); ?></span></label>
            <label>Vehicle Owner: <span><?php echo htmlspecialchars($p_name); ?></span></label>
            <label>Plate Number: <span><?php echo htmlspecialchars($sum_vPlate); ?></span></label>
            <label>Matric ID: <span><?php echo htmlspecialchars($p_matricNum); ?></span></label>
            <label>Location: <span><?php echo htmlspecialchars($sum_location); ?></span></label>
            <label>Status: <span><?php echo htmlspecialchars($sum_status); ?></span></label>
        </div>
        <div class="button-container">
            <form method="POST">
                <button type="submit" name="notify" class="notify-button">Notify</button>
            </form>
        </div>
        <div class="receipt-footer">
            <p>Copy &copy Unit Keselamtan</p>
        </div>
    </div>
</body>
</html>
