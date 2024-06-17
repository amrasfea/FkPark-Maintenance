<!-- by umairah -->
<?php
session_start(); // Start the session
require '../session_check.php';
require '../config.php'; // Database connection

// Initialize variables
$searchArea = "";

// Check if search query is set
if (isset($_POST['search'])) {
    $searchArea = $_POST['searchArea'];
    // Prepare a select statement with a search condition
    $query = "SELECT * FROM parkSpace WHERE ps_area LIKE ?";
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
        $area = $space['ps_area'];
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
                    <input type="text" class="form-control" id="searchArea" name="searchArea" value="<?php echo htmlspecialchars($searchArea); ?>">
                    <button type="submit" name="search" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Area</th>
                    <th>Total Space</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($_POST['search'])): ?>
                    <?php if (!empty($parkingSpaces)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($parkingSpaces[0]['ps_area']); ?></td>
                            <td><?php echo isset($totalSpace[$parkingSpaces[0]['ps_area']]) ? $totalSpace[$parkingSpaces[0]['ps_area']] : 0; ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">No results found for "<?php echo htmlspecialchars($searchArea); ?>".</td>
                        </tr>
                    <?php endif; ?>
                <?php else: ?>
                    <?php foreach ($totalSpace as $area => $total): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($area); ?></td>
                            <td><?php echo $total; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
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
                                <button type="submit" name="edit" class="btn btn-warning">Edit</button>
                            </form>
                            <button onclick="deleteParkingSpace('<?php echo $space['ps_id']; ?>')" class="btn btn-danger">Delete</button>
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
                console.log('Attempting to delete parking space with ID:', parkingSpaceId);

                const formData = new FormData();
                formData.append('pID', parkingSpaceId);

                fetch('deletePark2.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(responseText => {
                    console.log('Response from server:', responseText);
                    if (responseText.trim() === 'success') {
                        const row = document.getElementById('row-' + parkingSpaceId);
                        if (row) {
                            row.parentNode.removeChild(row); // Remove row from table
                            console.log('Row removed:', parkingSpaceId);
                        }
                    } else {
                        console.error('Error deleting park space:', responseText);
                    }
                })
                .catch(error => {
                    console.error('Error deleting park space:', error);
                });
            }
        }

    </script>

</body>
</html>
