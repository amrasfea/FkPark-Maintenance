<?php
session_start();
require '../config.php'; // Database connection

// Fetch student information based on the provided ID
$studentId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$student = null;

if ($studentId > 0) {
    $studentQuery = "SELECT p_name, p_email, p_course, p_faculty, p_icNumber,p_phoneNum, p_address, p_postCode, p_country, p_state 
                     FROM profiles 
                     WHERE u_id = ?";
    $stmt = $conn->prepare($studentQuery);
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();
}

if (!$student) {
    echo "No student found with the given ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registration</title>
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>View Registration</h2>
        <div>
            <p>ID: <?php echo htmlspecialchars($studentId); ?></p>
            <p>Name: <?php echo htmlspecialchars($student['p_name']); ?></p>
            <p>Email: <?php echo htmlspecialchars($student['p_email']); ?></p>
            <p>Course: <?php echo htmlspecialchars($student['p_course']); ?></p>
            <p>Faculty: <?php echo htmlspecialchars($student['p_faculty']); ?></p>
            <p>IC Number: <?php echo htmlspecialchars($student['p_icNumber']); ?></p>
            <p>Phone Number: <?php echo htmlspecialchars($student['p_phoneNum']); ?></p>
            <p>Address: <?php echo htmlspecialchars($student['p_address']); ?></p>
            <p>Post Code: <?php echo htmlspecialchars($student['p_postCode']); ?></p>
            <p>Country: <?php echo htmlspecialchars($student['p_country']); ?></p>
            <p>State: <?php echo htmlspecialchars($student['p_state']); ?></p>
        </div>
        <!-- Back button to navigate to the listRegistration page -->
        <a href="listRegistration.php" class="back-button">Back</a>
    </div>
</body>
</html>


