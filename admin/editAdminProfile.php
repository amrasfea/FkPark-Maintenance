<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .field-input {
            border: none;
            /* Remove background-color: transparent; */
            width: 100%;
        }
    </style>
    <title>Profile</title>
</head>
<body>
<?php include('../admin/adminProfile.php'); ?>
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div id="content" class="content content-full-width">
            <!-- begin profile-content -->
            <div class="profile-content">
               <!-- begin tab-content -->
               <div class="tab-content p-0">
                  <!-- begin #profile-about tab -->
                  <div class="tab-pane fade in active show" id="profile-about">
                     <!-- begin table -->
                     <div class="table-responsive">
                        <table class="table table-profile">
                         
                           <tbody>
                              <tr class="highlight">
                                 <td class="field">Staff Body Number</td>
                                 <td><input type="text" class="field-input" value="123456"></td>
                              </tr>
                              <tr class="divider">
                                 <td colspan="2"></td>
                              </tr>
                              <tr>
                                 <td class="field">Full Name</td>
                                 <td><input type="text" class="field-input" value="Alia"></td>
                              </tr>
                              <tr>
                                 <td class="field">IC Number</td>
                                 <td><input type="text" class="field-input" value="123456-78-9012"></td>
                              </tr>
                              <tr>
                                 <td class="field">Address</td>
                                 <td><input type="text" class="field-input" value="123 Main Street"></td>
                              </tr>
                              <tr class="divider">
                                 <td colspan="2"></td>
                              </tr>
                              <tr class="highlight">
                                 <td class="field">&nbsp;</td>
                                 <td class="p-t-10 p-b-10">
                                    <button type="submit" class="btn btn-primary width-150">Update</button>
                                    <button type="submit" class="btn btn-white btn-white-without-border width-150 m-l-5" href="../student/studentProfile.php">Cancel</button>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <!-- end table -->
                  </div>
                  <!-- end #profile-about tab -->
               </div>
               <!-- end tab-content -->
            </div>
            <!-- end profile-content -->
         </div>
      </div>
   </div>
</div>
</body>
</html>
