<?php
// Simulated data for demonstration purposes
$parkingSpaces = [
    ['area' => 'A1', 'totalSpace' => 50, 'id' => 'A1-S22', 'status' => 'Available', 'typeEvent' => 'Concert', 'description' => 'Reserved for concert attendees', 'time' => '8:00 AM - 6:00 PM'],
    ['area' => 'B2', 'totalSpace' => 30, 'id' => 'B2-S30', 'status' => 'Occupied', 'typeEvent' => 'Covered', 'description' => 'Shaded area', 'time' => '9:00 AM - 5:00 PM'],
    // Add more parking spaces as needed
];

// Get the Parking ID from the URL
$pID = $_GET['pID'];

// Find the parking space with the given ID
$selectedSpace = null;
foreach ($parkingSpaces as $space) {
    if ($space['id'] === $pID) {
        $selectedSpace = $space;
        break;
    }
}

// If the parking space is not found, display an error message
if ($selectedSpace === null) {
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
        <form id="editForm" method="post" action="#">
            <div class="form-group">
                <label for="pArea">Parking Area:</label>
                <input type="text" class="form-control" id="pArea" name="pArea" value="<?php echo $selectedSpace['area']; ?>">

                <label for="totalSpace">Total Space:</label>
                <input type="text" class="form-control" id="totalSpace" name="totalSpace" value="<?php echo $selectedSpace['totalSpace']; ?>">

                <label for="pID">Parking ID:</label>
                <input type="text" class="form-control" id="pID" name="pID" value="<?php echo $selectedSpace['id']; ?>" readonly>

                <label for="status">Status:</label>
                <input type="text" class="form-control" id="status" name="status" value="<?php echo $selectedSpace['status']; ?>">

                <label for="typeEvent">Type Event:</label>
                <input type="text" class="form-control" id="typeEvent" name="typeEvent" value="<?php echo $selectedSpace['typeEvent']; ?>">

                <label for="description">Description:</label>
                <input type="text" class="form-control" id="description" name="description" value="<?php echo $selectedSpace['description']; ?>">

                <label for="time">Time:</label>
                <input type="text" class="form-control" id="time" name="time" value="<?php echo $selectedSpace['time']; ?>">

            </div>
            <div class="button-group">
                <button type="button" name="cancel" onclick="cancelEdit()">Cancel</button>
                <button type="button" name="save" onclick="saveData()">Save</button>
            </div>
        </form>
    </div>

    <script>
        function cancelEdit() {
            // Redirect back to the list page
            window.location.href = 'listPark.php';
        }

        function saveData() {
            // Perform AJAX request to updateParking.php or your backend endpoint
            // On success, show an alert message and redirect to the list page
            // For demonstration, I'm showing an alert directly here
            alert('Data saved successfully!');
            window.location.href = 'listPark.php'; // Redirect to the list page
        }
    </script>
</body>
</html>
