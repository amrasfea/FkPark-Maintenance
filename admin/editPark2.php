<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Get the Parking ID from the POST or GET data
$pID = $_POST['pID'] ?? $_GET['pID'] ?? null;

if ($pID) {
    // Prepare and execute the query to fetch the selected parking space
    $query = "SELECT * FROM parkSpace WHERE ps_id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $pID);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $selectedSpace = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
        } else {
            die("Error executing statement: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }

    // Calculate total space for the area of the selected parking space
    $totalSpaceQuery = "SELECT COUNT(*) as totalSpace FROM parkSpace WHERE ps_area = ?";
    if ($stmt = mysqli_prepare($conn, $totalSpaceQuery)) {
        mysqli_stmt_bind_param($stmt, "s", $selectedSpace['ps_area']);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $totalSpaceResult = mysqli_fetch_assoc($result);
            $totalSpace = $totalSpaceResult['totalSpace'] ?? 0;
            mysqli_free_result($result);
        } else {
            die("Error executing statement: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }
} else {
    die("No parking space ID provided.");
}

// Close connection
mysqli_close($conn);

// If the parking space is not found, display an error message
if (!$selectedSpace) {
    echo "<p>Parking space not found.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Park</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!--FAVICON-->
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>Edit Parking Space</h2>
        <form id="editForm" method="post" action="updateParking.php">
            <div class="form-group">
                <label for="pArea">Parking Area:</label>
                <input type="text" class="form-control" id="pArea" name="pArea" value="<?php echo htmlspecialchars($selectedSpace['ps_area']); ?>">

                <label for="totalSpace">Total Space:</label>
                <input type="text" class="form-control" id="totalSpace" name="totalSpace" value="<?php echo htmlspecialchars($totalSpace); ?>" readonly>

                <label for="pID">Parking ID:</label>
                <input type="text" class="form-control" id="pID" name="pID" value="<?php echo htmlspecialchars($selectedSpace['ps_id']); ?>" readonly>

                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="available" <?php if ($selectedSpace['ps_availableStat'] === 'available') echo 'selected'; ?>>available</option>
                        <option value="occupied" <?php if ($selectedSpace['ps_availableStat'] === 'occupied') echo 'selected'; ?>>occupied</option>
                    </select>
                </div>
               
                <label for="typeEvent">Type Event:</label>
                <input type="text" class="form-control" id="typeEvent" name="typeEvent" value="<?php echo htmlspecialchars($selectedSpace['ps_typeEvent']); ?>">

                <label for="description">Description:</label>
                <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($selectedSpace['ps_descriptionEvent']); ?>">
                
                <div id="date-time-fields">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="date" name="date" value="<?php echo htmlspecialchars($selectedSpace['ps_date']); ?>">
                    
                    <label for="time">Time:</label>
                    <input type="time" class="form-control" id="time" name="time" value="<?php echo htmlspecialchars($selectedSpace['ps_time']); ?>">
                </div>
            </div>
            <div class="button-group">
                <button type="button" name="cancel" onclick="cancelEdit()">Cancel</button>
                <button type="submit" name="save">Save</button>
            </div>
        </form>
    </div>

    <script>
        function cancelEdit() {
            // Redirect back to the list page
            window.location.href = 'listPark2.php';
        }

        // Hide date and time fields if status is "available"
        const statusInput = document.getElementById('status');
        const dateTimeFields = document.getElementById('date-time-fields');

        statusInput.addEventListener('input', function() {
            if (statusInput.value === 'available') {
                dateTimeFields.style.display = 'none';
            } else {
                dateTimeFields.style.display = 'block';
            }
        });

        // Trigger input event initially to check status on page load
        statusInput.dispatchEvent(new Event('input'));
    </script>
</body>
</html>
