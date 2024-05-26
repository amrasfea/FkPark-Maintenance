<?php
// Include database configuration file
include '../config.php';

if (isset($_POST['pID'])) {
    $pIDs = explode(',', $_POST['pID']); // Get the list of IDs to delete

    // Prepare the delete statement
    $query = "DELETE FROM parkSpace WHERE ps_id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Loop through the IDs and delete each one
        foreach ($pIDs as $pID) {
            mysqli_stmt_bind_param($stmt, "s", $pID);
            if (!mysqli_stmt_execute($stmt)) {
                die("Error deleting data: " . mysqli_stmt_error($stmt));
            }
        }
        echo 'success';
    } else {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }

    // Close statement
    mysqli_stmt_close($stmt);
} else {
    die("No ID specified.");
}

// Close connection
mysqli_close($conn);
?>
