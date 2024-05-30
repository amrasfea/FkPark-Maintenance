<?php
require '../config.php';

// Fetch the number of registered cars
$stmt = $conn->prepare("SELECT COUNT(*) AS car_count FROM vehicle WHERE v_vehicleType = 'CAR'");
$stmt->execute();
$result = $stmt->get_result();
$car_count = $result->fetch_assoc()['car_count'];
$stmt->close();

// Fetch the number of registered motorcycles
$stmt = $conn->prepare("SELECT COUNT(*) AS motorcycle_count FROM vehicle WHERE v_vehicleType = 'MOTORCYCLE'");
$stmt->execute();
$result = $stmt->get_result();
$motorcycle_count = $result->fetch_assoc()['motorcycle_count'];
$stmt->close();

// Fetch the number of registered students
$stmt = $conn->prepare("SELECT COUNT(*) AS student_count FROM user WHERE u_type = 'Student'");
$stmt->execute();
$result = $stmt->get_result();
$student_count = $result->fetch_assoc()['student_count'];
$stmt->close();

// Fetch the total number of users
$stmt = $conn->prepare("SELECT COUNT(*) AS user_count FROM user");
$stmt->execute();
$result = $stmt->get_result();
$user_count = $result->fetch_assoc()['user_count'];
$stmt->close();

// Return the counts as a JSON response
header('Content-Type: application/json');
echo json_encode([
    'car_count' => $car_count,
    'motorcycle_count' => $motorcycle_count,
    'student_count' => $student_count,
    'user_count' => $user_count
]);
?>
