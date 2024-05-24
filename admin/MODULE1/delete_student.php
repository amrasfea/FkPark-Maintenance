<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $p_id = $_GET['id'];

    // Delete record
    $sql = "DELETE FROM profiles WHERE p_id = $p_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: register_student.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
