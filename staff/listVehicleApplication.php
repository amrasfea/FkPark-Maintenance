<?php
session_start();
require '../config.php'; // Database connection

// Check if the current user is a staff
if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

// Process form submission (approve or reject)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $v_id = $_POST['v_id'];
    $action = $_POST['action'];

    // Update vehicle application status based on the action
    if ($action === 'approve') {
        $status = 'Approve';
    } elseif ($action === 'reject') {
        $status = 'Reject';
    }

    $stmt = $conn->prepare("UPDATE vehicle SET v_approvalStatus = ? WHERE v_id = ?");
    $stmt->bind_param("si", $status, $v_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to refresh the page and reflect changes
    header("Location: listVehicleApplication.php");
    exit();
}

// Fetch all vehicle applications
$stmt = $conn->prepare("SELECT v.*, p.p_name, p.p_course, p.p_icNumber FROM vehicle v JOIN profiles p ON v.u_id = p.u_id");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Vehicle Application</title>
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <script>
        function confirmApproval(event, action) {
            if (action === 'approve') {
                if (!confirm('Are you sure you want to approve this application?')) {
                    event.preventDefault();
                }
            }
        }
    </script>
</head>
<body>
    <?php include('../navigation/staffNav.php'); ?>
    <div class="container mt-5">
        <h2>List Vehicle Registration</h2>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Vehicle ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>IC Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display all vehicle applications
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['v_id']}</td>
                        <td>{$row['p_name']}</td>
                        <td>{$row['p_course']}</td>
                        <td>{$row['p_icNumber']}</td>
                        <td>";
                    if ($row['v_approvalStatus'] == 'Pending') {
                        echo "<form method='post' action='' onsubmit='confirmApproval(event, this.action.value)'>
                                <input type='hidden' name='v_id' value='{$row['v_id']}'>
                                <button type='submit' name='action' value='approve' class='view-button'>Approve</button>
                                <button type='submit' name='action' value='reject' class='edit-button'>Reject</button>
                                <a href='../staff/viewVehicleApplication.php?v_id={$row['v_id']}' class='view-button'>View</a>
                            </form>";
                    } else {
                        echo "<a href='../staff/viewVehicleApplication.php?v_id={$row['v_id']}' class='view-button'>View</a>";
                    }
                    echo "</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

