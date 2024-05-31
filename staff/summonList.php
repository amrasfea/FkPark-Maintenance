<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if the current user is an administrator
if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

// Check if delete button is clicked
if (isset($_POST['delete']) && isset($_POST['sum_id'])) {
    $sum_id = $_POST['sum_id'];
    
    // Prepare and execute the delete statement
    $deleteStmt = $conn->prepare("DELETE FROM summon WHERE sum_id = ?");
    $deleteStmt->bind_param("i", $sum_id);
    
    if ($deleteStmt->execute()) {
        echo "<script>alert('Record deleted successfully');</script>";
        // Redirect to avoid form resubmission
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting record: ".$conn->error."');</script>";
    }
    
    $deleteStmt->close();
}

// Fetch total demerit points for each user and update their status
$query = "
    SELECT 
        profiles.u_id,
        SUM(summon.sum_demerit) as total_demerit
    FROM summon 
    JOIN vehicle ON summon.v_id = vehicle.v_id
    JOIN user ON vehicle.u_id = user.u_id
    JOIN profiles ON user.u_id = profiles.u_id
    GROUP BY profiles.u_id
";

$result = $conn->query($query);

// Debugging
if (!$result) {
    echo "Query Error: " . $conn->error;
    exit();
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $u_id = $row['u_id'];
        $total_demerit = $row['total_demerit'];

        if ($total_demerit < 20) {
            $status = 'Warning';
        } elseif ($total_demerit < 50) {
            $status = 'Revoke of in campus vehicle permission for 1 semester';
        } elseif ($total_demerit < 80) {
            $status = 'Revoke of in campus vehicle permission for 2 semesters';
        } else {
            $status = 'Revoke of in campus vehicle permission for entire study duration';
        }

        // Prepare and execute the update statement
        $updateStmt = $conn->prepare("UPDATE summon SET sum_status = ? WHERE v_id IN (SELECT v_id FROM vehicle WHERE u_id = ?)");
        $updateStmt->bind_param("si", $status, $u_id);

        if (!$updateStmt->execute()) {
            echo "<script>alert('Error updating status: ".$conn->error."');</script>";
        }

        $updateStmt->close();
    }
}

// Fetch summon data with updated status
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
                        //echo "<button type='submit' name='edit' class='edit-button'>Edit</button>";
                        echo "<button type='submit' name='delete' class='delete-button' onclick=\"return confirm('Are you sure you want to delete this record?')\">Delete</button>";
                        echo "</form>";
                        echo "<a href='../staff/receipt.php?sum_date=" . urlencode($row['sum_date']) . "&sum_id=" . urlencode($row['sum_id']) . "&p_name=". urlencode($row['p_name']) . "&sum_vPlate=" . urlencode($row['sum_vPlate']) . "&p_matricNum=" . urlencode($row['p_matricNum']) . "&sum_location=" . urlencode($row['sum_location']) . "&sum_status=" . urlencode($row['sum_status']) . "'><button class='edit-button'>View</button></a>";
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
