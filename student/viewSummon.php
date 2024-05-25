<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <!--FAVICON-->
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .receipt-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .qr-image {
            display: block;
            margin: 0 auto 10px;
            max-width: 120px;
            height: 150px;
        }
        .qr-description {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
            display: block;
        }
        .receipt {
            margin-top: 20px;
        }
        .receipt label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include('../navigation/studentNav.php'); ?>
    <img src="../img/qr demo.png" class="qr-image" alt="QR Code">
    <a href="#" class="qr-description">Scan QR for full details</a>
    <div class="receipt-container">
        <div class="receipt">
            <label>TYPE: CAR</label>
            <label>VEHICLE MODEL: MYVI</label>
            <label>VEHICLE BRAND: PERODUA</label>
            <label>VEHICLE PLATE NUMBER: BJW 2020</label>
            <label>PARKING LOCATION: ZONE A</label>
            <label>VIOLATION TYPE: NOT COMPLY IN CAMPUS TRAFFIC REGULATIONS</label>
            <label>DEMERIT POINT: 15</label>
            <label style="color: red; text-align:center">MESSAGES: PLEASE REPORT TO THE UNIT KESELAMATAN UNIVERSITI MALAYSIA PAHANG !!</label>
        </div>
    </div>
</body>
</html>

</html>