<?php
session_start();
require '../config.php'; // Database connection

// Check if the current user is a staff
if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $v_id = intval($_POST['v_id']);
    $action = $_POST['action'];

    // Update the approval status based on the action
    if ($action == 'Approve') {
        $status = 'Approved';
    } elseif ($action == 'Reject') {
        $status = 'Rejected';
    } else {
        $status = 'Pending';
    }

    // Update the vehicle status in the database
    $stmt = $conn->prepare("UPDATE vehicle SET v_approvalStatus = ? WHERE v_id = ?");
    $stmt->bind_param("si", $status, $v_id);

    if ($stmt->execute()) {
        echo "Application has been " . $status;
        header("Location: listVehicleApplication.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
