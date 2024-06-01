<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <title>QR Code</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .qr-container {
            text-align: center;
            padding: 20px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .qr-container img {
            width: 300px;
            height: 300px;
        }
        .qr-container h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .qr-container p {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="qr-container">
        <h1>Parking QR Code</h1>
        <p>Scan the QR code to get parking space information</p>
        <?php
        $file = $_GET['file'];
        echo '<img src="' . htmlspecialchars($file) . '" alt="QR Code">';
        ?>
    </div>
</body>
</html>
