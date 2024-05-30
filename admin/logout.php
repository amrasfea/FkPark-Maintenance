<?php
/*
Filename: logout.php
Purpose: To logout from the website and destroy the self identity.
*/
//Start session 
session_start ();

//Unset the variables stored in session 
session_destroy () ;
?>

<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>Logged Out</title>
    <link href="Stylesheet.css" rel="stylesheet" type="text/css" /> 
</head> 
<body>
<header>
    <img src="../uploads/img.png" style="height:200px" width="1520px">
</header>
<h1 align="center">See you again, bye!!! </h1> 
<h4 align="center" class="err">You have been logged out. </h4> 
<p align="center">Click here to <a href="../login2.php">Login</a></p> 

</body>
</htm1>