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

    <?php
    // Fetch park space details based on the provided id
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    // You would fetch park space details from the database based on the provided id
    // For demonstration purposes, let's use a simulated data array
    $parkingSpaces = [
        ['area' => 'A1', 'id' => 1, 'status' => 'available', 'type' => 'Open', 'description' => 'Near entrance'],
        ['area' => 'B2', 'id' => 2, 'status' => 'occupied', 'type' => 'Covered', 'description' => 'Shaded area'],
        // Add more parking spaces as needed
    ];

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
                <p>Type event: <?php echo $parkSpace['type']; ?></p>
                <p>Description: <?php echo $parkSpace['description']; ?></p>
            </div>
        </div>
        <?php else: ?>
        <p>Park space not found.</p>
        <?php endif; ?>
    </div>

    <!-- Add any other content or styling as needed -->

</body>
</html>
