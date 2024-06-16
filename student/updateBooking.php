<!-- update booking page-->
<!-- by auni -->


<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if booking ID is set in the query string
$b_id = $_GET['b_id'] ?? '';

if (empty($b_id)) {
    die("Error: Booking ID is not set.");
}

// Fetch the booking details
$query = "
    SELECT 
        b.*, 
        v.v_id,
        v.v_plateNum, 
        v.v_brand, 
        v.v_model, 
        p.p_name,
        ps.ps_availableStat 
    FROM 
        bookinfo b
    JOIN 
        vehicle v ON b.v_id = v.v_id
    JOIN 
        profiles p ON b.u_id = p.u_id
    JOIN 
        parkspace ps ON b.ps_id = ps.ps_id
    WHERE 
        b.b_id = ? AND
        b.b_status = 'Approved' 
";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $b_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    // Data is fetched successfully
} else {
    die("Error: Booking not found or not approved.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Booking</title>
    <link rel="stylesheet" href="../css/park.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <h2>Update Booking</h2>
    <form id="updateBookingForm" action="processUpdateBooking.php" method="post">
        <input type="hidden" name="b_id" value="<?php echo htmlspecialchars($row['b_id']); ?>">
        <div class="form-group">
            <label for="ps_id">Parking Space ID:</label>
            <input type="text" id="ps_id" name="ps_id" class="form-control" value="<?php echo htmlspecialchars($row['ps_id']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="parking_date">Parking Date:</label>
            <input type="date" id="parking_date" name="parking_date" class="form-control" value="<?php echo htmlspecialchars($row['b_date']); ?>" required>
        </div>
        <div class="form-group">
            <label for="parking_time">Parking Time:</label>
            <input type="time" id="parking_time" name="parking_time" class="form-control" value="<?php echo htmlspecialchars($row['b_time']); ?>" required>
        </div>
        <div class="form-group">
            <label for="vehicle_plateNum">Vehicle Plate Number:</label>
            <select id="vehicle_plateNum" name="vehicle_plateNum" class="form-control" required>
                <option value="">Select Plate Number</option>
                <!-- Populate options dynamically with PHP -->
                <?php
                // Fetch vehicle plate numbers for the current user
                $query = "SELECT v_plateNum, v_id FROM vehicle WHERE u_id = ?";
                $stmt_select = $conn->prepare($query);
                $stmt_select->bind_param('i', $_SESSION['u_id']);
                $stmt_select->execute();
                $result_select = $stmt_select->get_result();
                while ($vehicle = $result_select->fetch_assoc()) {
                    $selected = ($vehicle['v_id'] === $row['v_id']) ? 'selected' : '';
                    echo "<option value=\"" . htmlspecialchars($vehicle['v_id']) . "\" $selected>" . htmlspecialchars($vehicle['v_plateNum']) . "</option>";
                }
                $stmt_select->close(); // Close the statement after fetching options
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="vehicle_brand">Vehicle Brand:</label>
            <input type="text" id="vehicle_brand" name="vehicle_brand" class="form-control" value="<?php echo htmlspecialchars($row['v_brand']); ?>" required readonly>
        </div>
        <div class="form-group">
            <label for="vehicle_model">Vehicle Model:</label>
            <input type="text" id="vehicle_model" name="vehicle_model" class="form-control" value="<?php echo htmlspecialchars($row['v_model']); ?>" required readonly>
        </div>
        <div class="form-group">
            <label for="b_parkStart">Parking Start Time:</label>
            <input type="time" id="b_parkStart" name="b_parkStart" class="form-control" value="<?php echo htmlspecialchars($row['b_parkStart']); ?>" required>
        </div>
        <div class="form-group">
            <label for="b_duration">Duration (in hours):</label>
            <input type="number" id="b_duration" name="b_duration" class="form-control" value="<?php echo htmlspecialchars($row['b_duration']); ?>" required>
        </div>
        <div class="form-group">
            <label for="ps_availableStat">Parking Space Availability:</label>
            <select id="ps_availableStat" name="ps_availableStat" class="form-control" required>
                <option value="Available" <?php echo ($row['ps_availableStat'] === 'Available') ? 'selected' : ''; ?>>Available</option>
                <option value="Occupied" <?php echo ($row['ps_availableStat'] === 'Occupied') ? 'selected' : ''; ?>>Occupied</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Booking</button>
    </form><br>
    <a href="bookList.php" class="btn btn-primary">Go to Booking List</a>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Handle change event for vehicle plate number dropdown
    $('#vehicle_plateNum').change(function() {
        var v_id = $(this).val();
        if (v_id) {
            // AJAX request to fetch vehicle details
            $.ajax({
                type: 'POST',
                url: 'fetchVehicleDetails.php',
                data: { v_id: v_id },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Update vehicle details fields
                        $('#vehicle_brand').val(response.data.v_brand);
                        $('#vehicle_model').val(response.data.v_model);
                    } else {
                        alert('Vehicle details not found.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching vehicle details:', error);
                    alert('Failed to fetch vehicle details.');
                }
            });
        } else {
            // Clear vehicle details fields if no plate number selected
            $('#vehicle_brand').val('');
            $('#vehicle_model').val('');
        }
    });

    // Trigger change event on page load if a vehicle is pre-selected
    $('#vehicle_plateNum').trigger('change');
});
</script>

</body>
</html>

<?php
// Close the main statement after using it to fetch data
$stmt->close();
$conn->close();
?>
