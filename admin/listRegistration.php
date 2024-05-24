<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fkpark";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $p_name = $_POST['p_name'];
    $p_course = $_POST['p_course'];
    $p_faculty = $_POST['p_faculty'];
    $p_icNumber = $_POST['p_icNumber'];
    $p_address = $_POST['p_address'];
    $p_postCode = $_POST['p_postCode'];
    $p_country = $_POST['p_country'];
    $p_state = $_POST['p_state'];
    $p_department = $_POST['p_department'];
    $p_bodyNumber = $_POST['p_bodyNumber'];
    $u_id = $_POST['u_id'];

    $sql = "INSERT INTO profiles (p_name, p_course, p_faculty, p_icNumber, p_address, p_postCode, p_country, p_state, p_department, p_bodyNumber, u_id)
            VALUES ('$p_name', '$p_course', '$p_faculty', '$p_icNumber', '$p_address', '$p_postCode', '$p_country', '$p_state', '$p_department', '$p_bodyNumber', '$u_id')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch records to display
$sql = "SELECT * FROM profiles";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>Registered Students</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Faculty</th>
                    <th>IC Number</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['p_id']}</td>
                            <td>{$row['p_name']}</td>
                            <td>{$row['p_course']}</td>
                            <td>{$row['p_faculty']}</td>
                            <td>{$row['p_icNumber']}</td>
                            <td>
                                <a href='edit_student.php?id={$row['p_id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='delete_student.php?id={$row['p_id']}' class='btn btn-danger btn-sm'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
