<!-- by umairah -->
<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session and if the user is an admin
if (!isset($_SESSION['u_id']) || $_SESSION['role'] !== 'Administrators') {
    die("Error: You do not have permission to view this page.");
}

// Retrieve all pending bookings
$sql = "
    SELECT b.b_id, b.ps_id, b.b_date, b.b_time, b.b_platenum, p.ps_area, p.ps_availableStat
    FROM bookinfo b
    JOIN parkspace p ON b.ps_id = p.ps_id
    WHERE b.b_status = 'Pending'
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Booking Approval</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../navigation/adminNav.php'); ?>

<div class="container mt-5">
    <h2>Pending Bookings</h2>
    <?php
    if ($result->num_rows > 0) {
        echo "<table class='table table-striped'>";
        echo "<thead><tr><th>Parking Space ID</th><th>Parking Area</th><th>Date</th><th>Time</th><th>Plate Number</th><th>Availability Status</th><th>Actions</th></tr></thead>";
        echo "<tbody>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["ps_id"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["ps_area"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["b_date"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["b_time"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["b_platenum"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["ps_availableStat"]) . "</td>";
            echo "<td>";
            echo "<a href='approveBook.php?b_id=" . htmlspecialchars($row["b_id"]) . "' class='btn btn-success btn-sm'>Approve</a> ";
            echo "<a href='rejectBook.php?b_id=" . htmlspecialchars($row["b_id"]) . "' class='btn btn-danger btn-sm'>Reject</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No pending bookings found.</p>";
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
