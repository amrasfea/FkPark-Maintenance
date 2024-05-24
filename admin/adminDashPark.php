<?php
// Simulated more data for demonstration purposes
$parkingSpaces = [
    ['area' => 'A1', 'totalSpace' => 50, 'id' => 'A1-S22', 'status' => 'Available', 'typeEvent' => 'Concert', 'description' => 'Reserved for concert attendees', 'time' => '8:00 AM - 6:00 PM'],
    ['area' => 'A2', 'totalSpace' => 40, 'id' => 'A2-S23', 'status' => 'Occupied', 'typeEvent' => 'Open', 'description' => 'Open parking space', 'time' => '7:00 AM - 7:00 PM'],
    ['area' => 'A3', 'totalSpace' => 60, 'id' => 'A3-S24', 'status' => 'Available', 'typeEvent' => 'Covered', 'description' => 'Covered parking area', 'time' => '9:00 AM - 5:00 PM'],
    ['area' => 'A4', 'totalSpace' => 30, 'id' => 'A4-S25', 'status' => 'Occupied', 'typeEvent' => 'Underground', 'description' => 'Underground parking area', 'time' => '24/7'],
    ['area' => 'B1', 'totalSpace' => 80, 'id' => 'B1-S26', 'status' => 'Available', 'typeEvent' => 'Open', 'description' => 'Open parking area near the mall', 'time' => '10:00 AM - 10:00 PM'],
    ['area' => 'B2', 'totalSpace' => 70, 'id' => 'B2-S27', 'status' => 'Occupied', 'typeEvent' => 'Covered', 'description' => 'Shaded area', 'time' => '9:00 AM - 5:00 PM'],
    ['area' => 'B3', 'totalSpace' => 90, 'id' => 'B3-S28', 'status' => 'Available', 'typeEvent' => 'Open', 'description' => 'Open parking space', 'time' => '8:00 AM - 6:00 PM'],
];

// Calculate total, occupied, and available spaces
$totalSpaces = 0;
$occupiedSpaces = 0;
foreach ($parkingSpaces as $space) {
    $totalSpaces += $space['totalSpace'];
    if ($space['status'] === 'Occupied') {
        $occupiedSpaces++;
    }
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
                    labels: ['Occupied Spaces', 'Available Spaces'],
                    datasets: [{
                        label: 'Park Spaces',
                        data: [<?php echo $occupiedSpaces; ?>, <?php echo $availableSpaces; ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)'
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
        </script>

        
            </div>
        </div>
    </div>
    </body>
</html>
