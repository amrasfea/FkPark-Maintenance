<?php 
require '../session_check.php';

require '../config.php'; // Database connection

// Check if the current user is a student
if ($_SESSION['role'] !== 'Student') {
    header("Location: ../login2.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $v_type = $_POST['v_type'];
    $v_brand = $_POST['v_brand'];
    $v_model = $_POST['v_model'];
    $v_plateNum = $_POST['v_plateNum'];
    $v_roadTaxValidDate = $_POST['v_roadTaxValidDate'];
    $v_licenceValidDate = $_POST['v_licenceValidDate'];
    $v_licenceClass = $_POST['v_licenceClass'];
    $v_phoneNum = $_POST['v_phoneNum'];
    $v_vehicleGrant = $_FILES['v_vehicleGrant']['name'];

    // Validate phone number
    if (!is_numeric($v_phoneNum)) {
        die("Invalid phone number");
    }

    // Ensure the upload directory exists
    $target_dir = "../uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["v_vehicleGrant"]["name"]);
    if (!move_uploaded_file($_FILES["v_vehicleGrant"]["tmp_name"], $target_file)) {
        die("Error uploading file");
    }

    // Retrieve the user ID from the session
    $u_id = $_SESSION['u_id'];

    // Insert data into database with initial status 'Pending'
    $stmt = $conn->prepare("INSERT INTO vehicle (v_vehicleType, v_brand, v_model, v_plateNum, v_roadTaxValidDate, v_licenceValidDate, v_licenceClass, v_phoneNum, v_vehicleGrant, v_approvalStatus, u_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?)");
    $stmt->bind_param("sssssssssi", $v_type, $v_brand, $v_model, $v_plateNum, $v_roadTaxValidDate, $v_licenceValidDate, $v_licenceClass, $v_phoneNum, $v_vehicleGrant, $u_id);

    if ($stmt->execute()) {
        $v_id = $stmt->insert_id;
        header("Location: statusApplication.php?v_id=$v_id");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Registration</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <link rel="stylesheet" href="../css/vehicleForm.css">
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <h2>Vehicle Registration Form</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="v_type" class="form-label">Vehicle Type</label>
            <select class="form-select" id="v_type" name="v_type" required>
                <option value="MOTORCYCLE">Motorcycle</option>
                <option value="CAR">Car</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="v_brand" class="form-label">Brand</label>
            <input type="text" class="form-control" id="v_brand" name="v_brand" required>
        </div>
        <div class="mb-3">
            <label for="v_model" class="form-label">Model</label>
            <input type="text" class="form-control" id="v_model" name="v_model" required>
        </div>
        <div class="mb-3">
            <label for="v_plateNum" class="form-label">Plate Number</label>
            <input type="text" class="form-control" id="v_plateNum" name="v_plateNum" required>
        </div>
        <div class="mb-3">
            <label for="v_roadTaxValidDate" class="form-label">Road Tax Valid Date</label>
            <input type="date" class="form-control" id="v_roadTaxValidDate" name="v_roadTaxValidDate" required>
        </div>
        <div class="mb-3">
            <label for="v_licenceValidDate" class="form-label">License Valid Date</label>
            <input type="date" class="form-control" id="v_licenceValidDate" name="v_licenceValidDate" required>
        </div>
        <div class="mb-3">
            <label for="v_licenceClass" class="form-label">License Class</label>
            <select class="form-select" id="v_licenceClass" name="v_licenceClass" required>
                <option value="B">B</option>
                <option value="B1">B1</option>
                <option value="B2">B2</option>
                <option value="D">D</option>
                <option value="DA">DA</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="v_phoneNum" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="v_phoneNum" name="v_phoneNum" required>
        </div>
        <div class="mb-3">
            <label for="v_vehicleGrant" class="form-label">Vehicle Grant</label>
            <input type="file" class="form-control" id="v_vehicleGrant" name="v_vehicleGrant" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>
