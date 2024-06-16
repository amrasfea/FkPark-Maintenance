<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if the current user is an administrator
if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

// Check if update button is clicked and data is submitted
if (isset($_POST['update']) && isset($_POST['sum_id']) && isset($_POST['p_name']) && isset($_POST['sum_vPlate']) && isset($_POST['sum_location']) && isset($_POST['sum_status'])) {
    $sum_id = $_POST['sum_id'];
    $p_name = $_POST['p_name'];
    $sum_vPlate = $_POST['sum_vPlate'];
    $sum_location = $_POST['sum_location'];
    $sum_status = $_POST['sum_status'];

    // Update the profiles table separately for the p_name
    $updateProfileStmt = $conn->prepare("UPDATE profiles 
                                         JOIN user ON profiles.u_id = user.u_id 
                                         JOIN vehicle ON user.u_id = vehicle.u_id 
                                         JOIN summon ON vehicle.v_id = summon.v_id 
                                         SET profiles.p_name = ? 
                                         WHERE summon.sum_id = ?");
    $updateProfileStmt->bind_param("si", $p_name, $sum_id);
    
    if (!$updateProfileStmt->execute()) {
        echo "<script>alert('Error updating profile: ".$conn->error."'); window.location.href = 'summonList.php';</script>";
        exit();
    }
    $updateProfileStmt->close();

    // Update the summon table
    $updateSummonStmt = $conn->prepare("UPDATE summon SET sum_vPlate = ?, sum_location = ?, sum_status = ? WHERE sum_id = ?");
    $updateSummonStmt->bind_param("sssi", $sum_vPlate, $sum_location, $sum_status, $sum_id);
    
    if ($updateSummonStmt->execute()) {
        echo "<script>alert('Record updated successfully'); window.location.href = 'summonList.php?message=update_success';</script>";
    } else {
        echo "<script>alert('Error updating summon: ".$conn->error."'); window.location.href = 'summonList.php';</script>";
    }
    
    $updateSummonStmt->close();
} else {
    header("Location: summonList.php");
    exit();
}
?>
