<?php
session_start(); // Start the session
require '../session_check.php';
require '../config.php'; // Database connection

// Get data from the form
$pID = $_POST['pID'] ?? null;
$pArea = $_POST['pArea'] ?? null;
$status = $_POST['status'] ?? null;
$typeEvent = $_POST['typeEvent'] ?? null;
$description = $_POST['description'] ?? null;
$date = $_POST['date'] ?? null;
$time = $_POST['time'] ?? null;
$searchArea = $_POST['searchArea'] ?? null; // Added to retrieve search area

// Check if all required fields are provided
if ($pID && $pArea && $status && $typeEvent && $description && $date && $time && $searchArea) {
    // Prepare and execute the query to update the parking space
    $query = "UPDATE parkSpace SET ps_area = ?, ps_availableStat = ?, ps_typeEvent = ?, ps_descriptionEvent = ?, ps_date = ?, ps_time = ? WHERE ps_id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "sssssss", $pArea, $status, $typeEvent, $description, $date, $time, $pID);
        if (mysqli_stmt_execute($stmt)) {
            // Redirect back to listPark2.php after successful update, include search area in the URL
            header("Location: listPark2.php?searchArea=" . urlencode($searchArea));
            exit();
        } else {
            die("Error executing statement: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }
} else {
    // Set the error message in the session
    $_SESSION['error_message'] = "All fields are required.";
    // Redirect back to listPark2.php after successful update, include search area in the URL
    header("Location: listPark2.php?searchArea=" . urlencode($searchArea));
    exit();
}

// Close connection
mysqli_close($conn);
?>
