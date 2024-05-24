<?php
// Database connection
$servername = "localhost";
$username = "root";  // replace with your database username
$password = "";  // replace with your database password
$dbname = "fkpark";    // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data safely
$v_qrCode = isset($_POST['v_qrCode']) ? $_POST['v_qrCode'] : null;
$v_approvalStatus = isset($_POST['v_approvalStatus']) ? $_POST['v_approvalStatus'] : null;
$v_remarks = isset($_POST['v_remarks']) ? $_POST['v_remarks'] : null;

$v_vehicleType = isset($_POST['v_vehicleType']) ? $_POST['v_vehicleType'] : '';
$v_brand = isset($_POST['v_brand']) ? $_POST['v_brand'] : '';
$v_roadTaxValidDate = isset($_POST['v_roadTaxValidDate']) ? $_POST['v_roadTaxValidDate'] : '';
$v_licenceValidDate = isset($_POST['v_licenceValidDate']) ? $_POST['v_licenceValidDate'] : '';
$v_licenceClass = isset($_POST['v_licenceClass']) ? $_POST['v_licenceClass'] : '';
$v_phoneNum = isset($_POST['v_phoneNum']) ? $_POST['v_phoneNum'] : '';
$v_vehicleGrant = isset($_POST['v_vehicleGrant']) ? $_POST['v_vehicleGrant'] : '';
$v_plateNum = isset($_POST['v_plateNum']) ? $_POST['v_plateNum'] : '';
$v_model = isset($_POST['v_model']) ? $_POST['v_model'] : '';
$u_id = isset($_POST['u_id']) ? $_POST['u_id'] : '';

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO vehicle (v_vehicleType, v_brand, v_roadTaxValidDate, v_licenceValidDate, v_licenceClass, v_phoneNum, v_vehicleGrant, v_approvalStatus, v_remarks, v_qrCode, v_plateNum, v_model, u_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssisissssi", $v_vehicleType, $v_brand, $v_roadTaxValidDate, $v_licenceValidDate, $v_licenceClass, $v_phoneNum, $v_vehicleGrant, $v_approvalStatus, $v_remarks, $v_qrCode, $v_plateNum, $v_model, $u_id);

// Execute the statement
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
