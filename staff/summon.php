<?php
session_start();
require '../config.php'; // Database connection

// Check if the current user is an administrator
if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $type = $_POST["sum_vType"];
    $date = $_POST["sum_date"];
    $model = $_POST["sum_vModel"];
    $brand = $_POST["sum_vBrand"];
    $plate = $_POST["sum_vPlate"];
    $location = $_POST["sum_location"];
    $violation = $_POST["sum_violationType"];
    $demerit = $_POST["sum_demerit"];

    // Check if the provided plate number exists in the vehicle table
    $stmt = $conn->prepare("SELECT v_id FROM vehicle WHERE v_PlateNum = ?");
    $stmt->bind_param("s", $plate);
    $stmt->execute();
    $result = $stmt->get_result();
    // if data exist baru dia akan simpan data. 
    // Check if a matching record is found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $v_id = $row['v_id'];

        // Insert summon data along with the retrieved v_id
        $summon = "INSERT INTO summon (sum_date, sum_vModel, sum_vBrand, sum_vPlate, sum_location, sum_violationType, sum_demerit, v_id, sum_vType) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($summon);
        $stmt->bind_param("sssssssis", $date, $model, $brand, $plate, $location, $violation, $demerit, $v_id, $type);
        $stmt->execute();
        $stmt->close();

        $message = "issued successfully";

    } else {
        // Handle case where the provided plate number does not exist in the vehicle table
        $message = "Vehicle with plate number $plate not found. Proceed with manual summon";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summon</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/summon.css">
    <!--FAVICON-->
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <?php include('../navigation/staffNav.php'); ?>
    <div class="container mt-5">
        <h2>Ticket Summon Form</h2>
        <form method="post" action="summon.php">
            <div class="button-group">
                <button type="button" id="newFormBtn">New Form</button>
                <input type="date" name="sum_date" required>
                <!--input type="time" name="summonTime"-->
            </div>
            <div id="formFields" class="form-group hidden">
                <label for="sum_vType">Vehicle type:</label>
                <select name="sum_vType" id="sum_vType">
                    <option value="car">Car</option>
                    <option value="motorcycle">Motorcycle</option>
                </select>

                <label for="vModel">Vehicle Model:</label>
                <input type="text" class="form-control" id="vModel" name="sum_vModel" required>

                <label for="vBrand">Vehicle Brand:</label>
                <input type="text" class="form-control" id="vBrand" name="sum_vBrand" required>

                <label for="vPlate">Vehicle Plate Number:</label>
                <input type="text" class="form-control" id="vPlate" name="sum_vPlate" required>

                <label for="parkLoc">Parking Location:</label>
                <input type="text" class="form-control" id="parkLoc" name="sum_location" required>

                <label for="violation">Violation type:</label>
                <select name="sum_violationType" id="violation" onchange="fillDemerit()">
                    <option value="Parking">Parking Violation</option>
                    <option value="Traffic">Not comply in campus traffic regulations</option>
                    <option value="Accident">Caused accidents</option>
                </select>
                <label for="demerit">Demerit:</label>
                <input type="number" class="form-control" id="demerit" name="sum_demerit" readonly>
            </div>
            <div class="button-group">
                <button type="button" id="guideBtn">Traffic Violation Guide and Demerit</button>
            </div>

            <div class="button-group">
                <button type="submit" name="noti">Send Notification</button>
                <button type="submit" name="print">Print Receipt</button>
                <button type="submit" name="save" id="saveBtn">Save</button>
            </div>
        </form>
        <?php
        if (!empty($message)) {
            echo "<script>alert('$message');</script>";
        }
        ?>
    </div>

    <script>
        document.getElementById("newFormBtn").addEventListener("click", function() {
            document.getElementById("formFields").classList.remove("hidden");
        });

        function fillDemerit() {
            var violationType = document.getElementById("violation").value;
            var demeritInput = document.getElementById("demerit");
            // Set demerit points based on violation type
            switch (violationType) {
                case "Parking":
                    demeritInput.value = 10;
                    break;
                case "Traffic":
                    demeritInput.value = 15;
                    break;
                case "Accident":
                    demeritInput.value = 20;
                    break;
                default:
                    demeritInput.value = "";
                    break;
            }
        }
    </script>
    <script src="../js/staff.js"></script>
</body>
</html>
