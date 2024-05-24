<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!--FAVICON-->
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/staffDashboard.css">
</head>
<body>
<?php include('../navigation/staffNav.php'); ?>
    <div class="dashboard">
        <h1>Dashboard</h1>
        <div class="statistics">
            <div class="statistic">
                <h2>Total Users</h2>
                <p class="statistic-value">1000</p>
            </div>
            <div class="statistic">
                <h2>Active Users</h2>
                <p class="statistic-value">800</p>
            </div>
            <div class="statistic">
                <h2>Inactive Users</h2>
                <p class="statistic-value">200</p>
            </div>
            <div class="statistic">
                <h2>Total Revenue</h2>
                <p class="statistic-value">$50,000</p>
            </div>
        </div>
    </div>
</body>
</html>