<!-- by umairah -->

<?php
include '../config.php';
require '../phpqrcode/qrlib.php';

$message = '';

if (isset($_POST['save'])) {
    $ps_area = $_POST["ps_area"];
    $ps_id = $_POST["ps_id"];
    $ps_category = $_POST["ps_category"];
    $ps_availableStat = $_POST["ps_availableStat"];

    // Check if the connection is established
    if ($conn === null) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // SQL statement to insert data including QR code path
    $sql = "INSERT INTO parkSpace (ps_area, ps_id, ps_category, ps_availableStat, ps_QR) VALUES (?, ?, ?, ?, ?)";

    // Using prepared statement to prevent SQL injection
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Generate QR code data
        $qrData = "Parking Area: $ps_area\nParking ID: $ps_id\nCategory: $ps_category\nStatus: $ps_availableStat";
        $qrCodeFilePath = '../qrcodes/parkspace_' . $ps_id . '.png';
        QRcode::png($qrData, $qrCodeFilePath, QR_ECLEVEL_L, 10);

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssss", $ps_area, $ps_id, $ps_category, $ps_availableStat, $qrCodeFilePath);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $message = "Data inserted successfully";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    } else {
        $message = "Failed to prepare statement: " . mysqli_error($conn);
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($conn);
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
    <style>
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>Parking Space Form</h2>
        <?php if ($message != ''): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form id="parkingForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            
            <div class="form-group">
                <label for="ps_area">Parking Area:</label>
                <input type="text" class="form-control" id="ps_area" name="ps_area" required>

                <label for="spaceno">Space Number:</label>
                <input type="text" class="form-control" id="spaceno" name="spaceno">

                <label for="ps_id">Parking ID:</label>
                <input type="text" class="form-control" id="ps_id" name="ps_id" required>

                <label for="ps_category">Category:</label>
                <input type="text" class="form-control" id="ps_category" name="ps_category" required>

                <label for="ps_availableStat">Status:</label>
                <input type="text" class="form-control" id="ps_availableStat" name="ps_availableStat" value="available" required>
            </div>
            <div class="button-group">
                <button type="button" name="cancel" onclick="clearForm()">Cancel</button>
                <button type="submit" name="save">Save</button>
            </div>
        </form>
    </div>

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
