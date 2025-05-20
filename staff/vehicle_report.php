<?php
require '../session_check.php';
require '../config.php';

if ($_SESSION['role'] !== 'Unit Keselamatan Staff') {
    header("Location: ../login2.php");
    exit();
}

// Get total vehicle counts (Cars and Motorcycles)
$totalQuery = "
    SELECT v.v_vehicleType, COUNT(*) as total
    FROM vehicle v
    JOIN user u ON v.u_id = u.u_id
    WHERE u.u_type = 'Student'
    GROUP BY v.v_vehicleType
";

$totalResult = $conn->query($totalQuery);
$vehicleCounts = ['CAR' => 0, 'MOTORCYCLE' => 0];

while ($row = $totalResult->fetch_assoc()) {
    $vehicleCounts[$row['v_vehicleType']] = $row['total'];
}

// Get vehicle counts by course (Cars and Motorcycles)
$courseVehicleCounts = [];
$courseQuery = "
    SELECT p.p_course, v.v_vehicleType, COUNT(*) as total
    FROM profiles p
    JOIN user u ON p.u_id = u.u_id
    LEFT JOIN vehicle v ON u.u_id = v.u_id
    WHERE u.u_type = 'Student'
    GROUP BY p.p_course, v.v_vehicleType
";

$courseResult = $conn->query($courseQuery);
while ($row = $courseResult->fetch_assoc()) {
    $courseVehicleCounts[$row['p_course']][$row['v_vehicleType']] = $row['total'];
}

// Get student profiles with or without vehicles
$detailsQuery = "
    SELECT p.p_course, p.p_name, v.v_vehicleType
    FROM profiles p
    JOIN user u ON p.u_id = u.u_id
    LEFT JOIN vehicle v ON u.u_id = v.u_id
    WHERE u.u_type = 'Student'
    ORDER BY p.p_course, p.p_name
";

$detailsResult = $conn->query($detailsQuery);

// Group students by course
$vehiclesByCourse = [];
while ($row = $detailsResult->fetch_assoc()) {
    $course = $row['p_course'] ?? 'Unspecified';
    $vehiclesByCourse[$course][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Vehicle Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }
        .card {
            border-left: 5px solid #0d6efd;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .section-title {
            border-bottom: 2px solid #0d6efd;
            margin: 2rem 0 1rem;
            padding-bottom: .5rem;
        }
        .course-section {
            margin-bottom: 2rem;
        }
        .btn-outline-primary {
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include('../navigation/staffNav.php'); ?>

<div class="container py-5">
    <h2 class="text-center mb-4">Student Vehicle Report</h2>

    <!-- Total Vehicle Count -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card p-4 text-center">
                <h5>Total Cars</h5>
                <h2 class="text-primary"><?= $vehicleCounts['CAR'] ?></h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 text-center">
                <h5>Total Motorcycles</h5>
                <h2 class="text-primary"><?= $vehicleCounts['MOTORCYCLE'] ?></h2>
            </div>
        </div>
    </div>

    <!-- Course-wise Vehicle Listing -->
    <div class="section-title">
        <h4>Vehicle Registrations by Course</h4>
    </div>

    <?php foreach ($vehiclesByCourse as $course => $students): ?>
        <div class="course-section">
            <button class="btn btn-outline-primary w-100 text-start mb-2" data-bs-toggle="collapse" data-bs-target="#course-<?= md5($course) ?>">
                <?= htmlspecialchars($course) ?>
            </button>
            <div class="collapse show" id="course-<?= md5($course) ?>">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th>Student Name</th>
                                <th>Vehicle Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?= htmlspecialchars($student['p_name']) ?></td>
                                    <td><?= $student['v_vehicleType'] ? htmlspecialchars($student['v_vehicleType']) : 'No Vehicle' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- Vehicle Counts by Course -->
                    <div class="d-flex justify-content-between mt-3">
                        <div><strong>Total Cars:</strong> <?= $courseVehicleCounts[$course]['CAR'] ?? 0 ?></div>
                        <div><strong>Total Motorcycles:</strong> <?= $courseVehicleCounts[$course]['MOTORCYCLE'] ?? 0 ?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
