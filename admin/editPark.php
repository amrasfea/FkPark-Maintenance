<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Park</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!--FAVICON-->
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>Edit Parking Space</h2>
        <form method="post" action="">
            <div class="form-group">
                
                <label for="pArea">Parking Area:</label>
                <input type="text" class="form-control" id="pArea" name="pArea">

                <label for="totalSpace">Total Space:</label>
                <input type="text" class="form-control" id="totalSpace" name="totalSpace">

                <label for="pID">Parking ID:</label>
                <input type="text" class="form-control" id="pID" name="pID">

                <label for="status">Status:</label>
                <input type="text" class="form-control" id="status" name="status">

                <label for="typeEvent">Type Event:</label>
                <input type="text" class="form-control" id="typeEvent" name="typeEvent">

                <label for="descripiton">Description:</label>
                <input type="text" class="form-control" id="descripiton" name="descripiton">

                <label for="time">Time:</label>
                <input type="text" class="form-control" id="time" name="time">

                
            </div>
            <div class="button-group">
                <button type="submit" name="cancel">Cancel</button>
                <button type="submit" name="save">Save</button>
            </div>
        </form>
    </div>
</body>
</html>
