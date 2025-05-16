<?php
session_start();
require 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $userType = $_POST["user"];

    // Verify user credentials
    $query = "SELECT u_id, u_password, u_type FROM user WHERE u_email = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword, $role);
    $stmt->fetch();
    $stmt->close();

    // Check if the user exists and the role matches
    if ($userId && $role === $userType && password_verify($password, $hashedPassword)) {
        $_SESSION['u_id'] = $userId;
        $_SESSION['role'] = $userType;

        // Set session timeout duration (1 hour)
        $_SESSION['login_time'] = time();
        $_SESSION['expire_time'] = $_SESSION['login_time'] + 3600; // 3600 seconds = 1 hour

        // Redirect based on user type
        if ($userType === "Administrators") {
            header("Location: ./admin/adminDashboard.php");
        } elseif ($userType === "Unit Keselamatan Staff") {
            header("Location: ./staff/staffHome.php");
        } else {
            header("Location: ./student/studentHome.php");
        }
        exit();
    } else {
        echo "Invalid email, password, or user type.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
          <h2>LOGIN</h2>
        </div>
        <?php if (isset($_GET['session_expired'])): ?>
          <div class="row">
            <p style="color: red;">Your session has expired. Please log in again.</p>
          </div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name="login" id="login">
          <div class="row">
            <div class="col mb-3">
              Email: <input type="email" name="email" placeholder="Email" required />
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              Password: <input type="password" name="password" placeholder="Password" required />
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="user">User:</label>
              <select name="user" id="user">
                <option value="Administrators">Administrators</option>
                <option value="Student">Student</option>
                <option value="Unit Keselamatan Staff">Unit Keselamatan Staff</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <input name="login" type="submit" value="Login" />
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
                <a href="reset_password.php" style="color: blue; text-decoration: underline;">Forgot Password?</a>
           </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>



