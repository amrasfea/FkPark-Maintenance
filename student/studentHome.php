<?php
session_start();
require '../config.php'; // Database connection

// Check if the current user is a student
if ($_SESSION['role'] !== 'Student') {
    header("Location: ../login2.php");
    exit();
}

// Fetch the count of cars and motorcycles registered by the student
$u_id = $_SESSION['u_id'];

// Fetch car count
$stmt = $conn->prepare("SELECT COUNT(*) AS car_count FROM vehicle WHERE u_id = ? AND v_vehicleType = 'CAR'");
$stmt->bind_param("i", $u_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$car_count = $row['car_count'];
$stmt->close();

// Fetch motorcycle count
$stmt = $conn->prepare("SELECT COUNT(*) AS motorcycle_count FROM vehicle WHERE u_id = ? AND v_vehicleType = 'MOTORCYCLE'");
$stmt->bind_param("i", $u_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$motorcycle_count = $row['motorcycle_count'];
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <link rel="stylesheet" href="../css/staffDashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include('../navigation/studentNav.php'); ?>
<div class="dashboard">
    <h1>Student Dashboard</h1>
    <div class="statistics">
        <div class="statistic">
            <h2>Cars Registered</h2>
            <p class="statistic-value" id="car-count"><?php echo $car_count; ?></p>
        </div>
        <div class="statistic">
            <h2>Motorcycles Registered</h2>
            <p class="statistic-value" id="motorcycle-count"><?php echo $motorcycle_count; ?></p>
        </div>
    </div>
    <div class="chart-container">
        <canvas id="registrationChart"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('registrationChart').getContext('2d');
    const registrationChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Cars', 'Motorcycles'],
            datasets: [{
                label: 'Registrations',
                data: [<?php echo $car_count; ?>, <?php echo $motorcycle_count; ?>],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)'
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
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>


