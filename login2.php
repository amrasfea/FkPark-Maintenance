<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--EXTERNAL CSS-->
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
                    <p>Login to your Account</p>
                </div>
                <form action="functions/submitLogin.php" method="post" name="login" id="login">
                    <div class="row">
                        <div class="col mb-3">
                            Your Username: <input type="text" name="username" placeholder="Username" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            Your Password: <input type="password" name="password" placeholder="Password" required />
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