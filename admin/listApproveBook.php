<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Process form submission (approve or reject)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['ps_id'])) {
    $ps_id = $_POST['ps_id'];
    $action = $_POST['action'];
    $status = ($action === 'approve') ? 'Available' : 'Occupied';

    $stmt = $conn->prepare("UPDATE parkspace SET ps_availableStat = ? WHERE ps_id = ?");
    if ($stmt) {
        $stmt->bind_param("si", $status, $ps_id);
        if ($stmt->execute()) {
            $_SESSION['action_taken'] = $action;
        } else {
            $_SESSION['error'] = "Failed to update booking status.";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Failed to prepare the statement.";
    }

    header("Location: listApproveBook.php");
    exit();
}

// Fetch all park space bookings for areas B1, B2, and B3 that are not yet approved
$query = "
    SELECT 
        b.b_id, b.u_id, b.b_date, b.b_time, b.b_parkStart, b.b_duration, b.b_status, b.b_QRid, b.v_id, b.ps_id, b.b_platenum, 
        p.ps_area, p.ps_category, p.ps_date, p.ps_time, p.ps_typeEvent, p.ps_descriptionEvent, p.ps_QR, p.ps_availableStat,
        pr.p_name, pr.p_course, pr.p_faculty, pr.p_icNumber, pr.p_email, pr.p_phoneNum, pr.p_address, pr.p_postCode, pr.p_country, pr.p_state, pr.p_department, pr.p_bodyNumber, pr.p_position, pr.p_matricNum
    FROM bookinfo b
    JOIN parkspace p ON b.ps_id = p.ps_id
    JOIN profiles pr ON b.u_id = pr.u_id
    WHERE p.ps_area IN ('B1', 'B2', 'B3') AND p.ps_availableStat = 'Pending'
";

$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    $pendingBookings = ($result->num_rows > 0);
    $stmt->close();
} else {
    die("Failed to prepare the query: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Park Space Bookings</title>
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <script>
        function confirmApproval(event, action) {
            let confirmationMessage = action === 'approve' ? 'Are you sure you want to approve this booking?' : 'Are you sure you want to reject this booking?';
            if (!confirm(confirmationMessage)) {
                event.preventDefault();
            }
        }

        function showAlertMessage() {
            <?php
            if ($pendingBookings) {
                echo "alert('New booking request received.');";
            }

            if (isset($_SESSION['action_taken'])) {
                $message = ($_SESSION['action_taken'] === 'approve') ? 'Booking approved successfully.' : 'Booking rejected successfully.';
                echo "alert('$message');";
                unset($_SESSION['action_taken']);
            } elseif (isset($_SESSION['error'])) {
                echo "alert('{$_SESSION['error']}');";
                unset($_SESSION['error']);
            }
            ?>
        }

        window.onload = showAlertMessage;
    </script>
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>List Park Space Bookings</h2>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Park Space ID</th>
                    <th>Area</th>
                    <th>Parking Date</th>
                    <th>Parking Time</th>
                    <th>Plate Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['ps_id']}</td>
                        <td>{$row['ps_area']}</td>
                        <td>{$row['b_date']}</td>
                        <td>{$row['b_time']}</td>
                        <td>{$row['b_platenum']}</td>
                        <td>{$row['ps_availableStat']}</td>
                        <td>";
                    if ($row['ps_availableStat'] == 'Pending') {
                        echo "<form method='post' action='' onsubmit='confirmApproval(event, this.action.value)'>
                                <input type='hidden' name='ps_id' value='{$row['ps_id']}'>
                                <button type='submit' name='action' value='approve' class='view-button'>Approve</button>
                                <button type='submit' name='action' value='reject' class='edit-button'>Reject</button>
                            </form>";
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
