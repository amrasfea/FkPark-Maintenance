<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summon</title>
    <!--EXTERNAL CSS-->
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!--FAVICON-->

</head>
<body>
<?php include('../navigation/staffNav.php'); ?>
    <div class="main p-3">
        <h2>Ticket Summon Form</h2>
        <form method="post" action="">
            <div class="button-group">
                <button type="submit" name="newForm">New Form</button>
                <button type="button" onclick="alert('Database deleted')">Delete</button>
                <input type="date" name="summonDate">
                <input type="time" name="summonTime">
            </div>
            <div class="form-group">
                <label for="vType">Vehicle type:</label>
                <select name="vType" id="vType">
                    <option value="car">Car</option>
                    <option value="motorcycle">Motorcycle</option>
                </select><br>

                <label for="vModel">Vehicle Model:</label>
                <input type="text" class="form-control" id="vModel" name="vModel"><br>

                <label for="vBrand">Vehicle Brand:</label>
                <input type="text" class="form-control" id="vBrand" name="vBrand"><br>

                <label for="vPlate">Vehicle Plate Number:</label>
                <input type="text" class="form-control" id="vPlate" name="vPlate"><br>

                <label for="parkLoc">Parking Location:</label>
                <input type="text" class="form-control" id="parkLoc" name="parkLoc"><br>

                <label for="violation">Violation type:</label>
                <select name="violation" id="violation">
                    <option value="1">Parking Violation</option>
                    <option value="2">Not comply in campus traffic regulations</option>
                    <option value="3">Caused accidents</option>
                </select>
                <div class="button-group">
                    <button type="submit" name="guide">Traffic Violation Guide and Demerit</button>
                </div>
                <div class="button-group">
                    <button type="submit" name="noti" href="">Send Notification</button>
                    <button type="submit" name="print" alert=>Print Receipt</button>
                    <button type="submit" name="edit">Edit</button>
                    <button type="submit" name="save">Save</button>
                </div>
            </div>
        </form>
    </div>

</body>
</html>
