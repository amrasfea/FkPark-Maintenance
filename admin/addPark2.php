<?php
include '../connect.php'; // Adjust the path as needed

$message = '';

if(isset($_POST['save'])){
    $ps_area = $_POST["ps_area"];
    $ps_id = $_POST["ps_id"];
    $ps_category = $_POST["ps_category"];

    // Check if the connection is established
    if ($con === null) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO parkSpace (ps_area, ps_id, ps_category) VALUES (?, ?, ?)";

    // Using prepared statement to prevent SQL injection
    if($stmt = mysqli_prepare($con, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $ps_area, $ps_id, $ps_category);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $message = "Data inserted successfully";
        } else{
            $message = "Error: " . mysqli_error($con);
        }
    } else {
        $message = "Failed to prepare statement: " . mysqli_error($con);
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Park</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!--FAVICON-->
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>Parking Space Form</h2>
        <form id="parkingForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="button-group">
                <button type="button" name="newForm" onclick="newForm()">New Form</button>
            </div>
            <div class="form-group">
                <label for="ps_area">Parking Area:</label>
                <input type="text" class="form-control" id="ps_area" name="ps_area" required>

                <label for="ps_id">Parking ID:</label>
                <input type="text" class="form-control" id="ps_id" name="ps_id" required>

                <label for="ps_category">Category:</label>
                <input type="text" class="form-control" id="ps_category" name="ps_category" required>
            </div>
            <div class="button-group">
                <button type="button" name="cancel" onclick="clearForm()">Cancel</button>
                <button type="submit" name="save">Save</button>
            </div>
        </form>
    </div>

    <?php if ($message != ''): ?>
        <script>
            alert('<?php echo $message; ?>');
        </script>
    <?php endif; ?>

    <script>
        function clearForm() {
            document.getElementById("parkingForm").reset();
        }

        function newForm() {
            clearForm();
            document.getElementById("ps_area").focus(); // Set focus to the first input field to indicate a new form is ready to be filled.
        }
    </script>
</body>
</html>
