<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Park Space</title>
    <!-- EXTERNAL CSS -->
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!-- FAVICON -->
</head>
<body>
    <?php include('../navigation/studentNav.php'); ?>

    <div class="container mt-5">
        <h2>List Park Space</h2>
        <form method="post" action="" class="search-form">
            <div class="form-group">
                <div class="input-group">
                    <label for="parkDate">Park Date:</label>
                    <input type="date" name="parkDate" class="form-control" required>
                    <label for="parkDate">Park Time:</label>
                    <input type="time" name="parkTime" class="form-control" required>
                    <label for="searchArea" class="label-inline">Park Area:</label>
                    <input type="text" class="form-control" id="searchArea" name="searchArea" required>
                    <button type="submit" name="search" class="search-button">Search</button>
                </div>
            </div>
        </form>

        <div class="container mt-3"> <!-- Example of hardcoded park spaces -->
            <h3>Park Spaces</h3>
            <div class="park-list">
                <?php
                // Simulated data for demonstration purposes
                $parkingSpaces = [
                    ['area' => 'A1', 'id' => 'A1-S22', 'status' => 'available', 'type' => 'Open', 'description' => 'Near entrance', 'time' => '8:00 AM - 6:00 PM'],
                    ['area' => 'B2', 'id' => 'B2-S30', 'status' => 'occupied', 'type' => 'Covered', 'description' => 'Shaded area', 'time' => '9:00 AM - 5:00 PM'],
                    // Add more parking spaces as needed
                ];

                foreach ($parkingSpaces as $space) {
                    echo '<div class="park-item">';
                    // Display parking ID and status in one line
                    echo '<div class="park-info">';
                    echo '<p>Parking ID: ' . $space['id'] . '</p>';
                    echo '<a href="viewPark2.php?id=' . $space['id'] . '" class="status-button ' . $space['status'] . '">' . ucfirst($space['status']) . '</a>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
