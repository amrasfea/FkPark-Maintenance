<?php
// Include database configuration file
include '../config.php';

// Get data from the form
$pID = $_POST['pID'] ?? null;
$pArea = $_POST['pArea'] ?? null;
$status = $_POST['status'] ?? null;
$typeEvent = $_POST['typeEvent'] ?? null;
$description = $_POST['description'] ?? null;

// Check if all required fields are provided
if ($pID && $pArea && $status && $typeEvent && $description) {
    // Prepare and execute the query to update the parking space
    $query = "UPDATE parkSpace SET ps_area = ?, ps_availableStat = ?, ps_typeEvent = ?, ps_descriptionEvent = ? WHERE ps_id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "sssss", $pArea, $status, $typeEvent, $description, $pID);
        if (mysqli_stmt_execute($stmt)) {
            // Redirect back to listPark2.php after successful update
            header("Location: listPark2.php");
            exit();
        } else {
            die("Error executing statement: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }
} else {
    die("All fields are required.");
}

// Close connection
mysqli_close($conn);
?>