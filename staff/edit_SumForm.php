<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if the current user is an administrator
if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

if (isset($_GET['sum_id'])) {
    $sum_id = $_GET['sum_id'];

    // Fetch summon data for the given sum_id
    $query = "
        SELECT 
            summon.sum_date, 
            summon.sum_id, 
            summon.sum_vPlate, 
            summon.sum_location, 
            summon.sum_status, 
            profiles.p_name, 
            profiles.p_matricNum
        FROM summon 
        JOIN vehicle ON summon.v_id = vehicle.v_id
        JOIN user ON vehicle.u_id = user.u_id
        JOIN profiles ON user.u_id = profiles.u_id
        WHERE summon.sum_id = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $sum_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('No record found'); window.location.href = 'summon_list.php';</script>";
        exit();
    }

    $stmt->close();
} else {
    header("Location: summon_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Summon</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/form.css">
    <!--FAVICON-->
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
</head>
<body>
    <?php include('../navigation/staffNav.php'); ?>
    <div class="container mt-3">
        <h2>Edit Summon</h2>
        <form method="post" action="update_summon.php">
            <input type="hidden" name="sum_id" value="<?php echo htmlspecialchars($row['sum_id']); ?>">
            <div class="form-group">
                <label for="p_name">Vehicle Owner:</label>
                <input type="text" class="form-control" id="p_name" name="p_name" value="<?php echo htmlspecialchars($row['p_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="sum_vPlate">Plate Number:</label>
                <input type="text" class="form-control" id="sum_vPlate" name="sum_vPlate" value="<?php echo htmlspecialchars($row['sum_vPlate']); ?>" required>
            </div>
            <div class="form-group">
                <label for="sum_location">Location:</label>
                <input type="text" class="form-control" id="sum_location" name="sum_location" value="<?php echo htmlspecialchars($row['sum_location']); ?>" required>
            </div>
            <div class="form-group">
                <label for="sum_status">Status:</label>
                <input type="text" class="form-control" id="sum_status" name="sum_status" value="<?php echo htmlspecialchars($row['sum_status']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update">Update</button>
        </form>
    </div>
</body>
</html>
