<?php
session_start(); // Start the session

require '../session_check.php';
require '../config.php'; // Database connection

// Initialize variables
$searchArea = "";

// Check if search query is set
if (isset($_POST['search'])) {
    $searchArea = $_POST['searchArea'];
    // Prepare a select statement with a case-insensitive search condition
    $query = "SELECT * FROM parkSpace WHERE LOWER(ps_area) LIKE LOWER(?)";
    $param = "%" . $searchArea . "%";
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param);
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Get result
            $result = mysqli_stmt_get_result($stmt);
        } else {
            die("Error executing statement: " . mysqli_stmt_error($stmt));
        }
    } else {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }
} else {
    // If search query is not set, fetch all parking spaces
    $query = "SELECT * FROM parkSpace";
    if ($result = mysqli_query($conn, $query)) {
        // Get result
    } else {
        die("Failed to execute query: " . mysqli_error($conn));
    }
}

// Fetch the result into an array
$parkingSpaces = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $parkingSpaces[] = $row;
    }
    // Free result set
    mysqli_free_result($result);

    // Calculate total and occupied spaces for each area
    $totalSpace = [];
    $occupiedSpace = [];
    $eventSpace = [];

    foreach ($parkingSpaces as $space) {
        $area = strtolower($space['ps_area']);
        if (!isset($totalSpace[$area])) {
            $totalSpace[$area] = 0;
            $occupiedSpace[$area] = 0;
            $eventSpace[$area] = 0; // Initialize event space count here
        }
        $totalSpace[$area]++;
        if ($space['ps_availableStat'] == 'occupied') {
            $occupiedSpace[$area]++;
        }
        if ($space['ps_typeEvent'] !== '-') {
            // Increment event space count only if the space is not occupied and used for an event
            if ($space['ps_availableStat'] == 'occupied') {
                $eventSpace[$area]++;
            }
        }
    }

    // Store the parking data in session
    $_SESSION['parkingData'] = [
        'totalSpace' => $totalSpace,
        'occupiedSpace' => $occupiedSpace,
        'eventSpace' => $eventSpace
    ];
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Park Space</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!--FAVICON-->
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>List Park Space</h2>
        <form method="post" action="" class="search-form">
            <div class="form-group">
                <label for="searchArea">Park Area:</label>
                <div class="search-input-group">
                    <input type="text" class="form-control" id="searchArea" name="searchArea" placeholder="A1,A2,A3,A4,B1,B2,B3" value="<?php echo htmlspecialchars($searchArea); ?>">
                    <button type="submit" name="search" class="search-button">Search</button>
                </div>
            </div>
        </form>

        <?php if (!empty($searchArea)): ?>
            <?php $searchAreaLower = strtolower($searchArea); ?>
            <?php if (isset($totalSpace[$searchAreaLower])): ?>
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Area</th>
                        <th>Total Space</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($searchArea); ?></td>
                        <td><?php echo $totalSpace[$searchAreaLower]; ?></td>
                    </tr>
                </tbody>
            </table>
            <?php else: ?>
            <p>No results found for '<?php echo htmlspecialchars($searchArea); ?>'</p>
            <?php endif; ?>
        <?php endif; ?>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Parking ID</th>
                    <th>Status</th>
                    <th>Type Event</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic generation of rows from database data -->
                <?php foreach ($parkingSpaces as $space): ?>
                    <tr id="row-<?php echo $space['ps_id']; ?>">
                        <td><?php echo htmlspecialchars($space['ps_id']); ?></td>
                        <td><?php echo htmlspecialchars($space['ps_availableStat']); ?></td>
                        <td><?php echo htmlspecialchars($space['ps_typeEvent']); ?></td>
                        <td><?php echo htmlspecialchars($space['ps_descriptionEvent']); ?></td>
                        <td>
                            <form method="post" action="editPark2.php" style="display:inline;">
                                <input type="hidden" name="pID" value="<?php echo $space['ps_id']; ?>">
                                <button type="submit" name="edit" class="edit-button">Edit</button>
                            </form>
                            <button onclick="deleteParkingSpace('<?php echo $space['ps_id']; ?>')" class="delete-button">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <!-- Additional rows go here -->
            </tbody>
        </table>
    </div>

    <script>
        function deleteParkingSpace(parkingSpaceId) {
            if (confirm('Are you sure you want to delete this park space?')) {
                const formData = new FormData();
                formData.append('pID', parkingSpaceId);

                fetch('deletePark2.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(responseText => {
                    if (responseText.trim() === 'success') {
                        const row = document.getElementById('row-' + parkingSpaceId);
                        if (row) {
                            row.parentNode.removeChild(row); // Remove row from table
                        }
                    } else {
                        console.error('Error deleting park space: ' + responseText);
                    }
                })
                .catch(error => {
                    console.error('Error deleting park space: ' + error);
                });
            }
        }
    </script>

</body>
</html>
