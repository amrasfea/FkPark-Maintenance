<?php
/*
Filename: logout.php
Purpose: To logout from the website and destroy the self identity.
*/

// Start session only if it hasn't been started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Unset the variables stored in session and destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Logged Out</title>
<link href="Stylesheet.css" rel="stylesheet" type="text/css" />
</head>
<body>
<header>
    <img src="./img/images.png" style="height:200px; width:1520px;">
</header>
<h1 align="center">See you again, bye!!! </h1>
<h4 align="center" class="err">You have been logged out.</h4>
<p align="center">Click here to <a href="login2.php">Login</a></p>
</body>
</html>
