<?php
require '../session_check.php';
require '../config.php'; // Database connection

include '../phpqrcode/qrlib.php'; // Path to the PHP QR Code library

$message = '';

if(isset($_POST['save'])){
    $ps_area = $_POST["ps_area"];
    $ps_id = $_POST["ps_id"];
    $ps_category = $_POST["ps_category"];
    $spaceno = $_POST["spaceno"];

    // Check if the connection is established
    if ($conn === null) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Insert park space details into database
    $sql = "INSERT INTO parkSpace (ps_area, ps_id, ps_category, spaceno) VALUES (?, ?, ?, ?)";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "ssss", $ps_area, $ps_id, $ps_category, $spaceno);
        if(mysqli_stmt_execute($stmt)){
            // Get the last inserted ID
            $last_id = mysqli_insert_id($conn);

            // Generate QR Code
            $qrCodeData = "ID: $ps_id, Area: $ps_area, Category: $ps_category, Space No: $spaceno";
            $qrCodeFilePath = '../qrcodes/park_space_' . $last_id . '.png';
            QRcode::png($qrCodeData, $qrCodeFilePath, QR_ECLEVEL_L, 10);

            // Update the database with the QR code path
            $updateQuery = "UPDATE parkSpace SET ps_QR = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "si", $qrCodeFilePath, $last_id);
            mysqli_stmt_execute($updateStmt);
            mysqli_stmt_close($updateStmt);

            $message = "Data inserted successfully with QR code";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "Failed to prepare statement: " . mysqli_error($conn);
    }

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
