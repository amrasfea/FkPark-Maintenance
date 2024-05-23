<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Registration</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <style>
        /* Custom styles for the registration form */
    </style>
</head>
<body>

<?php include('../navigation/studentNav.php'); ?>

<div class="container mt-5">
    <h2>Vehicle Registration Form</h2>
    <form action="submit_registration.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="v_type" class="form-label">Vehicle Type</label>
            <select class="form-select" id="v_type" name="v_type" required>
                <option value="MOTORCYCLE">Motorcycle</option>
                <option value="CAR">Car</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="v_brand" class="form-label">Brand</label>
            <input type="text" class="form-control" id="v_brand" name="v_brand" required>
        </div>
        <div class="mb-3">
            <label for="v_model" class="form-label">Model</label>
            <input type="text" class="form-control" id="v_model" name="v_model" required>
        </div>
        <div class="mb-3">
            <label for="v_roadTaxValidDate" class="form-label">Road Tax Valid Date</label>
            <input type="date" class="form-control" id="v_roadTaxValidDate" name="v_roadTaxValidDate" required>
        </div>
        <div class="mb-3">
            <label for="v_licenceValidDate" class="form-label">License Valid Date</label>
            <input type="date" class="form-control" id="v_licenceValidDate" name="v_licenceValidDate" required>
        </div>
        <div class="mb-3">
            <label for="v_phoneNum" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="v_phoneNum" name="v_phoneNum" required>
        </div>
        <div class="mb-3">
            <label for="v_vehicleGrant" class="form-label">Vehicle Grant</label>
            <input type="file" class="form-control" id="v_vehicleGrant" name="v_vehicleGrant" required>
        </div>
        <input type="hidden" name="u_id" value="<?php echo $_SESSION['u_id']; ?>">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>
