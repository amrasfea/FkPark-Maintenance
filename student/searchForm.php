<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Parking</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <h2>Search Available Parking Spaces</h2>
    <form action="searchParking.php" method="post">
        <div class="mb-3">
            <label for="area" class="form-label">Choose Area</label>
            <select class="form-control" id="area" name="area" required>
                <option value="B1">B1</option>
                <option value="B2">B2</option>
                <option value="B3">B3</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Choose Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="mb-3">
            <label for="time" class="form-label">Choose Time</label>
            <input type="time" class="form-control" id="time" name="time" required>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>

</body>
</html>
