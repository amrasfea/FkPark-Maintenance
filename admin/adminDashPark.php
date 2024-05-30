<?php
session_start(); // Start the session to access session variables

// Check if parking data is available in session
if (!isset($_SESSION['parkingData'])) {
    die("No parking data available.");
}

$parkingData = $_SESSION['parkingData'];
$totalSpace = $parkingData['totalSpace'];
$occupiedSpace = $parkingData['occupiedSpace'];
$eventSpace = $parkingData['eventSpace'];

$totalSpaces = array_sum($totalSpace);
$occupiedSpaces = array_sum($occupiedSpace);
$availableSpaces = $totalSpaces - $occupiedSpaces;
$eventSpaces = array_sum($eventSpace);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Park Area Report</title>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        h3 {
            margin-top: 10px;
            text-align: center; /* Centering the report summary */
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        canvas {
            margin-top: 20px;
        }

        .report-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .report-summary,
        .report-chart {
            flex: 0 0 48%;
        }

        /* Center the report */
        .report-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        /* Center the chart */
        .report-chart {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h1>Park Area Report</h1>
        
        <h3>Total Spaces: <?php echo $totalSpaces; ?> | Occupied Spaces: <?php echo $occupiedSpaces; ?> | Available Spaces: <?php echo $availableSpaces; ?> | Event Spaces: <?php echo $eventSpaces; ?></h3>

        <!-- Canvas element for Chart.js -->
        <div class="container">
            <canvas id="parkChart"></canvas>
        </div>

        <script>
            // JavaScript for Chart.js
            var ctx = document.getElementById('parkChart').getContext('2d');
            var parkChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [<?php foreach ($totalSpace as $area => $value) { echo "'$area', "; } ?>],
                    datasets: [{
                        label: 'Total Spaces',
                        data: [<?php foreach ($totalSpace as $area => $value) { echo "$value, "; } ?>],
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Occupied Spaces',
                        data: [<?php foreach ($occupiedSpace as $area => $value) { echo "$value, "; } ?>],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Available Spaces',
                        data: [<?php foreach ($totalSpace as $area => $value) { echo ($value - (isset($occupiedSpace[$area]) ? $occupiedSpace[$area] : 0)) . ", "; } ?>],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Event Spaces',
                        data: [<?php foreach ($eventSpace as $area => $value) { echo "$value, "; } ?>],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
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
        </script>

    </div>
</body>
</html>

