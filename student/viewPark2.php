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
    // Database connection
    require '../config.php'; // Adjust the path as needed

    // Fetch park space details based on the provided id
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    // Initialize park space variable
    $parkSpace = null;

    if ($id) {
        // Prepare the SQL query to fetch park space details
        $query = "SELECT * FROM parkSpace WHERE ps_id = ?";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $id);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                $parkSpace = mysqli_fetch_assoc($result);
                mysqli_stmt_close($stmt);
            } else {
                echo '<p>Error executing query: ' . mysqli_error($conn) . '</p>';
            }
        } else {
            echo '<p>Failed to prepare query: ' . mysqli_error($conn) . '</p>';
        }
    } else {
        echo '<p>No parking space ID provided.</p>';
    }

    mysqli_close($conn);
    ?>

    <div class="container mt-5">
        <h2>Park Space Details</h2>

        <?php if ($parkSpace): ?>
        <div class="parking-list">
            <div class="parking-space">
                <p>Parking area: <?php echo htmlspecialchars($parkSpace['ps_area']); ?></p>
                <p>Parking ID: <?php echo htmlspecialchars($parkSpace['ps_id']); ?></p>
                <p>Status: <?php echo ucfirst(htmlspecialchars($parkSpace['ps_availableStat'])); ?></p>
                <p>Type event: <?php echo htmlspecialchars($parkSpace['ps_typeEvent']); ?></p>
                <p>Description: <?php echo htmlspecialchars($parkSpace['ps_descriptionEvent']); ?></p>
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
