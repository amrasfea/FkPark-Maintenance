<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "fkpark";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ps_id = $_POST['parkingSpace'];
    $u_id = $_POST['u_id'];
    $b_date = $_POST['b_date'];
    $b_time = $_POST['b_time'];
    $v_id = $_POST['v_id'];
    $v_plateNum = $_POST['v_plateNum'];

    // SQL query to insert booking details
    $sql = "INSERT INTO bookings (ps_id, u_id, b_date, b_time, v_id, v_plateNum) 
            VALUES ('$ps_id', '$u_id', '$b_date', '$b_time', '$v_id', '$v_plateNum')";

    if ($conn->query($sql) === TRUE) {
        echo "New booking created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
``
