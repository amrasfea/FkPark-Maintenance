<?php
// Assuming a connection to the database is already established

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $v_type = $_POST['v_type'];
    $v_brand = $_POST['v_brand'];
    $v_model = $_POST['v_model'];
    $v_roadTaxValidDate = $_POST['v_roadTaxValidDate'];
    $v_licenceValidDate = $_POST['v_licenceValidDate'];
    $v_phoneNum = $_POST['v_phoneNum'];
    $v_qrCode = $_POST['v_qrCode'];
    $v_approvalStatus = $_POST['v_approvalStatus'];
    $v_remarks = $_POST['v_remarks'];
    $u_id = $_POST['u_id'];

    // Handle file upload for vehicle grant
    $v_vehicleGrant = $_FILES['v_vehicleGrant']['tmp_name'];
    $v_vehicleGrantContent = file_get_contents($v_vehicleGrant);

    // Prepare SQL statement
    $sql = "INSERT INTO vehicle_registration (v_type, v_brand, v_model, v_roadTaxValidDate, v_licenceValidDate, v_phoneNum, v_vehicleGrant, v_approvalStatus, v_remarks, v_qrCode, u_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssbssss", $v_type, $v_brand, $v_model, $v_roadTaxValidDate, $v_licenceValidDate, $v_phoneNum, $v_vehicleGrantContent, $v_approvalStatus, $v_remarks, $v_qrCode, $u_id);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
