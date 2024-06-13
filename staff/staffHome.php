<?php
require '../session_check.php';
require '../config.php'; // Adjust this path to match your actual database connection file

// Check if the current user is an administrator
if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

// Initialize variables to hold statistic values
$summon_issued = 0; 
$registered_vehicle = 0; 
$pending_approval = 0; 

// Connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count summons
$sql_summons = "SELECT COUNT(sum_id) AS total_summons FROM summon";
$result_summons = $conn->query($sql_summons);

if ($result_summons->num_rows > 0) {
    $row_summons = $result_summons->fetch_assoc();
    $summon_issued = $row_summons['total_summons'];
}

// Query to count registered vehicles
$sql_vehicle = "SELECT COUNT(v_id) AS total_vehicle FROM vehicle";
$result_vehicle = $conn->query($sql_vehicle);

if ($result_vehicle->num_rows > 0) {
    $row_vehicle = $result_vehicle->fetch_assoc();
    $registered_vehicle = $row_vehicle['total_vehicle'];
}

// Query to count vehicles pending approval
$sql_pending_approval = "SELECT COUNT(v_id) AS total_pending FROM vehicle WHERE v_approvalStatus = 'Pending'";
$result_pending_approval = $conn->query($sql_pending_approval);

if ($result_pending_approval->num_rows > 0) {
    $row_pending_approval = $result_pending_approval->fetch_assoc();
    $pending_approval = $row_pending_approval['total_pending'];
}

// Query to count summons by month
$sqlSummonMonth = "SELECT MONTH(sum_date) AS month, COUNT(sum_id) AS total_summons
                         FROM summon
                         GROUP BY MONTH(sum_date)";
$resultSummonMonth = $conn->query($sqlSummonMonth);

$summons_by_month_data = [];
while ($row = $resultSummonMonth->fetch_assoc()) {
    $summons_by_month_data[$row['month']] = $row['total_summons'];
}

// Close database connection
$conn->close();

// Data for Chart.js
$chart_data = [
    'labels' => ['Summon Issued', 'Registered Vehicle', 'Pending Approval'],
    'data' => [$summon_issued, $registered_vehicle, $pending_approval],
];

// Data for Pie Chart (Summons by Month)
$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
$summons_data = [];
foreach ($months as $index => $month) {
    $summons_data[] = isset($summons_by_month_data[$index + 1]) ? $summons_by_month_data[$index + 1] : 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!-- EXTERNAL CSS -->
    <link rel="stylesheet" href="../css/staffDashboard.css">
    <!-- CHART.JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include('../navigation/staffNav.php'); ?>
    <div class="dashboard">
        <h1>Unit Keselamatan Staff Dashboard</h1>
        <div class="statistics">
            <div class="statistic">
                <h2>Summon Issued</h2>
                <p class="statistic-value"><?php echo $summon_issued; ?></p>
            </div>
            <div class="statistic">
                <h2>Registered Vehicle</h2>
                <p class="statistic-value"><?php echo $registered_vehicle; ?></p>
            </div>
            <div class="statistic">
                <h2>Pending Approval</h2>
                <p class="statistic-value"><?php echo $pending_approval; ?></p>
            </div>
        </div>

        <!-- Chart Container -->
        <div class="chart-container">
            <canvas id="myChart"></canvas>
        </div>
        
        <div class="centered-heading">
            <h2>Summon Issued By Month</h2>
        </div>
        <!-- Pie Chart Container -->
        <div class="chart-container">
            <canvas id="pieChart"></canvas>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Bar Chart
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($chart_data['labels']); ?>,
            datasets: [{
                label: 'Statistics',
                data: <?php echo json_encode($chart_data['data']); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Pie Chart
    var ctxPie = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'Summon Issued by Month',
                data: <?php echo json_encode($summons_data); ?>,
                backgroundColor: [
                    '#FF9C96', //January
                    '#FFB996', //February
                    '#FD0716', // March
                    'rgba(75, 192, 192, 0.8)', //April
                    '#FF96DF', //May
                    'rgba(255, 159, 64, 0.8)', //June
                    'rgba(255, 99, 132, 0.8)', //July
                    'rgba(54, 162, 235, 0.8)', //August
                    'rgba(255, 206, 86, 0.8)', //September
                    '#E9CAFB', //October
                    'rgba(153, 102, 255, 0.8)', //November
                    '#F7FA2D', //December
                ],
                borderColor: [
                    '#FF9C96', //January
                    '#FFB996', //February
                    '#FD0716', // March
                    'rgba(75, 192, 192, 0.8)', //April
                    '#FF96DF', //May
                    'rgba(255, 159, 64, 0.8)', //June
                    'rgba(255, 99, 132, 0.8)', //July
                    'rgba(54, 162, 235, 0.8)', //August
                    'rgba(255, 206, 86, 0.8)', //September
                    '#E9CAFB', //October
                    'rgba(153, 102, 255, 0.8)', //November
                    '#F7FA2D', //December
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, 
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2);
                        }
                    }
                }
            }
        }
    });
});
</script>

</body>
</html>
