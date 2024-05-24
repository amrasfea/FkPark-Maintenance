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
<style>
    /* Body Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
}

/* Container Styling */
.container {
    max-width: 50%;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    font-weight: 600;
}

/* Form Styling */
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.form-control {
    width: auto; /* Changed to auto to allow inline display */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 10px;
}

.search-form {
    display: flex;
    align-items: center;
    justify-content: space-between; /* Added to evenly distribute elements */
    margin-bottom: 20px;
}

.input-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.label-inline {
    margin-bottom: 0; /* Remove bottom margin to align with input */
}

.search-button {
    padding: 10px 20px;
    border: none;
    background-color: #007bff;
    color: white;
    font-size: 14px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.search-button:hover {
    background-color: #0056b3;
}

</style>
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
