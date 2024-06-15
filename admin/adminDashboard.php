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
<?php include('../navigation/adminNav.php'); ?>
    <div class="dashboard">
        <h1>Admin Dashboard</h1>
        <div class="statistics">
            <div class="statistic">
                <h2>Car Registered</h2>
                <p class="statistic-value" id="car-count">Loading...</p>
            </div>
            <div class="statistic">
                <h2>Motorcycle Registered</h2>
                <p class="statistic-value" id="motorcycle-count">Loading...</p>
            </div>
            <div class="statistic">
                <h2>Student Registered</h2>
                <p class="statistic-value" id="student-count">Loading...</p>
            </div>
            <div class="statistic">
                <h2>Total Users</h2>
                <p class="statistic-value" id="user-count">Loading...</p>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="registrationChart"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('../admin/fetch_statistics.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('car-count').textContent = data.car_count;
                    document.getElementById('motorcycle-count').textContent = data.motorcycle_count;
                    document.getElementById('student-count').textContent = data.student_count;
                    document.getElementById('user-count').textContent = data.user_count;

                    // Chart.js setup
                    const ctx = document.getElementById('registrationChart').getContext('2d');
                    const registrationChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Cars', 'Motorcycles', 'Students', 'Total Users'],
                            datasets: [{
                                label: 'Registrations',
                                data: [data.car_count, data.motorcycle_count, data.student_count, data.user_count],
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
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
                })
                .catch(error => console.error('Error fetching statistics:', error));
        });
    </script>
</body>
</html>

