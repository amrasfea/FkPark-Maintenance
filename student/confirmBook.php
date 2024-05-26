<?php
session_start();
if (!isset($_SESSION['u_id'])) {
    header("Location: bookForm.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <h2>Booking Confirmation</h2>
    <p><strong>User ID:</strong> <?php echo $_SESSION['u_id']; ?></p>
    <p><strong>Parking Space:</strong> <?php echo $_SESSION['ps_id']; ?></p>
    <p><strong>Date:</strong> <?php echo $_SESSION['b_date']; ?></p>
    <p><strong>Time:</strong> <?php echo $_SESSION['b_time']; ?></p>
    <p><strong>Vehicle ID:</strong> <?php echo $_SESSION['v_id']; ?></p>
    <p><strong>Car Plate Number:</strong> <?php echo $_SESSION['v_plateNum']; ?></p>
    <a href="bookList.php" class="btn btn-primary">View Booking List</a>
</div>

</body>
</html>

<?php
// Clear session data after confirmation
session_unset();
session_destroy();
?>
