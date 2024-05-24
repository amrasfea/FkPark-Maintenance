<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <title>Edit Registration</title>
    <style>
        /* Form Styling */
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

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        /* Button Styling */
        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>Edit Registration</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="p_name">Name</label>
                <input type="text" id="p_name" name="p_name" required>
            </div>
            <div class="form-group">
                <label for="p_course">Course</label>
                <input type="text" id="p_course" name="p_course" required>
            </div>
            <div class="form-group">
                <label for="p_faculty">Faculty</label>
                <input type="text" id="p_faculty" name="p_faculty" required>
            </div>
            <div class="form-group">
                <label for="p_icNumber">IC Number</label>
                <input type="text" id="p_icNumber" name="p_icNumber" required>
            </div>
            <div class="form-group">
                <label for="p_address">Address</label>
                <input type="text" id="p_address" name="p_address" required>
            </div>
            <div class="form-group">
                <label for="p_postCode">Post Code</label>
                <input type="text" id="p_postCode" name="p_postCode" required>
            </div>
            <div class="form-group">
                <label for="p_country">Country</label>
                <input type="text" id="p_country" name="p_country" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
