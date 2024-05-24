<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registration</title>
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
</head>
<body>
    <?php include('../navigation/staffNav.php'); ?>
    <div class="container mt-5">
        <h2>View vehicle Application</h2>
        <!-- Your PHP code to fetch and display registration details will go here -->
        <div>
            <p>Type: Car</p>
            <p>Brand: Perodua</p>
            <p>Model: Myvi</p>
            <p>Road Tax Valid Date: 12/03/2025</p>
            <p>Licence Valid Date: 012/04/2024</p>
            <p>Licence Class: D</p>
            <p>Phone Number: 0199336892</p>
            <p>Vehicle Grant: <grant class="pdf"></grant></p>
            <!-- Additional registration details go here -->
        </div>
        <!-- Back button to navigate to the listRegistration page -->
        <a href="../staff/listVehicleApplication.php" class="back-button">Back</a>
        <a href="../staff/qrCode.php" class="back-button">Approve</a>
    </div>
</body>
</html>
