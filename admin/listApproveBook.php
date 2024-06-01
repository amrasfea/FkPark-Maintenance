<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Process form submission (approve or reject)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $ps_id = $_POST['ps_id'];
    $action = $_POST['action'];

    // Update park space booking status based on the action
    if ($action === 'approve') {
        $status = 'Available';
    } elseif ($action === 'reject') {
        $status = 'Occupied';
    }

    $stmt = $conn->prepare("UPDATE parkSpace SET ps_availableStat = ? WHERE ps_id = ?");
    $stmt->bind_param("si", $status, $ps_id);
    $stmt->execute();
    $stmt->close();

    // Set a session variable to indicate the action was taken
    $_SESSION['action_taken'] = $action;

    // Redirect to refresh the page and reflect changes
    header("Location: listApproveBook.php");
    exit();
}

// Fetch all park space bookings for areas B1, B2, and B3
$stmt = $conn->prepare("SELECT * FROM parkSpace WHERE ps_area IN ('B1', 'B2', 'B3')");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
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
            let confirmationMessage = '';
            if (action === 'approve') {
                confirmationMessage = 'Are you sure you want to approve this booking?';
            } else if (action === 'reject') {
                confirmationMessage = 'Are you sure you want to reject this booking?';
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
                    $message = 'Booking approved successfully.';
                } elseif ($_SESSION['action_taken'] === 'reject') {
                    $message = 'Booking rejected successfully.';
                }
                echo "alert('$message');";
                unset($_SESSION['action_taken']); // Clear the session variable
            }

            if (isset($_SESSION['new_booking'])) {
                echo "alert('New booking request received.');";
                unset($_SESSION['new_booking']); // Clear the session variable
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
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display all park space bookings
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['ps_id']}</td>
                        <td>{$row['ps_area']}</td>
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

