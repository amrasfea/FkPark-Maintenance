<?php
// Include database configuration file
include '../config.php';

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
        $result = mysqli_query($conn, $query);
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
    die("No parking spaces found.");
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
                    <button type="submit" name="search" class="search-button">Search</button>
                </div>
            </div>
        </form>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Select</th>
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
                    <tr id="row-<?php echo $space['ps_id']; ?>">
                        <td><input type="checkbox" class="select-checkbox" data-id="<?php echo $space['ps_id']; ?>"></td>
                        <td><?php echo htmlspecialchars($space['ps_area']); ?></td>
                        <td><?php echo isset($totalSpace[$space['ps_area']]) ? $totalSpace[$space['ps_area']] : 0; ?></td>
                        <td><?php echo htmlspecialchars($space['ps_id']); ?></td>
                        <td><?php echo htmlspecialchars($space['ps_availableStat']); ?></td>
                        <td><?php echo htmlspecialchars($space['ps_typeEvent']); ?></td>
                        <td><?php echo htmlspecialchars($space['ps_descriptionEvent']); ?></td>
                        <td>
                            <form method="post" action="editPark2.php" style="display:inline;">
                                <input type="hidden" name="pID" value="<?php echo $space['ps_id']; ?>">
                                <button type="submit" name="edit" class="edit-button">Edit</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <!-- Additional rows go here -->
            </tbody>
        </table>
        <div class="button-group mt-4">
            <button type="button" name="delete" class="delete-button" onclick="deleteSelected()">Delete Selected</button>
        </div>
    </div>

    <script>
        const stack = [];

        document.querySelectorAll('.select-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    stack.push(this.getAttribute('data-id'));
                } else {
                    const index = stack.indexOf(this.getAttribute('data-id'));
                    if (index > -1) {
                        stack.splice(index, 1);
                    }
                }
            });
        });

        function deleteSelected() {
            if (stack.length === 0) {
                alert('No parking spaces selected.');
                return;
            }

            if (confirm('Are you sure you want to delete the selected parking spaces?')) {
                fetch('deletePark2.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'pID': stack.join(',')
                    })
                })
                .then(response => response.text())
                .then(responseText => {
                    if (responseText.trim() === 'success') {
                        stack.forEach(id => {
                            const row = document.getElementById('row-' + id);
                            if (row) {
                                row.parentNode.removeChild(row); // Remove row from table
                            }
                        });
                        stack.length = 0; // Clear the stack
                        alert('Data deleted successfully!');
                    } else {
                        alert('Error deleting data: ' + responseText);
                    }
                })
                .catch(error => {
                    alert('Error deleting data: ' + error);
                });
            }
        }
    </script>
</body>
</html>