<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "fkpark";

// Create connection
$conn = mysqli_connect($server, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if not exists
if (mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS $dbname")) {
    echo "Database created successfully or already exists.<br>";
} else {
    die("Error creating database: " . mysqli_error($conn));
}

// Select database
mysqli_select_db($conn, $dbname) or die(mysqli_error($conn));

?>