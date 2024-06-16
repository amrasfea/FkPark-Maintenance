<?php
require '../session_check.php';
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

    // Set a session variable to indicate the action was taken
    $_SESSION['action_taken'] = $action;

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
            let confirmationMessage = '';
            if (action === 'approve') {
                confirmationMessage = 'Are you sure you want to approve this application?';
            } else if (action === 'reject') {
                confirmationMessage = 'Are you sure you want to reject this application?';
            }
            if (!confirm(confirmationMessage)) {
                event.preventDefault();
            }
        }

        function showAlertMessage() {
            <?php
            if (isset($_SESSION['action_taken'])) {
                $message = '';
                if ($_SESSION['action_taken'] === 'approve') {
                    $message = 'Application approved successfully.';
                } elseif ($_SESSION['action_taken'] === 'reject') {
                    $message = 'Application rejected successfully.';
                }
                echo "alert('$message');";
                unset($_SESSION['action_taken']); // Clear the session variable
            }
            ?>
        }

        window.onload = showAlertMessage;
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
                    <th>Vehicle Brand</th>
                    <th>Vehicle Model</th>
                    <th>Plate Number</th>
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
                        <td>{$row['v_brand']}</td>
                        <td>{$row['v_model']}</td>
                        <td>{$row['v_plateNum']}</td>
                        <td>";
                    if ($row['v_approvalStatus'] == 'Pending') {
                        echo "<form method='post' action='' onsubmit='confirmApproval(event, this.action.value)'>
                                <input type='hidden' name='v_id' value='{$row['v_id']}'>
                                <button type='submit' name='action' value='approve' class='btn btn-success'>Approve</button>
                                <button type='submit' name='action' value='reject' class='btn btn-danger'>Reject</button>
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
