<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <link rel="stylesheet" href="../css/bookForm.css">
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <h2>Booking Form</h2>
    <form action="submitBooking.php" method="POST">
        <div class="mb-3">
            <label for="parkingSpace" class="form-label">Parking Space</label>
            <select class="form-control" id="ps_id" name="ps_id">
                <!-- B1 Parking Spaces -->
                <optgroup label="B1 - 32 spaces">
                    <?php for($i = 1; $i <= 32; $i++): ?>
                        <option value="B1-S<?php echo sprintf('%02d', $i); ?>">B1-S<?php echo sprintf('%02d', $i); ?></option>
                    <?php endfor; ?>
                </optgroup>
                <!-- B2 Parking Spaces -->
                <optgroup label="B2 - 33 spaces">
                    <?php for($i = 1; $i <= 33; $i++): ?>
                        <option value="B2-S<?php echo sprintf('%02d', $i); ?>">B2-S<?php echo sprintf('%02d', $i); ?></option>
                    <?php endfor; ?>
                </optgroup>
                <!-- B3 Parking Spaces -->
                <optgroup label="B3 - 35 spaces">
                    <?php for($i = 1; $i <= 35; $i++): ?>
                        <option value="B3-S<?php echo sprintf('%02d', $i); ?>">B3-S<?php echo sprintf('%02d', $i); ?></option>
                    <?php endfor; ?>
                </optgroup>
            </select>
        </div>
        <div class="mb-3">
            <label for="u_id" class="form-label">User ID</label>
            <input type="text" class="form-control" id="u_id" name="u_id" required>
        </div>
        <div class="mb-3">
            <label for="b_date" class="form-label">Parking Date</label>
            <input type="date" class="form-control" id="b_date" name="b_date" required>
        </div>
        <div class="mb-3">
            <label for="b_time" class="form-label">Parking Time</label>
            <input type="time" class="form-control" id="b_time" name="b_time" required>
        </div>
        <div class="mb-3">
            <label for="v_id" class="form-label">Vehicle ID</label>
            <input type="text" class="form-control" id="v_id" name="v_id" required>
        </div>
        <div class="mb-3">
            <label for="v_plateNum" class="form-label">Car Plate Number</label>
            <input type="text" class="form-control" id="v_plateNum" name="v_plateNum" required>
        </div>
        <button type="submit" class="btn btn-primary">Next</button>
        <br><br>
        <button type="reset" class="btn btn-primary">Reset</button>
    </form>
</div>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
