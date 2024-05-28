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

// Initialize the success message variable
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["p_name"];
    $course = $_POST["p_course"];
    $faculty = $_POST["p_faculty"];
    $icNumber = $_POST["p_icNumber"];
    $phoneNum = $_POST["p_phoneNum"];
    $address = $_POST["p_address"];
    $postCode = $_POST["p_postCode"];
    $country = $_POST["p_country"];
    $state = $_POST["p_state"];

    $updateQuery = "UPDATE profiles 
                    SET p_name = ?, p_course = ?, p_faculty = ?, p_icNumber = ?, p_phoneNUm = ?, p_address = ?, p_postCode = ?, p_country = ?, p_state = ?
                    WHERE u_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssssssssi", $name, $course, $faculty, $icNumber,$phoneNum, $address, $postCode, $country, $state, $studentId);
    $stmt->execute();
    $stmt->close();

    $successMessage = "Student registered successfully.";

    // Redirect to the list registration page with a success message
    header("Location: listRegistration.php?updated=1&message=Student+registered+successfully.");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <title>Edit Registration</title>
    <style>
        /* Form Styling */
        .container {
            max-width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        /* Button Styling */
        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
        .back-button {
            background-color: #007bff; /* Background color for the view button */
            margin-right: 5px; /* Adjust margin if needed */
            padding: 8px 16px; /* Adjusted padding for consistent button size */
            min-width: 80px; /* Set a minimum width for consistency */
            border: none;
            color: white;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
    </style>
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>Edit Registration</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="p_name">Name</label>
                <input type="text" id="p_name" name="p_name" value="<?php echo htmlspecialchars($student['p_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="p_course">Course</label>
                <input type="text" id="p_course" name="p_course" value="<?php echo htmlspecialchars($student['p_course']); ?>" required>
            </div>
            <div class="form-group">
                <label for="p_faculty">Faculty</label>
                <input type="text" id="p_faculty" name="p_faculty" value="<?php echo htmlspecialchars($student['p_faculty']); ?>" required>
            </div>
            <div class="form-group">
                <label for="p_icNumber">IC Number</label>
                <input type="text" id="p_icNumber" name="p_icNumber" value="<?php echo htmlspecialchars($student['p_icNumber']); ?>" required>
            </div>
            <div class="form-group">
                <label for="p_phoneNum">Phone Number</label>
                <input type="text" id="p_phoneNum" name="p_phoneNum" value="<?php echo htmlspecialchars($student['p_phoneNum']); ?>" required>
            </div>
            <div class="form-group">
                <label for="p_address">Address</label>
                <input type="text" id="p_address" name="p_address" value="<?php echo htmlspecialchars($student['p_address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="p_postCode">Post Code</label>
                <input type="text" id="p_postCode" name="p_postCode" value="<?php echo htmlspecialchars($student['p_postCode']); ?>" required>
            </div>
            <div class="form-group">
                <label for="p_country">Country</label>
                <input type="text" id="p_country" name="p_country" value="<?php echo htmlspecialchars($student['p_country']); ?>" required>
            </div>
            <div class="form-group">
                <label for="p_state">State</label>
                <input type="text" id="p_state" name="p_state" value="<?php echo htmlspecialchars($student['p_state']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="listRegistration.php" class="back-button">Back</a>
        </form>
    </div>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>
</body>
</html>
