<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--EXTERNAL LINK-->
  <link rel="stylesheet" href="css/login2.css">
</head>

<body>
    <div class="container">
        <a href="index.php">
            <img src="img/logo.png" alt="Logo" width="180" height="100">
        </a>
        <div class="form">
            <h1 class="title"><i>FKPark Management System</i></h1>
            <div class="content">
                <div class="row">
                    <h2>LOGIN</h2>
                </div>
                <form action="" method="post" name="login" id="login">
                    <div class="row">
                        <div class="col mb-3">
                            Username: <input type="text" name="username" placeholder="Username" required />
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
                            <input name="submit" type="submit" value="Login" />
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</body>

</html>