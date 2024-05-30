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
                })
                .catch(error => console.error('Error fetching statistics:', error));
        });
    </script>
</body>
</html>
