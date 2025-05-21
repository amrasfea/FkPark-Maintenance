<?php
require 'config.php'; // Database connection

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $newPass = password_hash($_POST["new_password"], PASSWORD_DEFAULT);

    // Check if the user exists
    $stmt = $conn->prepare("SELECT u_id FROM user WHERE u_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();

        // Update the password
        $stmt = $conn->prepare("UPDATE user SET u_password = ? WHERE u_email = ?");
        $stmt->bind_param("ss", $newPass, $email);
        $stmt->execute();
        $stmt->close();

        $message = "✅ Password reset successfully! <a href='login2.php'>Login here</a>";
    } else {
        $message = "❌ Email not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/login2.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
</head>
<body>
    <div class="container">
        <div class="form">
            <a>
                <img src="img/logo.png" alt="Logo" width="180" height="100">
            </a>
            <h1 class="title"><i>FKPark Management System</i></h1>
            <div class="content">
                <div class="row">
                    <h2>Reset Password</h2>
                </div>

                <?php if ($message): ?>
                    <div class="row">
                        <p style="color: <?= strpos($message, '✅') !== false ? 'green' : 'red' ?>;">
                            <?= $message ?>
                        </p>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="row">
                        <div class="col mb-3">
                            Email: <input type="email" name="email" placeholder="Email" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            New Password: <input type="password" name="new_password" placeholder="New Password" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <input type="submit" value="Reset Password" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <a href="login2.php" style="color: blue; text-decoration: underline;">Back to Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
