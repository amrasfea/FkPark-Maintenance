<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if the current user is an administrator
if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

// Fetch total demerit points for each user and update their status
$query = "
    SELECT 
        profiles.u_id,
        SUM(summon.sum_demerit) as total_demerit
    FROM summon 
    JOIN vehicle ON summon.v_id = vehicle.v_id
    JOIN user ON vehicle.u_id = user.u_id
    JOIN profiles ON user.u_id = profiles.u_id
    GROUP BY profiles.u_id
";

$result = $conn->query($query);

// Debugging
if (!$result) {
    echo "Query Error: " . $conn->error;
    exit();
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $u_id = $row['u_id'];
        $total_demerit = $row['total_demerit'];

        // Debugging
        echo "User ID: " . $u_id . ", Total Demerit: " . $total_demerit . "<br>";

        if ($total_demerit < 20) {
            $status = 'Warning';
        } elseif ($total_demerit < 50) {
            $status = 'Revoke of in campus vehicle permission for 1 semester';
        } elseif ($total_demerit < 80) {
            $status = 'Revoke of in campus vehicle permission for 2 semesters';
        } else {
            $status = 'Revoke of in campus vehicle permission for entire study duration';
        }

        // Prepare and execute the update statement
        $updateStmt = $conn->prepare("UPDATE summon SET sum_status = ? WHERE v_id IN (SELECT v_id FROM vehicle WHERE u_id = ?)");
        $updateStmt->bind_param("si", $status, $u_id);

        if (!$updateStmt->execute()) {
            echo "Error updating status: " . $updateStmt->error;
        } else {
            echo "Status updated successfully for user ID: " . $u_id . "<br>";
        }

        $updateStmt->close();
    }
}

$conn->close();
?>

