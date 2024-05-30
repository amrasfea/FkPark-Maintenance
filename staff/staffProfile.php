<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}

$userId = $_SESSION['u_id'];

// Fetch user and profile information using JOIN
$userQuery = "SELECT u.u_id, u.u_email, u.u_type, p.p_name, p.p_icNumber, p.p_email, p.p_phoneNum, p.p_address, p.p_bodyNumber, p.p_department, p.p_position 
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
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <title>Unit Keselamtan Staff Profile</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <?php include('../navigation/staffNav.php'); ?>
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div id="content" class="content content-full-width">
            <div class="profile">
               <div class="profile-header">
                  <div class="profile-header-cover"></div>
                  <div class="profile-header-content">
                     <div class="profile-header-img">
                        <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="">
                     </div>
                     <div class="profile-header-info">
                        <h4 class="m-t-10 m-b-5"><?php echo htmlspecialchars($userData['p_name']); ?></h4>
                        <p class="m-b-10" style="color: black;"><?php echo htmlspecialchars($userData['u_type']); ?></p>
                        <a href="editstaffProfile.php" class="btn btn-sm btn-info mb-2" style="background-color:#063970; color:whitesmoke">Edit Profile</a>
                     </div>
                  </div>
                  <ul class="profile-header-tab nav nav-tabs">
                     <li class="nav-item"><a href="staffsection.php" target="__blank" class="nav-link_">Profile</a></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</body>
</html>