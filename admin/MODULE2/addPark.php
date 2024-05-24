<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Park</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!--FAVICON-->
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>Parking Space Form</h2>
        <form method="post" action="">
            <div class="button-group">
                <button type="submit" name="newForm">New Form</button>
            </div>
            <div class="form-group">
                
                <label for="pArea">Parking Area:</label>
                <input type="text" class="form-control" id="pArea" name="pArea">

                <label for="spaceno">Space Number:</label>
                <input type="text" class="form-control" id="spaceno" name="spaceno">

                <label for="pID">Parking ID:</label>
                <input type="text" class="form-control" id="pID" name="pID">

                <label for="category">Category:</label>
                <input type="text" class="form-control" id="category" name="category">

                
            </div>
            <div class="button-group">
                <button type="submit" name="cancel">Cancel</button>
                <button type="submit" name="save">Save</button>
            </div>
        </form>
    </div>
</body>
</html>
