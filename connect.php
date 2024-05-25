<?php
    // Database configuration
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'fkpark';

    // Create connection
    $con=new mysqli('localhost', 'root', '', 'fkpark');
    
    // Check connection
    if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
    }
?>
