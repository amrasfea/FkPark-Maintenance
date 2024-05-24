<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Vehicle Application</title>
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
</head>
<body>
    <?php include('../navigation/staffNav.php'); ?>
    <div class="container mt-5">
        <h2>List Vehicle Registration</h2>
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
                    <th>Vehicle ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>IC Number</th>
                    <th>Action</th> <!-- Added Action column -->
                </tr>
            </thead>
            <tbody>
                <!-- Example row, you should dynamically generate these rows with PHP from your database -->
                <tr>
                    <td>01</td>
                    <td>Nur Amira Sofea Binti Othman</td>
                    <td>BCS Software</td>
                    <td>021007031014</td>
                    <td>
                        <a href="../staff/viewVehicleApplication.php" class="view-button">View</a>
                        <a href="../staff/qrCode.php" class="edit-button">Approve</a>
                        <button type="submit" name="delete" class="delete-button" onclick="alert('Database deleted')">Reject</button>
                    </td>
                </tr>
                <!-- Additional rows go here -->
            </tbody>
        </table>
    </div>
</body>
</html>
