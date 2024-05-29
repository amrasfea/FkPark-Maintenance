<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add violation type</title>
    <!--FAVICON-->
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/violation.css">
</head>
<body>
<?php include('../navigation/staffNav.php'); ?>
<form>
    <label>Traffic violation:</label>
    <input type="text" name="vt_name" id="vt_name">
    <label>Demerit points:</label>
    <input type="number" name="vt_demeritPoints" id="vt_demeritPoints">
    <button type="submit" name="edit">Add</button>
</form>
</body>
</html>