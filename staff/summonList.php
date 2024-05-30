<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if the current user is an administrator
if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

// Initialize $result variable
$result = null;

// Handle search request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $date = $_POST['date'];
    $searchQuery = "
        SELECT 
            summon.sum_date, 
            summon.sum_id, 
            summon.sum_vPlate, 
            summon.sum_location, 
            summon.sum_status, 
            profiles.p_name, 
            profiles.p_matricNum
        FROM summon 
        JOIN vehicle ON summon.v_id = vehicle.v_id
        JOIN user ON vehicle.u_id = user.u_id
        JOIN profiles ON user.u_id = profiles.u_id
        WHERE summon.sum_date = ?
    ";
    $stmt = $conn->prepare($searchQuery);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    // Fetch all summon data from the database
    $query = "
        SELECT 
            summon.sum_date, 
            summon.sum_id, 
            summon.sum_vPlate, 
            summon.sum_location, 
            summon.sum_status, 
            profiles.p_name, 
            profiles.p_matricNum
        FROM summon 
        JOIN vehicle ON summon.v_id = vehicle.v_id
        JOIN user ON vehicle.u_id = user.u_id
        JOIN profiles ON user.u_id = profiles.u_id
    ";
    $result = $conn->query($query);
}

// Debugging
if (!$result) {
    echo "Query Error: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summon List</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/list.css">
    <!--FAVICON-->
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
</head>
<body>
    <?php include('../navigation/staffNav.php'); ?>
    <div class="container mt-3">
        <h2>Summon List</h2>
        <form method="post" action="" class="summon-list">
            <div class="form-group">
                <div class="search-input-group">
                    <input type="date" class="date" id="date" name="date">
                    <button type="submit" class="search-button" name="search">Search</button>
                </div>
            </div>
        </form>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Summon ID</th>
                    <th>Vehicle Owner</th>
                    <th>Plate Number</th>
                    <th>Matric ID</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Action</th> <!-- Added Action column -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Dynamically generate rows from the fetched data
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['sum_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['sum_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['p_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['sum_vPlate']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['p_matricNum']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['sum_location']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['sum_status']) . "</td>";
                        echo "<td>";
                        echo "<form method='post' action='' style='display:inline-block;'>";
                        echo "<input type='hidden' name='sum_id' value='" . htmlspecialchars($row['sum_id']) . "'>";
                        echo "<button type='submit' name='edit' class='edit-button'>Edit</button>";
                        echo "<button type='submit' name='delete' class='delete-button' onclick=\"return confirm('Are you sure you want to delete this record?')\">Delete</button>";
                        echo "</form>";
                        echo "<a href='../staff/receipt.php?sum_date=" . urlencode($row['sum_date']) . "&sum_id=" . urlencode($row['sum_id']) . "&p_name=" . urlencode($row['p_name']) . "&sum_vPlate=" . urlencode($row['sum_vPlate']) . "&p_matricNum=" . urlencode($row['p_matricNum']) . "&sum_location=" . urlencode($row['sum_location']) . "&sum_status=" . urlencode($row['sum_status']) . "'><button class='edit-button'>View</button></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
