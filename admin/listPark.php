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
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>List Park Space</h2>
        <form method="post" action="" class="search-form">
            <div class="form-group">
                <label for="searchArea">Park Area:</label>
                <div class="search-input-group">
                    <input type="text" class="form-control" id="searchArea" name="searchArea">
                    <button type="submit" name="search" class="search-button">Search</button>
                </div>
            </div>
        </form>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Area</th>
                    <th>Total Spaces</th>
                    <th>Parking ID</th>
                    <th>Status</th>
                    <th>Type Event</th>
                    <th>Description</th>
                    <th>Time</th>
                    <th>Action</th> <!-- Added Action column -->
                </tr>
            </thead>
            <tbody>
                <!-- Example row, you should dynamically generate these rows with PHP from your database -->
                <tr>
                    <td>Area 1</td>
                    <td>50</td>
                    <td>1234</td>
                    <td>Available</td>
                    <td>Concert</td>
                    <td>Reserved for concert attendees</td>
                    <td>2024-05-24 18:00</td>
                    <td>
                        <button type="submit" name="edit" class="edit-button">Edit</button>
                        <button type="submit" name="delete" class="delete-button" onclick="alert('Database deleted')">Delete</button>
                    </td>
                </tr>
                <!-- Additional rows go here -->
            </tbody>
        </table>
    </div>
</body>
</html>
