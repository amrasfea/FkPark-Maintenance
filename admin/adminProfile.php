<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <title>Admin Profile</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <?php include('../navigation/adminNav.php'); ?>
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div id="content" class="content content-full-width">
            <!-- begin profile -->
            <div class="profile">
               <div class="profile-header">
                  <!-- BEGIN profile-header-cover -->
                  <div class="profile-header-cover"></div>
                  <!-- END profile-header-cover -->
                  <!-- BEGIN profile-header-content -->
                  <div class="profile-header-content">
                     <!-- BEGIN profile-header-img -->
                     <div class="profile-header-img">
                        <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="">
                     </div>
                     <!-- END profile-header-img -->
                     <!-- BEGIN profile-header-info -->
                     <div class="profile-header-info">
                        <h4 class="m-t-10 m-b-5">Aliya ilyas</h4>
                        <p class="m-b-10">Administrator</p>
                        <!-- Change here: added href attribute with the URL of editProfileStudent.php -->
                        <a href="../admin/editAdminProfile.php" class="btn btn-sm btn-info mb-2">Edit Profile</a>
                     </div>
                     <!-- END profile-header-info -->
                  </div>
                  <!-- END profile-header-content -->
                  <!-- BEGIN profile-header-tab -->
                  <ul class="profile-header-tab nav nav-tabs">
                     <li class="nav-item"><a href="../admin/adminsection.php" target="__blank" class="nav-link_">Profile</a></li>
                  </ul>
                  <!-- END profile-header-tab -->
               </div>
            </div>
            <!-- end profile -->
            <!-- begin user-info -->
           
            
         </div>
      </div>
   </div>
</div>
</body>
</html>
