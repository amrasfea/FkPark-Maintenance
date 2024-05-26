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

        <?php
        // Check if form is submitted and searchArea is set and not empty
        if (isset($_POST['search']) && isset($_POST['searchArea']) && !empty(trim($_POST['searchArea']))) {
            $searchArea = $_POST['searchArea'];
            // Display park spaces only if searchArea is provided
            echo '<div class="container mt-3">';
            echo '<h3>Park Spaces</h3>';
            echo '<div class="park-list">';
            // Simulated data for demonstration purposes
            $parkingSpaces = [
                ['area' => 'A1', 'id' => 'A1-S01', 'status' => 'available', 'type' => '-', 'description' => '-'],
                ['area' => 'A1', 'id' => 'A1-S02', 'status' => 'occupied', 'type' => 'Covered', 'description' => 'Shaded area'],
                ['area' => 'A1', 'id' => 'A1-S03', 'status' => 'available', 'type' => '-', 'description' => '-'],
                ['area' => 'A1', 'id' => 'A1-S04', 'status' => 'available', 'type' => '-', 'description' => '-'],
                ['area' => 'A1', 'id' => 'A1-S05', 'status' => 'occupied', 'type' => 'maintenance', 'description' => 'lawn mowing'],
                ['area' => 'A1', 'id' => 'A1-S06', 'status' => 'available', 'type' => '-', 'description' => '-'],
                ['area' => 'A1', 'id' => 'A1-S07', 'status' => 'available', 'type' => '-', 'description' => '-'],
                ['area' => 'A1', 'id' => 'A1-S22', 'status' => 'available', 'type' => '-', 'description' => '-'],
                ['area' => 'A1', 'id' => 'A1-S23', 'status' => 'occupied', 'type' => 'Covered', 'description' => 'Shaded area'],

                ['area' => 'B1', 'id' => 'B1-S01', 'status' => 'available', 'type' => '-', 'description' => '-'],
                ['area' => 'B1', 'id' => 'B1-S20', 'status' => 'occupied', 'type' => 'maintenance', 'description' => 'lawn mowing'],
                ['area' => 'B1', 'id' => 'B1-S23', 'status' => 'available', 'type' => '-', 'description' => '-'],
                ['area' => 'B1', 'id' => 'B1-S30', 'status' => 'occupied', 'type' => 'Covered', 'description' => 'Shaded area'],
                // Add more parking spaces as needed
            ];
            // Filter parking spaces based on the entered park area
            $filteredSpaces = array_filter($parkingSpaces, function($space) use ($searchArea) {
                return $space['area'] == $searchArea;
            });
            // Display the filtered park spaces
            if (!empty($filteredSpaces)) { // Only display if there are filtered spaces
                // Count total spaces
                $totalSpaces = count($filteredSpaces);
                echo "<p>Total Spaces in $searchArea: $totalSpaces</p>";
                foreach ($filteredSpaces as $space) {
                    echo '<div class="park-item">';
                    // Display parking ID and status in one line
                    echo '<div class="park-info">';
                    echo '<p>Parking ID: ' . $space['id'] . '</p>';
                    echo '<a href="viewPark2.php?id=' . $space['id'] . '" class="status-button ' . $space['status'] . '">' . ucfirst($space['status']) . '</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No park spaces available in the specified area.</p>';
            }
            echo '</div>'; // closing park-list div
            echo '</div>'; // closing container div
        }
        ?>
    </div>
</body>
</html>
