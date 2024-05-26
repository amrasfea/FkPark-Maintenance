<?php
require 'config.php'; // Database connection

function createUser($conn, $email, $password, $role, $name, $icNumber, $phoneNum) {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Get the role id from the roles table
    $roleQuery = "SELECT r_id FROM roles WHERE r_typeName = ?";
    $stmt = $conn->prepare($roleQuery);
    $stmt->bind_param("s", $role);
    $stmt->execute();
    $stmt->bind_result($roleId);
    $stmt->fetch();
    $stmt->close();

    if (!$roleId) {
        die("Role $role does not exist.");
    }

    // Create new user with the selected role
    $userQuery = "INSERT INTO user (u_email, u_password, r_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("ssi", $email, $hashedPassword, $roleId);
    $stmt->execute();
    $userId = $stmt->insert_id;
    $stmt->close();

    // Create profile for the admin or staff
    $profileQuery = "INSERT INTO profiles (p_name, p_email, p_icNumber, p_phoneNum, u_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($profileQuery);
    $stmt->bind_param("sssii", $name, $email, $icNumber, $phoneNum, $userId);
    $stmt->execute();
    $stmt->close();

    echo ucfirst($role) . " $name registered successfully.<br>";
}

// Default admin user
createUser($conn, "admin@example.com", "admin123", "Administrators", "Admin Name", "123456789", "1234567890");

// Default staff user
createUser($conn, "staff@example.com", "staff123", "Unit Keselamatan Staff", "Staff Name", "987654321", "0987654321");

echo "Default users created successfully.";
?>
