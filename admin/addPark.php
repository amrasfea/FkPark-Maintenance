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
        <form method="post" action="">
            <div class="button-group">
                <button type="submit" name="newForm">New Form</button>
            </div>
            <div class="form-group">
                <label for="vType">Vehicle type:</label>
                <select name="vType" id="vType">
                    <option value="car">Car</option>
                    <option value="motorcycle">Motorcycle</option>
                </select>

                <label for="vModel">Vehicle Model:</label>
                <input type="text" class="form-control" id="vModel" name="vModel">

                <label for="vBrand">Vehicle Brand:</label>
                <input type="text" class="form-control" id="vBrand" name="vBrand">

                <label for="vPlate">Vehicle Plate Number:</label>
                <input type="text" class="form-control" id="vPlate" name="vPlate">

                <label for="parkLoc">Parking Location:</label>
                <input type="text" class="form-control" id="parkLoc" name="parkLoc">

                <label for="violation">Violation type:</label>
                <select name="violation" id="violation">
                    <option value="1">Parking Violation</option>
                    <option value="2">Not comply in campus traffic regulations</option>
                    <option value="3">Caused accidents</option>
                </select>
            </div>
            <div class="button-group">
                <button type="submit" name="guide">Traffic Violation Guide and Demerit</button>
            </div>
            <div class="button-group">
                <button type="submit" name="noti">Send Notification</button>
                <button type="submit" name="print">Print Receipt</button>
                <button type="submit" name="edit">Edit</button>
                <button type="submit" name="save">Save</button>
            </div>
        </form>
    </div>
</body>
</html>
