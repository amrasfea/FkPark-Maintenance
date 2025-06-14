<?php
require 'config.php'; // Database connection
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    // Check if passwords match
    if ($newPassword !== $confirmPassword) {
        $message = "❌ Passwords do not match.";
    } else {
        // Check if user exists
        $stmt = $conn->prepare("SELECT u_id FROM user WHERE u_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();

            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password
            $updateStmt = $conn->prepare("UPDATE user SET u_password = ? WHERE u_email = ?");
            $updateStmt->bind_param("ss", $hashedPassword, $email);
            if ($updateStmt->execute()) {
                $message = "✅ Password successfully updated! <a href='login2.php'>Login here</a>";
            } else {
                $message = "❌ Failed to update password.";
            }
            $updateStmt->close();
        } else {
            $message = "❌ Email not found in the system.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/login2.css"> <!-- Use your login CSS -->
    <link rel="icon" href="../img/logo.png">
</head>
<body>
    <div class="container">
        <div class="form">
            <img src="img/logo.png" alt="Logo" width="180" height="100">
            <h1 class="title"><i>FKPark Management System</i></h1>
            <div class="content">
                <h2>Reset Password</h2>

                <?php if ($message): ?>
                    <p style="color: <?= strpos($message, '✅') !== false ? 'green' : 'red' ?>;">
                        <?= $message ?>
                    </p>
                <?php endif; ?>

                <form method="POST">
                    <div class="row">
                        <label>Email:</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="row">
                        <label>New Password:</label>
                        <input type="password" name="new_password" required>
                    </div>
                    <div class="row">
                        <label>Confirm Password:</label>
                        <input type="password" name="confirm_password" required>
                    </div>
                    <div class="row">
                        <input type="submit" value="Reset Password">
                    </div>
                    <div class="row">
                        <a href="login2.php" style="color: blue;">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
