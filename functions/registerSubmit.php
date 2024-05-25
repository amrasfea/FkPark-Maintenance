<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Data</title>
</head>
<body>
    <?php
        //create connection
        include("database.php");

        //assign post to variable
        $name=$_POST["p_name"];
        $course=$_POST["p_course"];
        $faculty=$_POST["p_faculty"];
        $icNumber=$_POST["p_icNumber"];
        $address=$_POST["p_address"];
        $postcode=$_POST["p_postCode"];
        $country=$_POST["p_country"];
        $state=$_POST["p_state"];

        //create mysql query
        $query ="INSERT INTO user()";
    
    ?>
</body>
</html>