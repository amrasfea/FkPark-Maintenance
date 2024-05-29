<?php
session_start();
require '../config.php'; // Database connection

// Check if the current user is an administrator
if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date =$_POST["sum_date"];
    $model = $_POST["sum_vModel"];
    $brand = $_POST["sum_vBrand"];
    $plate = $_POST["sum_vPlate"];
    $location = $_POST["sum_location"];
    $violation = $_POST["sum_violationType"];
    $demerit = $_POST["sum_demerit"];

    // Create new user with the specified role
    $summon = "INSERT INTO summon (sum_date, sum_vModel, sum_vBrand, sum_vPlate, sum_location, sum_violationType, sum_demerit) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($summon);
    $stmt->bind_param("sss", $date, $model, $brand, $plate, $location, $violation, $demerit);
    $stmt->execute();
    $userId = $stmt->insert_id;
    $stmt->close();

    // Create student profile
    $profileQuery = "INSERT INTO profiles (p_name, p_email, p_course, p_faculty, p_icNumber, p_address, p_postCode, p_country, p_state, u_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($profileQuery);
    $stmt->bind_param("sssssssssi", $name, $email, $course, $faculty, $icNumber, $address, $postCode, $country, $state, $userId);
    $stmt->execute();
    $stmt->close();

    // Redirect to the list registration page with the newly registered student information
    header("Location: listregistration.php?newly_registered_id=$userId");
    exit();
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
                <input type="date" name="sum_date">
                <!--input type="time" name="summonTime"-->
            </div>
            <div id="formFields" class="form-group hidden">
                <label for="vType">Vehicle type:</label>
                <select name="vType" id="vType">
                    <option value="car">Car</option>
                    <option value="motorcycle">Motorcycle</option>
                </select>

                <label for="vModel">Vehicle Model:</label>
                <input type="text" class="form-control" id="vModel" name="sum_vModel">

                <label for="vBrand">Vehicle Brand:</label>
                <input type="text" class="form-control" id="vBrand" name="sum_vBrand">

                <label for="vPlate">Vehicle Plate Number:</label>
                <input type="text" class="form-control" id="vPlate" name="sum_vPlate">

                <label for="parkLoc">Parking Location:</label>
                <input type="text" class="form-control" id="parkLoc" name="sum_location">

                <label for="violation">Violation type:</label>
                <select name="sum_violationType" id="violation" onchange="fillDemerit()">
                    <option value="Parking">Parking Violation</option>
                    <option value="Traffic">Not comply in campus traffic regulations</option>
                    <option value="Accident">Caused accidents</option>
                </select>
                <label for="demerit">Demerit:</label>
                <input type="text" class="form-control" id="demerit" name="sum_demerit">
            </div>
            <div class="button-group">
                <button type="button" id="guideBtn">Traffic Violation Guide and Demerit</button>
            </div>

            <div class="button-group">
                <button type="submit" name="noti">Send Notification</button>
                <button type="submit" name="print">Print Receipt</button>
                <button type="submit" name="save">Save</button>
            </div>
        </form>
    </div>

    <script>
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
