<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}
// Retrieve the user ID from the session
$u_id = $_SESSION['u_id'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ps_id = $_POST['ps_id'];
    $b_date = $_POST['b_date'];
    $b_time = $_POST['b_time'];
    $b_plateNum = $_POST['b_plateNum'];

    // Validate required fields
    if (empty($ps_id) || empty($b_date) || empty($b_time) || empty($b_plateNum)) {
        echo "All form fields are required.";
    } else {
        // Insert booking into database
        $stmt = $conn->prepare("INSERT INTO bookInfo ('ps_id','b_date, 'b_time','b_plateNum') VALUES (?, ?, ?, ?)");
        $b_id = uniqid('B'); // Generate a unique booking ID
        $b_parkStart = null;
        $b_duration = null;
        $b_status = 'Pending';
        $b_QRid = '';
        
        $stmt->bind_param("ssss", $ps_id, $b_date, $b_time,$b_plateNum);

    include('../navigation/studentNav.php');  
        if ($stmt->execute()) {
            // Confirmation message with booking details
            echo "<div class='container mt-5'>";
            echo "<h2>Booking Confirmation</h2>";
            echo "<p>Parking Space: $ps_id</p>";
            echo "<p>Parking Date: $b_date</p>";
            echo "<p>Parking Time: $b_time</p>";
            echo "<p>Car Plate Number: $b_plateNum</p>";
            echo "<a href='bookList.php' class='btn btn-primary'>Go to Booking List</a>";
            echo "</div>";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    }
}

$conn->close();
?>
