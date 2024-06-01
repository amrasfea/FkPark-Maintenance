<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}

$userId = $_SESSION['u_id'];

// Check if summon ID is passed as a parameter
if (!isset($_GET['id'])) {
    die("Error: Summon ID is not set in the URL.");
}

$sumId = $_GET['id'];

// Query to fetch specific summon details based on summon ID
$sql = "SELECT summon.*, vehicle.*, user.*, profiles.*
        FROM summon 
        INNER JOIN vehicle ON summon.v_id = vehicle.v_id 
        INNER JOIN user ON vehicle.u_id = user.u_id 
        INNER JOIN profiles ON user.u_id = profiles.u_id
        WHERE user.u_id = $userId AND summon.sum_id = $sumId";

$result = $conn->query($sql);

// Check if query executed successfully and fetch the data
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Assign values to variables
    $sum_date = $row['sum_date'];
    $sum_id = $row['sum_id'];
    $p_name = $row['p_name'];
    $sum_vPlate = $row['sum_vPlate'];
    $p_matricNum = $row['p_matricNum'];
    $sum_location = $row['sum_location'];
    $sum_status = $row['sum_status'];
} else {
    // Handle case when no data is found
    die("Error: Summon details not found.");
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
            transition: background-color 0.3s ease;
        }
        .notify-button:hover {
            background-color: #003d82;
        }
    </style>
</head>
<body>
<?php include('../navigation/studentNav.php'); ?>
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
        <div class="receipt-footer">
            <p>Copy &copy; Unit Keselamatan UMPSA</p>
        </div>
    </div>
</body>
</html>
