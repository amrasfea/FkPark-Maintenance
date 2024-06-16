<?php
require '../session_check.php';
require '../config.php'; // Database connection

if (isset($_POST['pID'])) {
    $pID = $_POST['pID']; // Get the ID to delete

    // Prepare the delete statement
    $query = "DELETE FROM parkSpace WHERE ps_id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $pID);
        if (mysqli_stmt_execute($stmt)) {
            echo "success"; // Notify success
        } else {
            echo "Error deleting park space: " . mysqli_stmt_error($stmt);
        }
    } else {
        echo "Failed to prepare statement: " . mysqli_error($conn);
    }

    // Close statement
    mysqli_stmt_close($stmt);
} else {
    echo "No ID specified.";
}

// Close connection
mysqli_close($conn);
?>
