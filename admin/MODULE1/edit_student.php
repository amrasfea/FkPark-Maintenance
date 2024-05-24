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

    // Fetch record to edit
    $sql = "SELECT * FROM profiles WHERE p_id = $p_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $p_id = $_POST['p_id'];
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

    $sql = "UPDATE profiles SET p_name='$p_name', p_course='$p_course', p_faculty='$p_faculty', p_icNumber='$p_icNumber', p_address='$p_address', p_postCode='$p_postCode', p_country='$p_country', p_state='$p_state', p_department='$p_department', p_bodyNumber='$p_bodyNumber', u_id='$u_id' WHERE p_id=$p_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: register_student.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Student</h2>
        <form action="edit_student.php" method="POST">
            <input type="hidden" name="p_id" value="<?php echo $row['p_id']; ?>">
            <div class="form-group">
                <label for="p_name">Name</label>
                <input type="text" id="p_name" name="p_name" value="<?php echo $row['p_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="p_course">Course</label>
                <select id="p_course" name="p_course" required>
                    <option value="SOFTWARE ENGINEERING" <?php if($row['p_course'] == 'SOFTWARE ENGINEERING') echo 'selected'; ?>>Software Engineering</option>
                    <option value="NETWORKING" <?php if($row['p_course'] == 'NETWORKING') echo 'selected'; ?>>Networking</option>
                    <option value="GRAPHIC DESIGN" <?php if($row['p_course'] == 'GRAPHIC DESIGN') echo 'selected'; ?>>Graphic Design</option>
                </select>
            </div>
            <div class="form-group">
                <label for="p_faculty">Faculty</label>
                <input type="text" id="p_faculty" name="p_faculty" value="<?php echo $row['p_faculty']; ?>">
            </div>
            <div class="form-group">
                <label for="p_icNumber">IC Number</label>
                <input type="text" id="p_icNumber" name="p_icNumber" value="<?php echo $row['p_icNumber']; ?>" required>
            </div>
            <div class="form-group">
                <label for="p_address">Address</label>
                <input type="text" id="p_address" name="p_address" value="<?php echo $row['p_address']; ?>">
            </div>
            <div class="form-group">
                <label for="p_postCode">Post Code</label>
                <input type="text" id="p_postCode" name="p_postCode" value="<?php echo $row['p_postCode']; ?>">
            </div>
            <div class="form-group">
                <label for="p_country">Country</label>
                <input type="text" id="p_country" name="p_country" value="<?php echo $row['p_country']; ?>">
            </div>
            <div class="form-group">
                <label for="p_state">State</label>
                <input type="text" id="p_state" name="p_state" value="<?php echo $row['p_state']; ?>">
            </div>
            <div class="form-group">
                <label for="p_department">Department</label>
                <input type="text" id="p_department" name="p_department" value="<?php echo $row['p_department']; ?>">
            </div>
            <div class="form-group">
                <label for="p_bodyNumber">Body Number</label>
                <input type="text" id="p_bodyNumber" name="p_bodyNumber" value="<?php echo $row['p_bodyNumber']; ?>">
            </div>
            <div class="form-group">
                <label for="u_id">User ID</label>
                <input type="text" id="u_id" name="u_id" value="<?php echo $row['u_id']; ?>">
            </div>
            <div class="button-group">
                <button type="submit">Save</button>
            </div>
        </form>
    </div>
</body>
</html>
