<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}
// Retrieve the user ID from the session
$u_id = $_SESSION['u_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <h2>Booking Form</h2>
    <form action="submitBooking.php" method="post">
        <div class="mb-3">
            <label for="ps_id" class="form-label">Parking Space</label>
            <input type="text" class="form-control" id="ps_id" name="ps_id" value="<?php echo $ps_id; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="b_date" class="form-label">Parking Date</label>
            <input type="date" class="form-control" id="b_date" name="b_date" value="<?php echo $date; ?>" required>
        </div>
        <div class="mb-3">
            <label for="b_time" class="form-label">Parking Time</label>
            <input type="time" class="form-control" id="b_time" name="b_time" value="<?php echo $time; ?>" required>
        </div>
        <div class="mb-3">
            <label for="v_plateNum" class="form-label">Car Plate Number</label>
            <input type="text" class="form-control" id="b_plateNum" name="b_plateNum" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <br><br>
        <button type="reset" class="btn btn-primary">Reset</button>
    </form>
</div>

</body>
</html>
