<?php
// Include database configuration file
include('../connect.php'); // Adjust the path as needed

// Initialize variables
$searchArea = "";

// Check if search query is set
if (isset($_POST['search'])) {
    $searchArea = $_POST['searchArea'];
    // Prepare a select statement with a search condition
    $query = "SELECT * FROM parkSpace WHERE ps_area LIKE ?";
    $param = "%" . $searchArea . "%";
    if ($stmt = mysqli_prepare($con, $query)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param);
        // Execute the statement
        mysqli_stmt_execute($stmt);
        // Get result
        $result = mysqli_stmt_get_result($stmt);
    } else {
        die("Failed to prepare statement: " . mysqli_error($con));
    }
} else {
    // If search query is not set, fetch all parking spaces
    $query = "SELECT * FROM parkSpace";
    $result = mysqli_query($con, $query);
}

// Fetch the result into an array
$parkingSpaces = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $parkingSpaces[] = $row;
    }
    // Free result set
    mysqli_free_result($result);
    
    // Calculate total space for each area
    $totalSpace = [];
    foreach ($parkingSpaces as $space) {
        $area = $space['ps_area'];
        if (!isset($totalSpace[$area])) {
            $totalSpace[$area] = 0;
        }
        $totalSpace[$area]++;
    }
} else {
    die("Failed to execute query: " . mysqli_error($con));
}

// Close connection
mysqli_close($con);
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
                    <button type="submit" name="search" class="search-button">Search</button>
                </div>
            </div>
        </form>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Area</th>
                    <th>Total Space</th>
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
                    <tr id="<?php echo $space['ps_id']; ?>">
                        <td><?php echo htmlspecialchars($space['ps_area']); ?></td>
                        <td><?php echo isset($totalSpace[$space['ps_area']]) ? $totalSpace[$space['ps_area']] : 0; ?></td>
                        <td><?php echo htmlspecialchars($space['ps_id']); ?></td>
                        <td><?php echo htmlspecialchars($space['ps_availableStat']); ?></td>
                        <td><?php echo htmlspecialchars($space['ps_typeEvent']); ?></td>
                        <td><?php echo htmlspecialchars($space['ps_descriptionEvent']); ?></td>
                        <td>
                            <form method="post" action="editPark.php" style="display:inline;">
                                <input type="hidden" name="pID" value="<?php echo $space['ps_id']; ?>">
                                <button type="submit" name="edit" class="edit-button">Edit</button>
                            </form>
                            <button type="button" name="delete" class="delete-button" onclick="confirmDelete('<?php echo $space['ps_id']; ?>')">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <!-- Additional rows go here -->
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete(parkingID) {
            if (confirm('Are you sure you want to delete this parking space?')) {
                // Perform the deletion from the database using AJAX or a form submission
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "deletePark.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert('Data deleted successfully!');
                        // Remove the row from the table
                        var row = document.getElementById(parkingID);
                        row.parentNode.removeChild(row);
                    }
                };
                xhr.send("pID=" + parkingID);
            }
        }
    </script>
</body>
</html>
