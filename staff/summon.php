<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summon</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/summon.css">
    <!--FAVICON-->
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <?php include('../navigation/staffNav.php'); ?>
    <div class="container mt-5">
        <h2>Ticket Summon Form</h2>
        <form method="post" action="">
            <div class="button-group">
                <button type="button" id="newFormBtn">New Form</button>
                <input type="date" name="summonDate">
                <input type="time" name="summonTime">
            </div>
            <div id="formFields" class="form-group hidden">
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
                <select name="violation" id="violation" onchange="fillDemerit()">
                    <option value="Parking">Parking Violation</option>
                    <option value="Traffic">Not comply in campus traffic regulations</option>
                    <option value="Accident">Caused accidents</option>
                </select>
                <label for="demerit">Demerit:</label>
                <input type="text" class="form-control" id="demerit" name="demerit">
            </div>
            <div class="button-group">
                <button type="button" id="guideBtn">Traffic Violation Guide and Demerit</button>
            </div>

            <div class="button-group">
                <button type="submit" name="noti">Send Notification</button>
                <button type="submit" name="print">Print Receipt</button>
                <button type="submit" name="save">Save</button>
            </div>
        </form>
    </div>

    <script>
        function fillDemerit() {
            var violationType = document.getElementById("violation").value;
            var demeritInput = document.getElementById("demerit");
            // Set demerit points based on violation type
            switch (violationType) {
                case "Parking":
                    demeritInput.value = 10;
                    break;
                case "Traffic":
                    demeritInput.value = 15;
                    break;
                case "Accident":
                    demeritInput.value = 20;
                    break;
                default:
                    demeritInput.value = "";
                    break;
            }
        }
    </script>
    <script src="../js/staff.js"></script>
</body>
</html>
