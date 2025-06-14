<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if the current user is a student
if ($_SESSION['role'] !== 'Student') {
    header("Location: ../login2.php");
    exit();
}

// Validate and sanitize input
$sum_id = $_GET['sum_id'] ?? '';
$student_id = $_SESSION['u_id']; // assuming session 'id' = p_matricNum or unique student ID

if (empty($sum_id)) {
    echo "Invalid request. No Summon ID provided.";
    exit();
}

// Prepare and execute the query to fetch summon details
if ($sum_id) {
    $stmt = $conn->prepare("
        SELECT s.*, v.v_plateNum, u.u_email, p.p_name, p.p_matricNum
        FROM summon s
        JOIN vehicle v ON s.v_id = v.v_id
        JOIN user u ON v.u_id = u.u_id
        JOIN profiles p ON p.u_id = u.u_id
        WHERE s.sum_id = ?
    ");
    $stmt->bind_param("s", $sum_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $sum_date = $row['sum_date'];
        $p_name = $row['p_name'];
        $sum_vPlate = $row['v_plateNum'];
        $matricNum = $row['p_matricNum'];
        $sum_location = $row['sum_location'];
        $sum_status = $row['sum_status'];
    } else {
        // No data found
        echo "<script>alert('Summon not found.');window.location.href='inboxSum.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid Summon ID.');window.location.href='inboxSum.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Summon Receipt</title>
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f4f8;
            padding: 20px;
        }
        .receipt-container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .receipt-header {
            text-align: center;
        }
        .receipt-header img {
            max-width: 80px;
        }
        .receipt-header h2 {
            color: #0056b3;
        }
        .receipt-details label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
            color: #0056b3;
        }
        .receipt-details span {
            font-weight: normal;
            color: #333;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #0056b3;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
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
        <label>Date: <span><?= htmlspecialchars($sum_date) ?></span></label>
        <label>Summon ID: <span><?= htmlspecialchars($sum_id) ?></span></label>
        <label>Vehicle Owner: <span><?= htmlspecialchars($p_name) ?></span></label>
        <label>Plate Number: <span><?= htmlspecialchars($sum_vPlate) ?></span></label>
        <label>Matric ID: <span><?= htmlspecialchars($matricNum) ?></span></label>
        <label>Location: <span><?= htmlspecialchars($sum_location) ?></span></label>
        <label>Status: <span><?= htmlspecialchars($sum_status) ?></span></label>
    </div>
    <a href="../student/inboxSum.php" class="btn">Back</a>
</div>
</body>
</html>
