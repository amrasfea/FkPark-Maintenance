<?php
session_start();
require '../config.php'; // Database connection

// Check if the current user is an administrator
if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vtname = $_POST["vt_name"];
    $demerit = $_POST["vt_demeritPoints"];

    // Insert the new violation type
    $violation = "INSERT INTO violationtype (vt_name, vt_demeritPoints) VALUES (?, ?)";
    $stmt = $conn->prepare($violation);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("si", $vtname, $demerit);
    if ($stmt->execute()) {
        $response = [
            "status" => "success",
            "data" => [
                "vt_name" => $vtname,
                "vt_demeritPoints" => $demerit
            ]
        ];
    } else {
        $response = [
            "status" => "error",
            "message" => "Failed to insert violation type."
        ];
    }
    $stmt->close();
    echo json_encode($response);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violation Guideline</title>
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <link rel="stylesheet" href="../css/violation.css">
</head>
<body>
    <?php include('../navigation/staffNav.php'); ?>
    <div class="violation-page" id="main-content">
        <h2>Traffic Violation Guide and Demerit</h2>
        <table name="traffic" id="traffic-table">
            <tr>
                <th>Traffic Violation</th>
                <th>Demerit Points</th>
            </tr>
            <tr>
                <td>Parking violation</td>
                <td>10</td>
            </tr>
            <tr>
                <td>Not comply in campus traffic regulations</td>
                <td>15</td>
            </tr>
            <tr>
                <td>Accident caused</td>
                <td>20</td>
            </tr>
        </table>
        <button type="button" id="button">Add violation type</button>
        <div class="popup" id="popup">
            <div class="popup-content">
                <button class="close" id="close">&times;</button>
                <img src="../img/logo.png" alt="user">
                <form id="violation-form">
                    <input type="text" name="vt_name" placeholder="Violation Type" required>
                    <input type="number" name="vt_demeritPoints" placeholder="Demerit Points" required>
                    <button type="submit" class="button">Add</button>
                </form>
            </div>
        </div>
        <table>
            <tr>
                <th>Total point</th>
                <th>Enforcement type</th>
            </tr>
            <tr>
                <td>Less than 20 points</td>
                <td>Warning given</td>
            </tr>
            <tr>
                <td>Less than 50 points</td>
                <td>Revoke of in campus vehicle permission for 1 semester</td>
            </tr>
            <tr>
                <td>Less than 80 points</td>
                <td>Revoke of in campus vehicle permission for 2 semesters</td>
            </tr>
            <tr>
                <td>More than 80 points</td>
                <td>Revoke of in campus vehicle permission for entire study duration</td>
            </tr>
        </table>
        <button type="submit" name="edit">Print guide</button>
    </div>
    <script>
        document.getElementById("button").addEventListener("click", function() {
            document.getElementById("popup").classList.add("show");
            document.getElementById("main-content").classList.add("blur");
        });
        document.getElementById("close").addEventListener("click", function() {
            document.getElementById("popup").classList.remove("show");
            document.getElementById("main-content").classList.remove("blur");
        });

        document.getElementById("violation-form").addEventListener("submit", function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('violation.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `<td>${data.data.vt_name}</td><td>${data.data.vt_demeritPoints}</td>`;
                    document.getElementById('traffic-table').appendChild(newRow);
                    document.getElementById("popup").classList.remove("show");
                    document.getElementById("main-content").classList.remove("blur");
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
