<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Park Space Details</title>
    <!-- EXTERNAL CSS -->
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!-- FAVICON -->
</head>
<body>
    <?php include('../navigation/studentNav.php'); ?>

    <?php
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

    // Fetch park space details based on the provided id
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    // Find the park space with the provided id
    $parkSpace = null;
    foreach ($parkingSpaces as $space) {
        if ($space['id'] == $id) {
            $parkSpace = $space;
            break;
        }
    }
    ?>

    <div class="container mt-5">
        <h2>Park Space Details</h2>

        <?php if ($parkSpace): ?>
        <div class="parking-list">
            <div class="parking-space">
                <p>Parking area: <?php echo $parkSpace['area']; ?></p>
                <p>Parking ID: <?php echo $parkSpace['id']; ?></p>
                <p>Status: <?php echo ucfirst($parkSpace['status']); ?></p>
                <p>Type: <?php echo $parkSpace['type']; ?></p>
                <p>Description: <?php echo $parkSpace['description']; ?></p>
                <!-- Add any other details you want to display -->
            </div>
        </div>
        <?php else: ?>
        <p>Park space not found.</p>
        <?php endif; ?>
    </div>

    <!-- Add any other content or styling as needed -->

</body>
</html>
