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
<h2>Search Available Parking</h2>
    <form action="listParking2.php" method="post">
        <label for="parking_area">Parking Area:</label>
        <select name="parking_area" id="parking_area">
            <option value="B1">B1</option>
            <option value="B2">B2</option>
            <option value="B3">B3</option>
        </select><br><br>
        <label for="parking_date">Date:</label>
        <input type="date" id="parking_date" name="parking_date"><br><br>
        <label for="parking_time">Time:</label>
        <input type="time" id="parking_time" name="parking_time"><br><br>
        <?php echo "<a href='../student/listParking2.php?parking_date=" . urlencode('$parking_date'). "&parking_time=" . urlencode('$parking_time')."'><button class='btn btn-primary'>Search</button></a>"; ?>
    </form>
</div>

</body>
</html>





<!---->
<!--<?php// echo "<a href='../student/bookForm.php?date=" . urlencode('date'). "&time=" . urlencode('time')."'><button class='btn btn-primary'>Search</button></a>"; ?>-->