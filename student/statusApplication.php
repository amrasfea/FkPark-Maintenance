<?php 
// Retrieve vehicle information from URL parameters
$vehicleType = $_GET['v_vehicleType'];
$brand = $_GET['v_brand'];
$model = $_GET['v_model'];
$roadTaxValidDate = $_GET['v_roadTaxValidDate'];
$licenceValidDate = $_GET['v_licenceValidDate'];
$licenceClass = $_GET['v_licenceClass'];
$phoneNum = $_GET['v_phoneNum'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Application</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!--FAVICON-->
</head>
<body>
    <?php include('../navigation/studentNav.php'); ?>
    <div class="container mt-5">
        <h2>Status Application</h2>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Vehicle Type</th>
                    <th>Status</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <!-- Display vehicle information -->
                <tr>
                    <td><?php echo $_SESSION['username']; ?></td>
                    <td><?php echo $vehicleType; ?></td>
                    <td>Pending</td>
                    <td>Submitted for approval</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
