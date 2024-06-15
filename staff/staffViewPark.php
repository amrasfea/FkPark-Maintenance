<!-- by umairah -->
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
    <style>
        .qr-code {
            margin-left: auto; /* Push QR code to the right end */
        }
        .qr-code img {
            width: 80px;  /* Adjust the width as needed */
            height: 80px; /* Adjust the height as needed */
        }
    </style>
</head>
<body>
    <?php include('../navigation/staffNav.php'); ?>

    <div class="container mt-5">
        <h2>List Park Space</h2>
        <form method="post" action="" class="search-form">
            <div class="form-group">
                <div class="input-group">
                    <label for="searchArea" class="label-inline">Park Area:</label>
                    <input type="text" class="form-control" id="searchArea" name="searchArea" required>
                    <button type="submit" name="search" class="search-button">Search</button>
                </div>
            </div>
        </form>
        
        <?php
        // Database connection
        require '../config.php'; // Adjust the path as needed

        // Check if form is submitted and searchArea is set and not empty
        if (isset($_POST['search']) && isset($_POST['searchArea']) && !empty(trim($_POST['searchArea']))) {
            $searchArea = $_POST['searchArea'];
            // Prepare the SQL query to fetch park spaces from the database
            $query = "SELECT * FROM parkSpace WHERE ps_area = ?";
            if ($stmt = mysqli_prepare($conn, $query)) {
                mysqli_stmt_bind_param($stmt, "s", $searchArea);
                if (mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);
                    $parkingSpaces = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    mysqli_stmt_close($stmt);

                    echo '<div class="container mt-3">';
                    echo '<h3>Park Spaces</h3>';
                    echo "<p>Total Spaces in $searchArea: " . count($parkingSpaces) . "</p>";
                    echo '<div class="park-list">';
                    
                    if (!empty($parkingSpaces)) {
                        foreach ($parkingSpaces as $space) {
                            echo '<div class="park-item">';
                            // Display parking ID, status, and QR code in one line
                            echo '<div class="park-info">';
                            echo '<p>Parking ID: ' . htmlspecialchars($space['ps_id']) . '</p>';
                            echo '<a href="staffViewPark2.php?id=' . htmlspecialchars($space['ps_id']) . '" class="status-button ' . htmlspecialchars($space['ps_availableStat']) . '">' . ucfirst(htmlspecialchars($space['ps_availableStat'])) . '</a>';
                            echo '</div>';
                            echo '<div class="qr-code">';
                            echo '<img src="' . htmlspecialchars($space['ps_QR']) . '" alt="QR Code">';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No park spaces available in the specified area.</p>';
                    }
                    echo '</div>'; // closing park-list div
                    echo '</div>'; // closing container div
                } else {
                    echo '<p>Error executing query: ' . mysqli_error($conn) . '</p>';
                }
            } else {
                echo '<p>Failed to prepare query: ' . mysqli_error($conn) . '</p>';
            }
        }
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
