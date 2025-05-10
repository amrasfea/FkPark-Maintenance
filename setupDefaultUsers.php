<?php
require 'config.php'; // Database connection

function createUser($conn, $email, $password, $role, $name, $icNumber, $phoneNum, $department, $bodyNumber, $position) {
    // Hash the password
    //test
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Create new user with the specified role
    $userQuery = "INSERT INTO user (u_email, u_password, u_type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($userQuery);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sss", $email, $hashedPassword, $role);
    $stmt->execute();
    if ($stmt->error) {
        die("Execute failed: " . $stmt->error);
    }
    $userId = $stmt->insert_id;
    $stmt->close();

    // Create profile for the user
    $profileQuery = "INSERT INTO profiles (p_name, p_email, p_icNumber, p_phoneNum, p_department, p_bodyNumber, p_position, u_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($profileQuery);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sssssssi", $name, $email, $icNumber, $phoneNum, $department, $bodyNumber, $position, $userId);
    $stmt->execute();
    if ($stmt->error) {
        die("Execute failed: " . $stmt->error);
    }
    $stmt->close();

    echo ucfirst($role) . " $name registered successfully.<br>";
}

// Default admin user
createUser($conn, "amirul@gmail.com", "admin123", "Administrators", "Amirul bin Ahmad", "6901010305", "0199336892", "Security", "K101", "Administrator Officer");

// Default staff user
createUser($conn, "Akmal@gmail.com", "staff123", "Unit Keselamatan Staff", "Akmal bin Ali", "701001031919", "01129406033", "Emergency Responce","K102","Safety Officer");

echo "Default users created successfully.";
?>

