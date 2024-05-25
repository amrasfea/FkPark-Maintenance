<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    // define variables and set to empty values
        $name = $email = $gender = $comment = $website = "";

        if ($_SERVER["login"] == "POST") {
        $email = $_POST["email"];
        $password =$_POST["password"];
        $user = $_POST["user"];
            if($user ==="admin"){
                header("location:../admin/adminDashboard.php");
                exit();
            }else if($user ==="staff"){
                header("location:../staff/staffHome.php");
                exit();
            }else{
                header("location:../student/studentProfile.php");
                exit();
            }
        }
    ?>
</body>
</html>