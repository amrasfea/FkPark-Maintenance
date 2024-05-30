
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summon List</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/list.css">
    <!--FAVICON-->
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
</head>
<body>
<?php include('../navigation/staffNav.php'); ?>
    <div class="container mt-3">
            <h2>Summon List</h2>
            <form method="post" action="" class="summon-list">
                <div class="form-group">
                    <div class="search-input-group">
                        <input type="date" class="date" id="date" name="date">
                        <button type="submit" class="search-button">Search</button>
                    </div>
                </div>
            </form>
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Summon ID</th>
                        <th>Vehicle Owner</th>
                        <th>Plate Number</th>
                        <th>Matric ID</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Action</th> <!-- Added Action column -->
                    </tr>
                </thead>
                @foreach ($query as $query)
                <tbody>
                    <!-- Example row, you should dynamically generate these rows with PHP from your database -->
                    <tr>
                        <td>12/4/2024</td>
                        <td>1010</td>
                        <td>Nur Alia Nadhirah</td>
                        <td>BJW 2020</td>
                        <td>CB22034</td>
                        <td>Zone B</td>
                        <td>Warning</td>
                        <td>
                            <button type="submit" name="edit" class="edit-button">Edit</button>
                            <button type="submit" name="delete" class="delete-button" onclick="alert('Database deleted')">Delete</button>
                            <a href="../staff/receipt.php">
                            <button type="submit" name="edit" class="edit-button" >View</button>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
</body>
</html>