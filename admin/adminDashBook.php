<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Fetch total bookings
$totalBookingsQuery = "SELECT COUNT(*) AS total FROM bookinfo";
$totalBookingsResult = $conn->query($totalBookingsQuery);
$totalBookings = $totalBookingsResult->fetch_assoc()['total'];

// Fetch pending approvals
$pendingApprovalsQuery = "SELECT COUNT(*) AS pending FROM bookinfo WHERE b_status = 'Pending'";
$pendingApprovalsResult = $conn->query($pendingApprovalsQuery);
$pendingApprovals = $pendingApprovalsResult->fetch_assoc()['pending'];

// Fetch weekday and weekend bookings data
$weekdaysQuery = "
    SELECT 
        SUM(CASE WHEN DAYOFWEEK(b_date) IN (2, 3, 4, 5, 6) THEN 1 ELSE 0 END) AS weekdays,
        SUM(CASE WHEN DAYOFWEEK(b_date) IN (1, 7) THEN 1 ELSE 0 END) AS weekends
    FROM 
        bookinfo
";
$weekdaysResult = $conn->query($weekdaysQuery);
$weekdaysData = $weekdaysResult->fetch_assoc();

$conn->close();

// Prepare data for Chart.js
$labels = json_encode(['Weekdays', 'Weekends']);
$bookings = json_encode([$weekdaysData['weekdays'], $weekdaysData['weekends']]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h1>Admin Dashboard</h1>
        
        <!-- Overview Section -->
        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Bookings</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $totalBookings; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Pending Approvals</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $pendingApprovals; ?></h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="mt-5">
            <h2>Bookings: Weekdays vs. Weekends</h2>
            <canvas id="bookingsChart" width="400" height="200"></canvas>
        </div>

        <!-- Recent Bookings -->
        <h2>Recent Bookings</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>User Name</th>
                    <th>Parking Space ID</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch recent bookings
                require '../config.php'; // Reconnect to the database
                $recentBookingsQuery = "
                    SELECT 
                        b.b_id, 
                        p.p_name, 
                        b.ps_id, 
                        b.b_date, 
                        b.b_time, 
                        b.b_status 
                    FROM 
                        bookinfo b
                    JOIN 
                        profiles p ON b.u_id = p.u_id
                    ORDER BY 
                        b.b_date DESC, b.b_time DESC
                    LIMIT 10
                ";
                $recentBookingsResult = $conn->query($recentBookingsQuery);
                
                if ($recentBookingsResult->num_rows > 0) {
                    while($row = $recentBookingsResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['b_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['p_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['ps_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['b_date'] . ' ' . $row['b_time']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['b_status']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No recent bookings found.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const ctx = document.getElementById('bookingsChart').getContext('2d');
            const labels = <?php echo $labels; ?>;
            const bookings = <?php echo $bookings; ?>;
            
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Bookings',
                        data: bookings,
                        backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(75, 192, 192, 0.2)'],
                        borderColor: ['rgba(54, 162, 235, 1)', 'rgba(75, 192, 192, 1)'],
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
