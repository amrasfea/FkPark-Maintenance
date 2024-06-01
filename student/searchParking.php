<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}

if (isset($_POST['area'], $_POST['date'], $_POST['time'])) {
    $area = $_POST['area'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Query to find available parking spaces
    $sql = "SELECT ps_id FROM parkSpace WHERE ps_id LIKE '{$area}%' AND ps_availableStat = 'Available'";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Parking Spaces</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <h2>Available Parking Spaces</h2>
    <?php if ($result->num_rows > 0): ?>
        <ul class="list-group">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li class="list-group-item">
                    <?php echo $row['ps_id']; ?>
                    <a href="bookForm.php?ps_id=<?php echo $row['ps_id']; ?>&date=<?php echo $date; ?>&time=<?php echo $time; ?>" class="btn btn-primary float-right">Book Now</a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No available parking spaces found.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>
