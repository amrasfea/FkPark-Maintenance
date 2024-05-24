<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Registered User</title>
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>List Registration</h2>
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
                    <th>ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Faculty</th>
                    <th>IC Number</th>
                    <th>Action</th> <!-- Added Action column -->
                </tr>
            </thead>
            <tbody>
                <!-- Example row, you should dynamically generate these rows with PHP from your database -->
                <tr>
                    <td>CB22040</td>
                    <td>Nur Amira Sofea Binti Othman</td>
                    <td>BCS Software</td>
                    <td>FKOMP</td>
                    <td>021007031014</td>
                    <td>
                    <button type="submit" name="view" class="view-button" href="">View</button>
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
