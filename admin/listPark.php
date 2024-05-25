<?php
// Simulated data for demonstration purposes
$parkingSpaces = [
    ['area' => 'A1', 'totalSpace' => 50, 'id' => 'A1-S22', 'status' => 'Available', 'typeEvent' => 'Concert', 'description' => 'Reserved for concert attendees', 'time' => '8:00 AM - 6:00 PM'],
    ['area' => 'B2', 'totalSpace' => 30, 'id' => 'B2-S30', 'status' => 'Occupied', 'typeEvent' => 'Covered', 'description' => 'Shaded area', 'time' => '9:00 AM - 5:00 PM'],
    // Add more parking spaces as needed
];

// Check if search query is set
if (isset($_POST['search'])) {
    $searchArea = $_POST['searchArea'];
    // Filter parking spaces by area
    $filteredSpaces = array_filter($parkingSpaces, function ($space) use ($searchArea) {
        return $space['area'] === $searchArea;
    });
} else {
    // If search query is not set, display all parking spaces
    $filteredSpaces = $parkingSpaces;
}
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
                    <input type="text" class="form-control" id="searchArea" name="searchArea">
                    <button type="submit" name="search" class="search-button">Search</button>
                </div>
            </div>
        </form>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Area</th>
                    <th>Total Spaces</th>
                    <th>Parking ID</th>
                    <th>Status</th>
                    <th>Type Event</th>
                    <th>Description</th>
                    <th>Action</th> <!-- Added Action column -->
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic generation of rows from filtered data -->
                <?php foreach ($filteredSpaces as $space): ?>
                    <tr id="<?php echo $space['id']; ?>">
                        <td><?php echo $space['area']; ?></td>
                        <td><?php echo $space['totalSpace']; ?></td>
                        <td><?php echo $space['id']; ?></td>
                        <td><?php echo $space['status']; ?></td>
                        <td><?php echo $space['typeEvent']; ?></td>
                        <td><?php echo $space['description']; ?></td>
                        <td>
                            <form method="post" action="editPark.php" style="display:inline;">
                                <input type="hidden" name="pID" value="<?php echo $space['id']; ?>">
                                <button type="submit" name="edit" class="edit-button">Edit</button>
                            </form>
                            <button type="button" name="delete" class="delete-button" onclick="confirmDelete('<?php echo $space['id']; ?>')">Delete</button>
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
                // Remove the row from the table
                var row = document.getElementById(parkingID);
                row.parentNode.removeChild(row);
                // Delete the data or perform any other action here
                alert('Data deleted successfully!');
            }
        }
    </script>
</body>
</html>
