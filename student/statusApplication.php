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
        <form method="post" action="" class="search-form">
            <div class="form-group">
                <div class="search-input-group">
                    <input type="text" class="form-control" id="searchArea" name="searchArea">
                    <button type="submit" name="search" class="search-button">Search</button>
                </div>
            </div>
        </form>
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
                <!-- Example row, you should dynamically generate these rows with PHP from your database -->
                <tr>
                    <td>sofea</td>
                    <td>Car</td>
                    <td>Approved</td>
                    <td></td>
                </tr>
                <!-- Additional rows go here -->
            </tbody>
        </table>
    </div>
</body>
</html>
