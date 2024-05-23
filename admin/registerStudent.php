<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/studentRegister.css">
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container">
        <h2>Register Student</h2>
        <form action="register_student.php" method="POST">
            <div class="form-group">
                <label for="p_name">Name</label>
                <input type="text" id="p_name" name="p_name" required>
            </div>
            <div class="form-group">
                <label for="p_course">Course</label>
                <select id="p_course" name="p_course" required>
                    <option value="SOFTWARE ENGINEERING">Software Engineering</option>
                    <option value="NETWORKING">Networking</option>
                    <option value="GRAPHIC DESIGN">Graphic Design</option>
                </select>
            </div>
            <div class="form-group">
                <label for="p_faculty">Faculty</label>
                <input type="text" id="p_faculty" name="p_faculty">
            </div>
            <div class="form-group">
                <label for="p_icNumber">IC Number</label>
                <input type="text" id="p_icNumber" name="p_icNumber" required>
            </div>
            <div class="form-group">
                <label for="p_address">Address</label>
                <input type="text" id="p_address" name="p_address">
            </div>
            <div class="form-group">
                <label for="p_postCode">Post Code</label>
                <input type="text" id="p_postCode" name="p_postCode">
            </div>
            <div class="form-group">
                <label for="p_country">Country</label>
                <input type="text" id="p_country" name="p_country">
            </div>
            <div class="form-group">
                <label for="p_state">State</label>
                <input type="text" id="p_state" name="p_state">
            </div>
            <div class="button-group">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
