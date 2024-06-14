<!-- list booking -->
<!-- by auni -->


<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}

// Retrieve all bookings for the logged-in user
$u_id = $_SESSION['u_id'];
$sql = "SELECT * FROM bookinfo WHERE u_id = '$u_id'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking List</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <h2>Booking List</h2>
    <?php
    if ($result->num_rows > 0) {
        echo "<table class='table table-striped'>";
        echo "<thead><tr><th>Booking ID</th><th>Parking Space</th><th>Date</th><th>Time</th><th>Status</th><th>Vehicle ID</th><th>Plate Number</th><th>Actions</th></tr></thead>";
        echo "<tbody>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["b_id"] . "</td>";
            echo "<td>" . $row["ps_id"] . "</td>";
            echo "<td>" . $row["b_date"] . "</td>";
            echo "<td>" . $row["b_time"] . "</td>";
            echo "<td>" . $row["b_status"] . "</td>";
            echo "<td>" . $row["v_id"] . "</td>";
            echo "<td>" . $row["b_platenum"] . "</td>";
            echo "<td>";
            echo "<a href='viewBooking.php?b_id=" . $row["b_id"] . "' class='btn btn-info btn-sm'>View</a> ";
            echo "<a href='updateBooking.php?b_id=" . $row["b_id"] . "' class='btn btn-warning btn-sm'>Update</a> ";
            echo "<a href='deleteBooking.php?b_id=" . $row["b_id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this booking?\")'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No bookings found.</p>";
    }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
