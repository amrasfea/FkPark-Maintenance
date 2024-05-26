<?php
// Simulated more data for demonstration purposes
$parkingSpaces = [
    ['area' => 'A', 'totalSpace' => 100, 'occupiedSpaces' => 40],
    ['area' => 'B', 'totalSpace' => 100, 'occupiedSpaces' => 30]
];

$occupiedSpaces = 0;
$totalSpaces = 0;
foreach ($parkingSpaces as $space) {
    $totalSpaces += $space['totalSpace'];
    $occupiedSpaces += $space['occupiedSpaces'];
}
$availableSpaces = $totalSpaces - $occupiedSpaces;
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
        
        <h3>Total Spaces: <?php echo $totalSpaces; ?> | Occupied Spaces: <?php echo $occupiedSpaces; ?> | Available Spaces: <?php echo $availableSpaces; ?></h3>

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
                    labels: ['Park Area A', 'Park Area B'],
                    datasets: [{
                        label: 'Occupied Spaces',
                        data: [<?php echo $parkingSpaces[0]['occupiedSpaces']; ?>, <?php echo $parkingSpaces[1]['occupiedSpaces']; ?>],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Available Spaces',
                        data: [<?php echo $parkingSpaces[0]['totalSpace'] - $parkingSpaces[0]['occupiedSpaces']; ?>, <?php echo $parkingSpaces[1]['totalSpace'] - $parkingSpaces[1]['occupiedSpaces']; ?>],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
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
        </div>
    </div>
</body>
</html>
