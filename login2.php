<?php
session_start();
require 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $userType = $_POST["user"];

    // Get role id from the roles table
    $roleQuery = "SELECT r_id FROM roles WHERE r_typeName = ?";
    $stmt = $conn->prepare($roleQuery);
    $stmt->bind_param("s", $userType);
    $stmt->execute();
    $stmt->bind_result($roleId);
    $stmt->fetch();
    $stmt->close();

    // Verify user credentials
    $query = "SELECT u_id, u_password FROM user WHERE u_email = ? AND r_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $email, $roleId);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['role'] = $userType;

        // Redirect based on user type
        if ($userType === "Administrators") {
            header("Location: ./admin/adminDashboard.php");
        } elseif ($userType === "Unit Keselamatan Staff") {
            header("Location: ./staff/staffHome.php");
        } else {
            header("Location: ./student/studentProfile.php");
        }
        exit();
    } else {
        echo "Invalid email or password";
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
        </form>
      </div>
    </div>
  </div>
</body>
</html>


