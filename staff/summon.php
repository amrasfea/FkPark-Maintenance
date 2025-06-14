<?php
require '../session_check.php';
require '../config.php';

if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

$message = "";
$vehicleData = null;
$userData = null;
$showSummonForm = false;

// 1. Handle plate search
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $plate = $_POST['search_plate'];
    $stmt = $conn->prepare("SELECT * FROM vehicle WHERE v_PlateNum = ?");
    $stmt->bind_param("s", $plate);
    $stmt->execute();
    $vehicleResult = $stmt->get_result();

    if ($vehicleResult->num_rows > 0) {
        $vehicleData = $vehicleResult->fetch_assoc();
                $user_id = $vehicleData['u_id'];

        // Fetch user info + profile (JOIN)
        $userStmt = $conn->prepare("
            SELECT user.u_id, user.u_email, profiles.p_name
            FROM user 
            INNER JOIN profiles ON user.u_id = profiles.u_id 
            WHERE user.u_id = ?
        ");
        $userStmt->bind_param("i", $user_id);  

        $userStmt->execute();
        $userResult = $userStmt->get_result();
        if ($userResult->num_rows > 0) {
            $userData = $userResult->fetch_assoc();
            $showSummonForm = true;
        }
    } else {
        $message = "Vehicle not found.";
    }
}


// 2. Handle summon submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $plate = $_POST["sum_vPlate"];
    $location = $_POST["sum_location"];
    $violation = $_POST["sum_violationType"];
    $demerit = $_POST["sum_demerit"];
    $date = $_POST["sum_date"];

    // Retrieve vehicle data again
    $stmt = $conn->prepare("SELECT * FROM vehicle WHERE v_PlateNum = ?");
    $stmt->bind_param("s", $plate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $vehicle = $result->fetch_assoc();
        $v_id = $vehicle['v_id'];
        $model = $vehicle['v_model'];
        $brand = $vehicle['v_brand'];
        $type = $vehicle['v_vehicleType'];

        $insert = "INSERT INTO summon (sum_date, sum_vModel, sum_vBrand, sum_vPlate, sum_location, sum_violationType, sum_demerit, v_id, sum_vType)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert);
        $stmt->bind_param("sssssssis", $date, $model, $brand, $plate, $location, $violation, $demerit, $v_id, $type);
        $stmt->execute();
        $stmt->close();

        $message = "Summon issued successfully.";
    } else {
        $message = "Vehicle not found. Cannot issue summon.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Summon Ticket</title>
    <link rel="stylesheet" href="../css/summon.css">
    <link rel="icon" href="../img/logo.png">
    <style>
        .readonly { background-color: #f2f2f2; }
    </style>
</head>
<body>
<?php include('../navigation/staffNav.php'); ?>
<div class="container mt-5">
    <h2>Summon Ticket</h2>

    <!-- 1. Plate Search Form -->
    <form method="post" action="summon.php">
        <input type="text" name="search_plate" placeholder="Enter Plate Number" required>
        <button type="submit" name="search">Summon</button>
        <button type="button" onclick="window.location.href='violation.php'">Guidelines</button>
    </form>

    <!-- 2. Summon Form (if plate found) -->
    <?php if ($showSummonForm && $vehicleData && $userData): ?>
        <form method="post" action="summon.php">
            <h4>Vehicle Info</h4>
            <input type="hidden" name="sum_vPlate" value="<?= htmlspecialchars($vehicleData['v_plateNum']) ?>">

            <b><label>Plate Number:</label></b>
            <input type="text" readonly class="readonly" value="<?= htmlspecialchars($vehicleData['v_plateNum']) ?>"><br>

            <b><label>Model:</label></b>
            <input type="text" readonly class="readonly" value="<?= htmlspecialchars($vehicleData['v_model']) ?>"><br>

            <b><label>Brand:</label></b>
            <input type="text" readonly class="readonly" value="<?= htmlspecialchars($vehicleData['v_brand']) ?>"><br>

            <b><label>Type:</label></b>
            <input type="text" readonly class="readonly" value="<?= htmlspecialchars($vehicleData['v_vehicleType']) ?>"><br><br>

            <h4>User Info</h4>
            <b><label>Owner Name:</label></b>
            <input type="text" readonly class="readonly" value="<?= htmlspecialchars($userData['p_name']) ?>"><br>

            <b><label>Owner Email:</label></b>
            <input type="email" readonly class="readonly" value="<?= htmlspecialchars($userData['u_email']) ?>"><br>

            <b><label>Date:</label></b>
            <input type="date" name="sum_date" id="sum_date" required><br>

            <b><label>Location:</label></b>
            <select name="sum_location" required>
                <option value="Zone A">Zone A</option>
                <option value="Zone B">Zone B</option>
            </select><br>

            <b><label>Violation Type:</label></b>
            <select name="sum_violationType" id="violation" onchange="fillDemerit()" required>
                <option value="Parking">Parking Violation</option>
                <option value="Traffic">Not comply in campus traffic regulations</option>
                <option value="Accident">Caused accidents</option>
            </select>

            <b><label>Demerit Points:</label></b>
            <input type="number" name="sum_demerit" id="demerit" readonly required><br><br>

            <div class="button-group">
                <button type="submit" name="save">Submit</button>
            </div>
        </form>
    <?php endif; ?>

    <!-- Message -->
    <?php if (!empty($message)) echo "<script>alert('$message');</script>"; ?>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const dateInput = document.getElementById("sum_date");
        if (dateInput) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.value = today;
        }
    });

    function fillDemerit() {
        const type = document.getElementById("violation").value;
        const demerit = document.getElementById("demerit");
        switch (type) {
            case "Parking": demerit.value = 10; break;
            case "Traffic": demerit.value = 15; break;
            case "Accident": demerit.value = 20; break;
            default: demerit.value = "";
        }
    }
</script>
<script src="../js/staff.js"></script>
</body>
</html>
