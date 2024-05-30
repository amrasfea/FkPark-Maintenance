<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}

$userId = $_SESSION['u_id'];

// Fetch user and profile information using JOIN
$userQuery = "SELECT u.u_id, u.u_email, u.u_type, p.p_name, p.p_matricNum, p.p_course, p.p_faculty, p.p_icNumber, p.p_email, p.p_phoneNum, p.p_address
              FROM user u
              JOIN profiles p ON u.u_id = p.u_id
              WHERE u.u_id = ?";
$stmt = $conn->prepare($userQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$stmt->close();

// Check if user data was retrieved
if (!$userData) {
    die("Error: No data found for the given user ID.");
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['p_name'];
    $matricNum = $_POST['p_matricNum'];
    $course = $_POST['p_course'];
    $faculty = $_POST['p_faculty'];
    $icNumber = $_POST['p_icNumber'];
    $email = $_POST['p_email'];
    $phoneNum = $_POST['p_phoneNum'];
    $address = $_POST['p_address'];

    $updateQuery = "UPDATE profiles SET p_name = ?, p_matricNum = ?, p_course = ?, p_faculty = ?, p_icNumber = ?, p_email = ?, p_phoneNum = ?, p_address = ? WHERE u_id = ?";
    $stmt = $conn->prepare($updateQuery);

    if ($stmt === false) {
        die("Error preparing statement: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("ssssssssi", $name, $matricNum, $course, $faculty, $icNumber, $email, $phoneNum, $address, $userId);

    if ($stmt->execute()) {
        // Redirect to the profile page after update
        header("Location: profilesection.php");
        exit();
    } else {
        die("Error executing statement: " . htmlspecialchars($stmt->error));
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <style>
        .field-input {
            border: none;
            width: 100%;
        }
    </style>
    <title>Edit Profile</title>
</head>
<body>
<?php include('studentProfile.php'); ?>
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div id="content" class="content content-full-width">
            <div class="profile-content">
               <div class="tab-content p-0">
                  <div class="tab-pane fade in active show" id="profile-about">
                     <form method="post" action="editstudentProfile.php">
                        <div class="table-responsive">
                            <table class="table table-profile">
                                <tbody>
                                    <tr class="highlight">
                                        <td class="field">Matric Number</td>
                                        <td><input type="text" name="p_matricNum" class="field-input" value="<?php echo htmlspecialchars($userData['p_matricNum']); ?>" required></td>
                                    </tr>
                                    <tr class="divider">
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td class="field">Full Name</td>
                                        <td><input type="text" name="p_name" class="field-input" value="<?php echo htmlspecialchars($userData['p_name']); ?>" required></td>
                                    </tr>
                                    <tr>
                                        <td class="field">IC Number</td>
                                        <td><input type="text" name="p_icNumber" class="field-input" value="<?php echo htmlspecialchars($userData['p_icNumber']); ?>" required></td>
                                    </tr>
                                    <tr>
                                        <td class="field">Email</td>
                                        <td><input type="email" name="p_email" class="field-input" value="<?php echo htmlspecialchars($userData['p_email']); ?>" required></td>
                                    </tr>
                                    <tr>
                                        <td class="field">Phone</td>
                                        <td><input type="text" name="p_phoneNum" class="field-input" value="<?php echo htmlspecialchars($userData['p_phoneNum']); ?>" required></td>
                                    </tr>
                                    <tr>
                                        <td class="field">Address</td>
                                        <td><input type="text" name="p_address" class="field-input" value="<?php echo htmlspecialchars($userData['p_address']); ?>" required></td>
                                    </tr>
                                    <tr>
                                        <td class="field">Course</td>
                                        <td><input type="text" name="p_course" class="field-input" value="<?php echo htmlspecialchars($userData['p_course']); ?>" required></td>
                                    </tr>
                                    <tr>
                                        <td class="field">Faculty</td>
                                        <td><input type="text" name="p_faculty" class="field-input" value="<?php echo htmlspecialchars($userData['p_faculty']); ?>" required></td>
                                    </tr>
                                    <tr class="divider">
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr class="highlight">
                                        <td class="field">&nbsp;</td>
                                        <td class="p-t-10 p-b-10">
                                            <button type="submit" class="btn btn-primary width-150">Update</button>
                                            <a class="btn btn-white btn-white-without-border width-150 m-l-5" href="profilesection.php">Cancel</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</body>
</html>

