<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if the current user is an administrator
if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

// Fetch total demerit points for each user and calculate status
$query = "
    SELECT 
        profiles.p_name, 
        profiles.p_matricNum, 
        SUM(summon.sum_demerit) as total_demerit,
        CASE
            WHEN SUM(summon.sum_demerit) < 20 THEN 'Warning'
            WHEN SUM(summon.sum_demerit) < 50 THEN 'Revoke of in campus vehicle permission for 1 semester'
            WHEN SUM(summon.sum_demerit) < 80 THEN 'Revoke of in campus vehicle permission for 2 semesters'
            ELSE 'Revoke of in campus vehicle permission for entire study duration'
        END as sum_status
    FROM summon 
    JOIN vehicle ON summon.v_id = vehicle.v_id
    JOIN user ON vehicle.u_id = user.u_id
    JOIN profiles ON user.u_id = profiles.u_id
    GROUP BY profiles.p_name, profiles.p_matricNum
    ORDER BY total_demerit DESC
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
    <title>Total Demerit Points</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/list.css">
    <!--FAVICON-->
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
</head>
<body>
    <?php include('../navigation/staffNav.php'); ?>
    <div class="container mt-3">
        <h2>Total Demerit Points</h2>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Matric ID</th>
                    <th>Total Demerit Points</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Dynamically generate rows from the fetched data
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['p_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['p_matricNum']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['total_demerit']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['sum_status']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
