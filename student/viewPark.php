<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Park Space</title>
    <!-- EXTERNAL CSS -->
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!-- FAVICON -->
</head>

<body>
    <?php include('../navigation/studentNav.php'); ?>
    <div class="container mt-5">
        <h2>List Park Space</h2>
        <form method="post" action="" class="search-form">
            <div class="form-group">
                <div class="input-group">
                    <input type="date" name="parkDate" class="form-control">
                    <input type="time" name="parkTime" class="form-control">
                    <label for="searchArea" class="label-inline">Park Area:</label>
                    <input type="text" class="form-control" id="searchArea" name="searchArea">
                    <button type="submit" name="search" class="search-button">Search</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

/*student view*/
.input-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.label-inline {
    margin-bottom: 0; /* Remove bottom margin to align with input */
}

.input-group .form-control,
.input-group .search-button {
    flex: 1;
    margin-bottom: 0;
}

.input-group input[type="date"],
.input-group input[type="time"] {
    width: auto;
    flex: none;
}