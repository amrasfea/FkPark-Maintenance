<!-- display available parking -->
<!-- by auni -->


<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}

if (isset($_POST['parking_area'], $_POST['parking_date'], $_POST['parking_time'])) {
    $parking_area = $_POST['parking_area'];
    $parking_date = $_POST['parking_date'];
    $parking_time = $_POST['parking_time'];

    // Query to fetch available parking spaces
    $query = "SELECT ps_id FROM parkspace WHERE ps_area = '$parking_area' AND ps_availableStat = 'Available'";
    $result = mysqli_query($conn, $query); // Use $conn from config.php

    //$sql = "SELECT ps_id FROM parkSpace WHERE ps_id LIKE '{$area}%' AND ps_availableStat = 'Available'";
    //$result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Parking Spaces</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!--FAVICON-->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">

<?php 
// Check if query executed successfully
if (isset($result) && $result) {
    echo "<h2>Available Parking Spaces in Area $parking_area</h2>";
    echo "<ul>";
    // Loop through results and display each parking space
    while ($row = mysqli_fetch_assoc($result)) {
        // Display parking ID and status in one line
        echo '<div class="park-item">';
        echo '<div class="park-info">';
        echo '<p>Parking Space ID: ' . htmlspecialchars($row['ps_id']) . '</p>';
        echo '<a href="bookForm.php?ps_id=' . htmlspecialchars($row['ps_id']) . '&parking_date=' . urlencode($parking_date) . '&parking_time=' . urlencode($parking_time) . '" class="book-button">Book Now</a>';
        echo '</div>';
        echo '</div>';
    }
        //echo "<li>Parking Space ID: " . $row['ps_id'] . " <a href='bookForm.php?ps_id=" . $row['ps_id'] . "&parking_date=" . urlencode($parking_date) . "&parking_time=" . urlencode($parking_time) . "'>Book Now</a></li>";    }
    echo "</ul>";
} else {
    echo "Error: " . mysqli_error($conn);
}?>

</div>

</body>
</html>

<?php $conn->close(); ?>
