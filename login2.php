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
                <option value="admin">Administrators</option>
                <option value="student">Student</option>
                <option value="staff">Unit Keselamatan Staff</option>
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

  <?php
  // Process form submission
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $user = $_POST["user"];

    if ($user === "admin") {
      header("Location: ./admin/adminDashboard.php");
      exit();
    } elseif ($user === "staff") {
      header("Location: ./staff/staffHome.php");
      exit();
    } else {
      header("Location: ./student/studentProfile.php");
      exit();
    }
  }
  ?>
</body>

</html>

