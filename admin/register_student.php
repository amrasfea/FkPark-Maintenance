<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if the current user is an administrator
if ($_SESSION['role'] !== 'Administrators') {
    header("Location: ../login2.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["p_name"];
    $email = $_POST["p_email"];
    $matricNum = $_POST["p_matricNum"];
    $password = password_hash($_POST["p_icNumber"], PASSWORD_DEFAULT); // For simplicity, using IC number as password
    $course = $_POST["p_course"];
    $faculty = $_POST["p_faculty"];
    $icNumber = $_POST["p_icNumber"];
    $address = $_POST["p_address"];
    $postCode = $_POST["p_postCode"];
    $country = $_POST["p_country"];
    $state = $_POST["p_state"];
    $userType = 'Student'; // Explicitly setting the user type to Student

    // Create new user with the specified role
    $userQuery = "INSERT INTO user (u_email, u_password, u_type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("sss", $email, $password, $userType);
    $stmt->execute();
    $userId = $stmt->insert_id;
    $stmt->close();

    // Create student profile
    $profileQuery = "INSERT INTO profiles (p_name, p_email, p_matricNum, p_course, p_faculty, p_icNumber, p_address, p_postCode, p_country, p_state, u_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($profileQuery);
    $stmt->bind_param("ssssssssssi", $name, $email, $matricNum, $course, $faculty, $icNumber, $address, $postCode, $country, $state, $userId);
    $stmt->execute();
    $stmt->close();

    // Set the success message in session
    $_SESSION['successMessage'] = "Student registered successfully.";

    // Redirect to the list registration page with the newly registered student information
    header("Location: listregistration.php?newly_registered_id=$userId");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/studentRegister.css">
</head>
<body>
<?php include('../navigation/adminNav.php'); ?>
    <div class="container">
        <h2>Register Student</h2>
        <form action="register_student.php" method="POST">
            <div class="form-group">
                <label for="p_name">Name</label>
                <input type="text" id="p_name" name="p_name" required>
            </div>
            <div class="form-group">
                <label for="p_course">Course</label>
                <select id="p_course" name="p_course" required>
                    <option value="SOFTWARE ENGINEERING">Software Engineering</option>
                    <option value="NETWORKING">Networking</option>
                    <option value="GRAPHIC DESIGN">Graphic Design</option>
                </select>
            </div>
            <div class="form-group">
                <label for="p_faculty">Faculty</label>
                <input type="text" id="p_faculty" name="p_faculty">
            </div>
            <div class="form-group">
                <label for="p_icNumber">IC Number</label>
                <input type="text" id="p_icNumber" name="p_icNumber" required>
            </div>
            <div class="form-group">
                <label for="p_email">Email</label>
                <input type="email" id="p_email" name="p_email" required>
            </div>
            <div class="form-group">
                <label for="p_matricNum">Matric Number</label>
                <input type="text" id="p_matricNum" name="p_matricNum" required>
            </div>
            <div class="form-group">
                <label for="p_address">Address</label>
                <input type="text" id="p_address" name="p_address">
            </div>
            <div class="form-group">
                <label for="p_postCode">Post Code</label>
                <input type="text" id="p_postCode" name="p_postCode">
            </div>
            <div class="form-group">
                <label for="p_country">Country</label>
                <input type="text" id="p_country" name="p_country">
            </div>
            <div class="form-group">
                <label for="p_state">State</label>
                <input type="text" id="p_state" name="p_state">
            </div>
            <div class="button-group">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
