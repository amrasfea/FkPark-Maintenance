<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Park Space</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!--FAVICON-->
</head>
<body>
    <?php include('../navigation/studentNav.php'); ?>
    <div class="container mt-5">
        <h2>List Park Space</h2>
        <form method="post" action="" class="search-form">
            <div class="form-group">
                <div class="button-group">
                    <input type="date" name="parkDate">
                    <input type="time" name="parkTime">
                    <label for="searchArea">Park Area:</label>
                    <div class="search-input-group">
                        <input type="text" class="form-control" id="searchArea" name="searchArea">
                        <button type="submit" name="search" class="search-button">Search</button>
                    </div>
                </div>
            </div>