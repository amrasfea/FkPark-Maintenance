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

// Check if form is submitted for updating
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $p_id = $_POST['p_id'];
    $p_name = $_POST['p_name'];
    $p_course = $_POST['p_course'];
    $p_faculty = $_POST['p_faculty'];
    $p_icNumber = $_POST['p_icNumber'];
    $p_address = $_POST['p_address'];
    $p_postCode = $_POST['p_postCode'];
    $p_country = $_POST['p_country'];
    $u_id = $_POST['u_id'];

    $sql = "UPDATE profiles SET p_name='$p_name', p_course='$p_course', p_faculty='$p_faculty', p_icNumber='$p_icNumber', p_address='$p_address', p_postCode='$p_postCode', p_country='$p_country', p_state='$p_state', p_department='$p_department', p_bodyNumber='$p_bodyNumber', u_id='$u_id' WHERE p_id='$p_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Check if id is set to fetch data for editing
if (isset($_GET['id'])) {
    $p_id = $_GET['id'];
    $sql = "SELECT * FROM profiles WHERE p_id='$p_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>Edit Student</h2>
        <form action="edit_student.php" method="post">
            <input type="hidden" name="p_id" value="<?php echo $row['p_id']; ?>">
            <div class="mb-3">
                <label for="p_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="p_name" name="p_name" value="<?php echo $row['p_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="p_course" class="form-label">Course</label>
                <input type="text" class="form-control" id="p_course" name="p_course" value="<?php echo $row['p_course']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="p_faculty" class="form-label">Faculty</label>
                <input type="text" class="form-control" id="p_faculty" name="p_faculty" value="<?php echo $row['p_faculty']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="p_icNumber" class="form-label">IC Number</label>
                <input type="text" class="form-control" id="p_icNumber" name="p_icNumber" value="<?php echo $row['p_icNumber']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="p_address" class="form-label">Address</label>
                <input type="text" class="form-control" id="p_address" name="p_address" value="<?php echo $row['p_address']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="p_postCode" class="form-label">Post Code</label>
                <input type="text" class="form-control" id="p_postCode" name="p_postCode" value="<?php echo $row['p_postCode']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="p_country" class="form-label">Country</label>
                <input type="text" class="form-control" id="p_country" name="p_country" value="<?php echo $row['p_country']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
